<?php

namespace App\Http\Controllers\Therapist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    //trait for handling reset Password
    use ResetsPasswords;
    public function showResetForm(Request $request, $token = null)
    {
        return view('therapist.password.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    //Seller redirect path
    protected $redirectTo = '/';

    public function broker()
    {
        return Password::broker('therapists');
    }

    //returns authentication guard of seller
    protected function guard()
    {
        return Auth::guard('therapist');
    }
}
