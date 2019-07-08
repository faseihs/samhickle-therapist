<?php

namespace App\Http\Controllers\Auth;

use App\Model\Group;
use App\Model\Problem;
use App\Model\Subscription;
use App\Model\Therapist;
use App\Model\TherapistProfile;
use App\Model\UserProfile;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user= User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $profile=new UserProfile();
        $profile->user_id=$user->id;
        $profile->save();
        return $user;
    }
    public function showAdminTherapistRegister(Request $request)
    {
        if(Auth::guard('web')->check() || Auth::guard('therapist')->check())
            return redirect('/');
        return view('auth.admin-register');
    }


    public function showTherapistRegister(Request $request)
    {
        if(Auth::guard('web')->check() || Auth::guard('therapist')->check())
            return redirect('/');

        $problems = Problem::all();
        $groups = Group::all();
        if($request->has('plan'))
            $request->session()->put('planId',$request->plan);
        else return redirect('/plans');
        return view('auth.therapist.register', ['url' => 'therapist','problems'=>$problems,'groups'=>$groups]);
    }

    public function therapistRegister(Request $request){
        //dd($request->all());
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:therapists'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'problems'=>['array'],
            'groups'=>['array'],
        ]);
        try{
            DB::beginTransaction();
            $therapist= new Therapist();
            $therapist->email=$request->email;
            $therapist->password=bcrypt($request->password);
            $therapist->save();
            $profile = new  TherapistProfile();
            $profile->therapist_id=$therapist->id;
            $profile->save();
            $therapist->problems()->sync($request->problems);
            $therapist->groups()->sync($request->groups);
            DB::commit();
            if (Auth::guard('therapist')->attempt(['email' => $therapist->email, 'password' => $request->password], false)) {
                return redirect()->intended('/therapist/subscription');
            }
            return redirect('/therapist/subscription');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }


    }
    public function adminTherapistRegister(Request $request){
        //dd($request->all());
        $this->validate($request,[
            'email' => ['required', 'string', 'email', 'max:255', 'unique:therapists'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'problems'=>['array'],
            'groups'=>['array'],
        ]);
        try{
            DB::beginTransaction();
            $therapist= new Therapist();
            $therapist->email=$request->email;
            $therapist->password=bcrypt($request->password);
            $therapist->save();
            $profile = new  TherapistProfile();
            $profile->therapist_id=$therapist->id;
            $profile->save();
            $therapist->problems()->sync($request->problems);
            $therapist->groups()->sync($request->groups);
            $sub= new Subscription();
            $plan_id=2;
            $sub->subscription_plan_id=$plan_id;
            $sub->therapist_id=$therapist->id;
            $sub->type='free';
            $sub->price=0;
            $sub->start=Carbon::now()->toDateTimeString();
            if($plan_id==1)
                $end=Carbon::now()->addYear(3)->toDateTimeString();
            else if($plan_id==2)
                $end=Carbon::now()->addYear(1)->toDateTimeString();
            else if($plan_id==3)
                $end=Carbon::now()->addYear(5)->toDateTimeString();
            $sub->end=$end;
            $sub->save();
            DB::commit();
            if (Auth::guard('therapist')->attempt(['email' => $therapist->email, 'password' => $request->password], false)) {
                return redirect()->intended('/therapist/subscription');
            }
            return redirect('/therapist/subscription');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }


    }

    public function userApiRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact'=>['required','string','min:11']

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();
            $user= User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $profile=new UserProfile();
            $profile->user_id=$user->id;
            $profile->contact=$request->contact;
            $profile->save();
            DB::commit();
            Auth::guard('web')->login($user);
            return response()->json("Data",200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }

    }

    public function therapistApiRegister(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],

        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        try{
            DB::beginTransaction();
            $user= Therapist::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
            ]);
            $profile=new TherapistProfile();
            $profile->therapist_id=$user->id;
            $profile->save();
            DB::commit();
            Auth::guard('therapist')->login($user);
            return response()->json("Data",200);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json($e->getMessage(),500);
        }

    }

}
