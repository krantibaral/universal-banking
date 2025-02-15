<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CustomerController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Customers';
        $this->resources = 'admin.customers.';
        $this->route = 'customers.';
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Customer::with('user')->orderBy('id', 'DESC')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($row) {
                    return '<p class="text-dark-75 font-weight-normal d-block font-size-h6">' . ($row->user->name ?? 'N/A') . '</p>';
                })
                ->editColumn('email', function ($row) {
                    return $row->user->email ?? 'N/A';
                })
                ->addColumn('verified', function ($row) {
                    return $row->verified ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';
                })
                ->addColumn('action', function ($data) {
                    return view('admin.templates.index_actions', [
                        'id' => $data->id,
                        'route' => $this->route
                    ])->render();
                })
                ->rawColumns(['action', 'name', 'verified']) // Add 'verified' to allow HTML rendering
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
        $info = $this->crudInfo();
        return view($this->createResource(), $info);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'verified' => 'nullable|boolean', // Ensure 'verified' is validated (it may or may not be set)
        ]);

        // Create user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign 'Customer' role to the user
        $user->assignRole('customer');

        // Generate unique account number
        $accountNumber = 'ACC' . strtoupper(Str::random(10));

        // If the admin is creating the customer, set 'verified' to 1, otherwise default to 0
        $verified = $request->has('verified') ? $request->verified : 0;

        // Create customer record with the user_id, account number, and verified status
        Customer::create([
            'user_id' => $user->id,
            'account_number' => $accountNumber,
            'verified' => $verified,  // Store the verified status
        ]);

        return redirect()->route($this->indexRoute())->with('success', 'Customer created successfully.');
    }



    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Customer::with('user')->findOrFail($id);
        return view($this->showResource(), $info);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $info = $this->crudInfo();
        $info['item'] = Customer::with('user')->findOrFail($id);
        return view($this->editResource(), $info);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $user = $customer->user;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'account_number' => 'nullable|string|max:20|unique:customers,account_number,' . $id,
            'verified' => 'nullable|boolean', // Ensure verified is a boolean value
        ]);

        // Update user details
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        // Update customer details, including verified status
        $customer->update([
            'account_number' => $request->account_number ?? $customer->account_number,
            'verified' => $request->has('verified') ? (bool) $request->verified : $customer->verified, // Update verified if provided
        ]);

        return redirect()->route($this->indexRoute())->with('success', 'Customer updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);

            // Delete the associated user
            $customer->user->delete();

            // Delete the customer record
            $customer->delete();
        } catch (\Exception $e) {
            return redirect()->route($this->indexRoute())->with('error', 'Failed to delete customer.');
        }

        return redirect()->route($this->indexRoute())->with('success', 'Customer deleted successfully.');
    }
}
