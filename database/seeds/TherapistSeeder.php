<?php

use Illuminate\Database\Seeder;

class TherapistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $therapist = new \App\Model\Therapist();
        $therapist->name="Adam Sandler";
        $therapist->email="adamsandler@gmail.com";
        $therapist->password=bcrypt('123456');
        $therapist->save();
        $profile = new \App\Model\TherapistProfile();
        $profile->therapist_id=$therapist->id;
        $profile->latitude=51.507;
        $profile->longitude=0.127;
        $profile->save();

        $therapist = new \App\Model\Therapist();
        $therapist->name="Matt Sandler";
        $therapist->email="mattsandler@gmail.com";
        $therapist->password=bcrypt('123456');
        $therapist->save();
        $profile = new \App\Model\TherapistProfile();
        $profile->therapist_id=$therapist->id;
        $profile->latitude=51.509;
        $profile->longitude=0.129;
        $profile->save();

    }
}
