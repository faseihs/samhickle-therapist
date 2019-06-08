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
            'description'=>'One Time Fee|Lifetime Availability|3 Years Listing|24/7 Support',
            'price'=>'299'
        ]);
        \App\Model\SubscriptionPlan::create([
            'name'=>'Plan 1',
            'description'=>'One Time Fee|Lifetime Availability|1 Year Listing|24/7 Support',
            'price'=>'699'
        ]);
        \App\Model\SubscriptionPlan::create([
            'name'=>'Plan 3',
            'description'=>'One Time Fee|Lifetime Availability|5 Years Listing|24/7 Support',
            'price'=>'899'
        ]);
    }
}
