<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoRate;
use Illuminate\Http\Request;

class CryptoRateController extends Controller
{
    /**
     * Display the crypto rates form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $cryptoRate = CryptoRate::first(); 
        return view('admin.crypto-rates.index', compact('cryptoRate'));
    }

    /**
     * Update the crypto rates.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        // Validate the request
        $request->validate([
            'bitcoin' => 'required|numeric',
            'dogecoin' => 'required|numeric',
            'trump' => 'required|numeric',
        ]);

        // Get or create the crypto rate record
        $cryptoRate = CryptoRate::firstOrNew();

        // Update values
        $cryptoRate->bitcoin = $request->bitcoin;
        $cryptoRate->dogecoin = $request->dogecoin;
        $cryptoRate->trump = $request->trump;

        // Save the updated record
        $cryptoRate->save();

        // Redirect back with success message
        return redirect()->route('crypto-rates.index')->with('success', 'Crypto rates updated successfully!');
    }
}
