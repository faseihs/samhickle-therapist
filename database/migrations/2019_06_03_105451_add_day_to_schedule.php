<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDayToSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapist_schedules', function (Blueprint $table) {
            //
            $table->string('day_name')->nullable();
            $table->unsignedInteger('day_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapist_schedules', function (Blueprint $table) {
            //
            $table->dropColumn('day');
            $table->dropColumn('day_number');
        });
    }
}
