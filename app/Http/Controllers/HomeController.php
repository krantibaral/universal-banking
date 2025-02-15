<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transfer;
use App\Models\CryptoRate;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $totalBalance = 0;
        $cryptoBalances = [
            'bitcoin' => 0,
            'dogecoin' => 0,
            'trump' => 0,
        ];

        if ($user->hasRole('Customer') && $user->customer) {
            // Fetch the total balance and cryptocurrency balances
            $totalBalance = $user->customer->total_balance;
            $cryptoBalances = [
                'bitcoin' => $user->customer->bitcoin_balance,
                'dogecoin' => $user->customer->dogecoin_balance,
                'trump' => $user->customer->trump_balance,
            ];
        }

        $cryptoRate = CryptoRate::first();

        $todayRates = [
            'bitcoin' => $cryptoRate ? $cryptoRate->bitcoin : 0,
            'dogecoin' => $cryptoRate ? $cryptoRate->dogecoin : 0,
            'trump' => $cryptoRate ? $cryptoRate->trump : 0,
        ];

        return view('home', compact('totalBalance', 'cryptoBalances', 'todayRates'));
    }

    public function buyCrypto(Request $request)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01', // Validate quantity
            'crypto_type' => 'required|in:bitcoin,dogecoin,trump',
        ]);

        // Get the authenticated user’s customer record
        $customer = Auth::user()->customer;

        // Get the crypto rate from the database
        $cryptoRate = CryptoRate::first();
        $cryptoTypes = [
            'bitcoin' => $cryptoRate->bitcoin,
            'dogecoin' => $cryptoRate->dogecoin,
            'trump' => $cryptoRate->trump,
        ];

        // Calculate the total cost based on the quantity and the current rate
        $quantity = $request->quantity;
        $cryptoPrice = $cryptoTypes[$request->crypto_type];
        $totalCost = $quantity * $cryptoPrice;

        // Check if the user has enough balance
        if ($customer->total_balance < $totalCost) {
            return redirect()->back()->with('error', 'Insufficient balance to complete the transaction.');
        }

        // Deduct the total cost from the user’s total balance
        $customer->total_balance -= $totalCost;

        // Update the specific cryptocurrency balance (e.g., bitcoin_balance)
        // Instead of adding the quantity, add the total cost to the cryptocurrency balance
        $cryptoBalanceField = $request->crypto_type . '_balance';
        $customer->$cryptoBalanceField += $totalCost;

        // Save the updated customer record
        $customer->save();

        // Redirect back with success message
        return redirect()->route('home')->with('success', 'Cryptocurrency purchased successfully!');
    }
}
