<?php

namespace App\Http\Controllers;

use App\Model\Therapist;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
        $this->middleware('guest:web')->except('logout');
        $this->middleware('guest:therapist')->except('logout');
    }
    public function redirect(Request $request,$provider)
    {
        if($request->has('type'))
            $request->session()->put('type',$request->type);
        return Socialite::driver($provider)->redirect();
    }
    public function therapistRedirect($provider)
    {
        $redirectUrl='http://therapist.com/t-login/'.$provider.'/callback';
        return Socialite::driver($provider)->redirectUrl($redirectUrl)->redirect();
    }

    public function Callback(Request $request,$provider)
    {
        $type='user';
        if($request->session()->has('type')){
            if($request->session()->get('type')=='therapist') {
                $type = 'therapist';
                $request->session()->remove('type');
            }
        }
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        if($type=='user')
            $users       =   User::where(['email' => $userSocial->getEmail()])->first();
        else $users       =   Therapist::where(['email' => $userSocial->getEmail()])->first();

        if($users){
            Auth::login($users);
            return redirect('/');
        }
        else return redirect($type=='user'?'login':'/therapist/login')->with('deleted','User Not Present');
    }
    public function therapistCallback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   Therapist::where(['email' => $userSocial->getEmail()])->first();
        if($users){
            Auth::login($users);
            return redirect('/');
        }
        else return redirect('/therapist/login')->with('deleted','User Not Present');
    }
}
