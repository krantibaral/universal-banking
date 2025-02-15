<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transfer;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Yajra\DataTables\DataTables;

class TransferController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Payment';
        $this->resources = 'admin.transfers.';
        $this->route = 'transfers.';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        if ($request->ajax()) {
            $query = Transfer::with(['sender', 'receiver'])->orderBy('id', 'DESC');

            if ($user->hasRole('Customer') && $user->customer) {
                // Show transactions where the user is the receiver (with status 'completed')
                // OR where the user is the sender
                $query->where(function ($q) use ($user) {
                    $q->where('receiver_id', $user->customer->id)
                        ->where('status', 'completed')
                        ->orWhere('sender_id', $user->id);
                });
            } elseif ($user->hasRole('Admin')) {
                // Admin can see all transactions, no additional filtering needed
            } else {
                // For other roles, show only transactions where they are the sender
                $query->where('sender_id', $user->id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('sender', function ($row) {
                    return $row->sender->name ?? 'N/A';
                })
                ->editColumn('receiver', function ($row) {
                    return optional($row->receiver->user)->name ?? 'N/A';
                })
                ->editColumn('amount', function ($row) {
                    return number_format($row->amount, 2);
                })
                ->editColumn('status', function ($row) {
                    return ucfirst($row->status);
                })
                ->addColumn('action', function ($data) {
                    return view('admin.templates.index_actions', [
                        'id' => $data->id,
                        'route' => $this->route,
                    ])->render();
                })
                ->rawColumns(['action', 'status', 'sender', 'receiver'])
                ->make(true);
        }

        $info = $this->crudInfo();
        return view($this->indexResource(), $info);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();
        $senderBalance = 0; // Initialize sender's balance

        if ($user->hasRole('Customer') && $user->customer) {
            // Get the sender's balance
            $senderBalance = $user->customer->total_balance;
        }

        $users = User::all();  // Fetch all users (senders)
        $customers = Customer::all();  // Fetch all customers (receivers)

        $info = $this->crudInfo();
        $info['users'] = $users;
        $info['customers'] = $customers;
        $info['senderBalance'] = $senderBalance;  // Pass the sender's balance to the view

        return view($this->createResource(), $info);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        // Validation rules (applies to all users)
        $validationRules = [
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:customers,id',
            'amount' => ['required', 'numeric', 'min:0.00000001'], // Define as an array
            'memo' => 'nullable|string|max:255',
        ];

        // Add amount validation ONLY for Customers
        if ($user->hasRole('Customer') && $user->customer) {
            $senderBalance = $user->customer->total_balance; // Use total_balance instead of balance
            $validationRules['amount'][] = function ($attribute, $value, $fail) use ($senderBalance) {
                if ($value > $senderBalance) {
                    $fail("The transfer amount cannot exceed your available balance of " . number_format($senderBalance, 8));
                }
            };
        }

        // Validate the request
        $request->validate($validationRules);

        // Create the transfer
        $transfer = Transfer::create([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'memo' => $request->memo,
            'status' => $request->status ?? 'pending', // Default to 'pending'
        ]);

        // Deduct from sender's balance (only for Customers)
        if ($user->hasRole('Customer') && $user->customer) {
            $user->customer->decrement('total_balance', $request->amount); // Use total_balance instead of balance
        }

        // Add to receiver's balance (for all transfers)
        $receiver = Customer::find($request->receiver_id);
        $receiver->increment('total_balance', $request->amount);

        return redirect()->route($this->indexRoute())->with('success', 'Transfer created successfully.');
    }
    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Transfer::with(['sender', 'receiver'])->findOrFail($id);
        return view($this->showResource(), $info);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Transfer::with(['sender', 'receiver'])->findOrFail($id);
        $info['users'] = User::all();  // For selecting a new sender
        $info['customers'] = Customer::all();  // For selecting a new receiver

        return view($this->editResource(), $info);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'sender_id' => 'required|exists:users,id',
            'receiver_id' => 'required|exists:customers,id',
            'amount' => 'required|numeric|min:0.00000001',
            'memo' => 'nullable|string|max:255',
            'cryptocurrency' => 'required|in:bitcoin,trump,dogecoin', // Validate cryptocurrency type
        ]);

        $transfer = Transfer::findOrFail($id);
        $transfer->update([
            'sender_id' => $request->sender_id,
            'receiver_id' => $request->receiver_id,
            'amount' => $request->amount,
            'memo' => $request->memo,
            'status' => $request->status ?? $transfer->status, // Default to existing status if not provided
            'cryptocurrency' => $request->cryptocurrency, // Update cryptocurrency type
        ]);

        return redirect()->route($this->indexRoute())->with('success', 'Transfer updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $transfer = Transfer::findOrFail($id);
            $transfer->delete();
        } catch (\Exception $e) {
            return redirect()->route($this->indexRoute())->with('error', 'Failed to delete transfer.');
        }

        return redirect()->route($this->indexRoute())->with('success', 'Transfer deleted successfully.');
    }
}