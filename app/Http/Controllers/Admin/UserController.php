<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function __construct()
    {
        $this->title = 'Users';
        $this->resources = 'admin.users.';
        $this->route = 'users.';
    }

    public function profile()
    {
        $user = auth()->user();

        // Check if the user has the 'Customer' role
        if (!$user->hasRole('Customer')) {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }

        // Get the associated customer data
        $customer = $user->customer;  // Assuming the user has a 'customer' relationship

        $info = $this->crudInfo();
        $info['item'] = $user;
        $info['customer'] = $customer;  // Add customer data to the view info

        return view($this->showResource(), $info);
    }


    // Method to show password change form
    public function changePasswordForm()
    {
        return view('admin.users.change_password');
    }

    // Method to handle password change logic
    public function changePassword(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        $user = auth()->user();

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('home')->with('success', 'Password updated successfully.');
    }

    public function editProfile()
    {
        $user = auth()->user();

        if (!$user->hasRole('Customer')) {
            return redirect()->route('home')->with('error', 'You are not authorized to view this page.');
        }

        return view('admin.users.edit_profile', compact('user'));
    }


    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // Validate the input data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id, // Ignore the current email
        ]);

        // Update the user's name and email
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('users.editProfile')->with('success', 'Profile updated successfully.');
    }


}
