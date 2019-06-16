<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    public function redirectTo(){
        return  url()->previous();
    }
    public function getGuard(){
        if(Auth::guard('admin')->check())
        {return "admin";}
        elseif(Auth::guard('web')->check())
        {return "web";}
        elseif(Auth::guard('therapist')->check())
        {return "therapist";}
    }

    public function logout(Request $request)
    {

        Auth::guard($this->getGuard())->logout();

        $request->session()->flush();

        $request->session()->regenerate();
        return redirect('/');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(Request $request)
    {
        if(Auth::guard('web')->check() || Auth::guard('therapist')->check())
            return redirect('/');
        if($path=Input::get('path'))
            $request->session()->put('path',$path);
        return view('auth.login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin.login', ['url' => 'admin']);
    }

    public function adminLogin(Request $request)
    {
        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:8'
        ]);

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/admin');
        }
        return back()->withInput($request->only('email', 'remember'));
    }
    public function showTherapistLogin()
    {
        if(Auth::guard('web')->check() || Auth::guard('therapist')->check())
            return redirect('/');
        return view('auth.therapist.login', ['url' => 'therapist']);
    }

    public function therapistLogin(Request $request)
    {

        $this->validate($request, [
            'email'   => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::guard('therapist')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return redirect()->intended('/therapist/dashboard');
        }
        return back()->withInput($request->only('email', 'remember'))->withErrors(['email'=>'Your credentials do not match our records']);
    }
    protected function authenticated(Request $request, $user)
    {
        return $request->session()->has('path')?redirect($request->session()->get('path')):redirect('/user/dashboard');
    }


    public function userApiLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'password' => 'required|min:8'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return response()->json("Data",200);
        }
        else return response()->json("Error",500);
    }
    public function therapistApiLogin(Request $request){
        $validator = Validator::make($request->all(), [
            'email'   => 'required|email',
            'password' => 'required|min:8'

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        if (Auth::guard('therapist')->attempt(['email' => $request->email, 'password' => $request->password], $request->get('remember'))) {

            return response()->json("Data",200);
        }
        else return response()->json("Error",500);
    }


}
