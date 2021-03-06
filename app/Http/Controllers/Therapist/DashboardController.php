<?php

namespace App\Http\Controllers\Therapist;

use App\Model\Group;
use App\Model\Problem;
use App\Model\TherapistEducation;
use App\Model\TherapistService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class DashboardController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:therapist');
        $this->middleware('therapistCanUse');
    }

    public function index(){
        return redirect('/therapist/edit-profile');

        return view('therapist.dashboard.index');
    }

    public function editProfile(){
        $therapist = Auth::user();
        $profile=$therapist->profile;
        $problems = Problem::all();
        $groups = Group::all();
        $services=$therapist->services;
        $specializations = $therapist->specializations;
        $educations=$therapist->educations;

        return view('therapist.dashboard.edit-profile',compact(['educations','therapist','profile','problems','groups','services','specializations']));
    }

    public function updateProfile(Request $request){
        //dd($request->all());
        $therapist=Auth::user();
        $profile=$therapist->profile;
        $this->validate($request,[
            'name'=>'required|string',
            'email'=>'unique:therapists,email,'.$therapist->id,
            'contact'=>'nullable|string',
            'dp'=>'nullable|image',
            'city'=>'nullable|string',
            'state'=>'nullable|string',
            'address'=>'nullable|string',
            'postal_code'=>'nullable|string',
            'problems'=>['array'],
            'groups'=>['array'],
            'address_latitude'=>['nullable'],
            'address_longitude'=>['nullable'],
            'address_address'=>['nullable','string'],
        ]);
        try{
            DB::beginTransaction();
            $therapist->name=$request->name;
            $therapist->email=$request->email;
            if($request->contact!=null) {
                $profile->contact=$request->contact;
            }
            if($request->has('delPic')){
                $p=$profile->dp;
                try {
                    unlink(public_path($p));
                }

                catch(\Exception $e){

                }
                $profile->dp=null;
            }
            if($file=$request->file('dp')){
                if($profile->dp){
                    $p=$profile->dp;
                    try {
                        unlink(public_path($p));
                    }

                    catch(\Exception $e){

                    }
                    $profile->dp=null;
                }
                $name=time().$file->getClientOriginalName();
                $path='images/therapists/'.$therapist->id;
                $file->move($path,$name);
                $profile->dp=$path.'/'.$name;
            }
            $profile->city=$request->city;
            $profile->state=$request->state;
            $profile->address=$request->address;
            $profile->postal_code=$request->postal_code;
            $profile->latitude=$request->address_latitude;
            $profile->longitude=$request->address_longitude;
            $profile->location_name=$request->address_address;
            $profile->about=$request->about;
            $profile->types_of_therapy=$request->types_of_therapy;
            $profile->deliveries=$request->deliveries;
            $profile->price_statement=$request->price_statement;
            $profile->personal_statement=implode(",",$request->youAre);
            $profile->education_statement=$request->education_statement;
            $therapist->problems()->sync($request->problems);
            $therapist->groups()->sync($request->groups);
            $therapist->save();
            $profile->save();

            foreach ($request->newEducations as $e){
                if($e){
                    $education = new TherapistEducation(['description'=>'none','college'=>$e]);
                    $therapist->educations()->save($education);
                }

            }

            foreach ($request->newPrices as $index=>$p){
                if($p && $request->newMinutes[$index]){
                    $service= new TherapistService(['price'=>$p,'service'=>$request->newMinutes[$index]]);
                    $therapist->services()->save($service);
                }
            }
            DB::commit();

        }
        catch(\Exception $e){
            DB::rollback();
            dd($e);
        }
        if($request->has('password') && $request->password!=null){
            $this->validate($request,[
                'password' => ['required','string','min:8','confirmed']
            ]);

            if(Hash::check($request['password'],$therapist->getAuthPassword()))
                return Redirect::back()->withInput(Input::all())->withErrors(['','New Password same to old password']);
            $therapist->password=bcrypt($request->password);
            $therapist->save();
        }
        return redirect('/therapist/edit-profile')
            ->with('success','Updated');
    }

    public function reviews(Request $request){
        $therapist=Auth::user();
        $type="latest";
        if($request->get('type'))
            $type=$request->type;
        if($type=='latest')
            $reviews=$therapist->reviews()->where('created_at','>=',Carbon::now()->subDay(7)->toDateString())
                ->orderBy('created_at','DESC')->paginate(10);
        else $reviews=$therapist->reviews()->where('created_at','<=',Carbon::now()->subDay(7)->toDateString())
            ->orderBy('created_at','DESC')->paginate(10);

        return view('therapist.dashboard.reviews',
            compact([
                'therapist',
                'reviews',
                'type'
            ]));

    }

}
