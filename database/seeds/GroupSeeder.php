<?php

use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //
        $groups = [
            'Adult',
            'Other adult',
            'Young Person',
            'Couples',
            'EAP',
            'Organisation',
            'Groups',
            'Trainee',
            'Children',
            'Families'

        ];

        foreach ($groups as $group){
            \App\Model\Problem::create(['name'=>$group]);
        }
    }
}
