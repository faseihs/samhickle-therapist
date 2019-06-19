<?php

namespace App\Http\Controllers\Therapist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//Trait
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    //Sends Password Reset emails
    use SendsPasswordResetEmails;

    public function showLinkRequestForm()
    {
        return view('therapist.password.email');
    }

    //Password Broker for Seller Model
    public function broker()
    {
        return Password::broker('therapists');
    }
}
