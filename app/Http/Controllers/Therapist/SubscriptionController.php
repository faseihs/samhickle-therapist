<?php

namespace App\Http\Controllers\Therapist;

use App\Model\Subscription;
use App\Model\SubscriptionPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Nikolag\Square\Facades\Square;

class SubscriptionController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:therapist');
    }

    public function getSubscription(Request $request){
        if(Auth::user()->canUse())
            return redirect('/therapist/dashboard');
        if($request->session()->has('planId'))
        {
            $id=$request->session()->get('planId');
            $request->session()->remove('planId');
        }
        else if($request->has('id'))
            $id=$request->id;
        if(isset($id))
            $plan= SubscriptionPlan::findOrFail($id);
        else $plan = SubscriptionPlan::where('name','Plan 1')->first();
        $request->session()->put('selectedPlan',$plan->id);
        return view('therapist.subscribe',compact(['plan']));
    }

    public function postSubscription(Request $request){
        $id=$request->session()->get('selectedPlan');
        $request->session()->remove('selectedPlan');
        $plan=SubscriptionPlan::findOrFail($id);
        $amount = $plan->price*100; //Is in USD currency and is in smallest denomination (cents). ($amount = 5000 == 50 Dollars)

        $formNonce = $request->nonce; //nonce reference => https://docs.connect.squareup.com/articles/adding-payment-form

        $location_id = env('APP_ENV')=='local'?env('SQAURE_SANDBOX_LOCATION_ID'):env('SQUARE_APPLICATION_LOCATION_ID'); //$location_id is id of a location from Square

        $currency = 'GBP'; //available currencies => https://docs.connect.squareup.com/api/connect/v2/?q=currency#type-currency

        $options = [
            'amount' => $amount,
            'card_nonce' => $formNonce,
            'location_id' => $location_id,
            'currency' => $currency
        ];

        try{
            Square::charge($options); // Simple charge
        }
        catch (\Exception $e){
            return Redirect::back()->with('deleted','Transaction not successful');
        }

        try{
            DB::beginTransaction();

            $sub= new Subscription();
            $sub->subscription_plan_id=$plan->id;
            $sub->therapist_id=Auth::user()->id;
            $sub->type='monthly';
            $sub->price=$plan->price;
            $sub->start=Carbon::now()->toDateTimeString();
            if($plan->id==1)
                $end=Carbon::now()->addYear(3)->toDateTimeString();
            else if($plan->id==2)
            $end=Carbon::now()->addYear(1)->toDateTimeString();
            else if($plan->id==3)
            $end=Carbon::now()->addYear(5)->toDateTimeString();
            $sub->end=$end;
            $sub->save();
            DB::commit();
            return redirect('/therapist/edit-profile');
        }
        catch(\Exception $e){
            DB::rollback();
            if(env('APP_ENV')=='local')
                dd($e);
            else abort(500);
        }

    }
}
