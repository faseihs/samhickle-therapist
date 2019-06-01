<?php

namespace App\Http\Controllers\Auth;

use App\Model\Group;
use App\Model\Problem;
use App\Model\Therapist;
use App\Model\TherapistProfile;
use App\User;
use App\Http\Controllers\Controller;
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }


    public function showTherapistRegister()
    {
        $problems = Problem::all();
        $groups = Group::all();
        return view('auth.therapist.register', ['url' => 'therapist','problems'=>$problems,'groups'=>$groups]);
    }

    public function therapistRegister(Request $request){
        //dd($request->all());
        $this->validate($request,[
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:therapists'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'contact'=>['required'],
            'problems'=>['array'],
            'groups'=>['array'],
            'address_latitude'=>['required'],
            'address_longitude'=>['required']
        ]);
        try{
            DB::beginTransaction();
            $therapist= new Therapist();
            $therapist->name=$request->name;
            $therapist->email=$request->email;
            $therapist->password=bcrypt($request->password);
            $therapist->save();
            $profile = new  TherapistProfile();
            $profile->therapist_id=$therapist->id;
            $profile->contact=$request->contact;
            $profile->latitude=$request->latitude;
            $profile->longitude=$request->longitude;
            $therapist->problems()->sync($request->problems);
            $therapist->groups()->sync($request->groups);
            DB::commit();
            if (Auth::guard('therapist')->attempt(['email' => $therapist->email, 'password' => $request->password], false)) {
                return redirect()->intended('/therapist/dashboard');
            }
            return redirect('/therapist/dashboard');
        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }


    }
}
