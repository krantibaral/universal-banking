<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Handle post-login verification check.
     */
    // protected function authenticated(Request $request, $user)
    // {
    //     if (!$user->hasVerifiedEmail()) {
    //         // Auth::logout(); // Log out the user

    //         // Resend email verification notification
    //         $user->sendEmailVerificationNotification();

    //         // Redirect to login with a warning message
    //         return redirect('/email/verify')->with('warning', 'You need to verify your email. A new verification link has been sent.');
    //     }
    // }

}
