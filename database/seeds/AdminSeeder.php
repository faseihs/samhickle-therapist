<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('admins')->insert([
            'name'=>'Super Admin',
            'email'=>'superadmin@admin.com',
            'password'=>bcrypt('12345678'),
            'is_super'=>true,
            'created_at'=>\Carbon\Carbon::now()->toDateTimeString(),
            'updated_at'=>\Carbon\Carbon::now()->toDateTimeString()
        ]);
    }
}
