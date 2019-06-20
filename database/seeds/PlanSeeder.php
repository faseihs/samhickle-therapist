<?php

use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        \App\Model\SubscriptionPlan::create([
            'name'=>'Plan 2',
            'description'=>'3 Year Listing|Free Bookings - No Other Costs|Onli...',
            'price'=>'699'
        ]);
        \App\Model\SubscriptionPlan::create([
            'name'=>'Plan 1',
            'description'=>'1 Year Listing|Free Bookings - No Other Costs|Onli...',
            'price'=>'299'
        ]);
        \App\Model\SubscriptionPlan::create([
            'name'=>'Plan 3',
            'description'=>'5 Year Listing|Free Bookings - No Other Costs|Onli...',
            'price'=>'899'
        ]);
    }
}
