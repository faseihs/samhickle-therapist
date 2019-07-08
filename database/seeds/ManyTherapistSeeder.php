<?php

use App\Model\Group;
use App\Model\Subscription;
use Illuminate\Database\Seeder;

class ManyTherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<=100;$i++){
            $therapist = new \App\Model\Therapist();
            $therapist->name="Therapist ".$i;
            $therapist->email="therapist".$i."@gmail.com";
            $therapist->password=bcrypt('12345678');

            $therapist->save();
            $profile = new \App\Model\TherapistProfile();
            $profile->therapist_id=$therapist->id;
            $profile->latitude=51.507;
            $profile->longitude=0.127;
            $profile->save();
            $therapist->problems()->sync([11,12,13,14,15,16,17,18,19,20,21,22,23]);
            $therapist->groups()->sync([1,2,3,4,5,6,7,8,9,10]);


            $sub= new Subscription();
            $plan_id=2;
            $sub->subscription_plan_id=$plan_id;
            $sub->therapist_id=$therapist->id;
            $sub->type='yearly';
            $sub->price=399;
            $sub->start=Carbon::now()->toDateTimeString();
            if($plan_id==1)
                $end=Carbon::now()->addYear(3)->toDateTimeString();
            else if($plan_id==2)
                $end=Carbon::now()->addYear(1)->toDateTimeString();
            else if($plan_id==3)
                $end=Carbon::now()->addYear(5)->toDateTimeString();
            $sub->end=$end;
            $sub->save();
        }
    }
}
