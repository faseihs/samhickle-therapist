<?php

use Illuminate\Database\Seeder;

class ProblemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $problems = [
            'Anxiety',
            'Depression',
            'Trauma',
            'Relationships',
            'Family and Children',
            'Stress',
            'Work Identity',
            'Culture and spirituality',
            'Health related issues',
            'Coaching',
            'Addiction',
            'Self-harm',
            'Eating disorders'
        ];

        foreach ($problems as $problem){
            \App\Model\Problem::create(['name'=>$problem]);
        }
    }
}
