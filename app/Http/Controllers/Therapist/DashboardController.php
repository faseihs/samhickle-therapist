<?php

namespace App\Http\Controllers\Therapist;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:therapist');
    }

    public function index(){
       return view('therapist.dashboard.index');
    }

    public function editProfile(){
        $therapist = Auth::user();
        $profile=$therapist->profile;
        return view('therapist.dashboard.edit-profile',compact(['therapist','profile']));
    }

    public function updateProfile(Request $request){
        dd($request->all());
    }

}
