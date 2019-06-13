<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddContentToProfiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            //
            $table->longText('about')->nullable();
            $table->longText('types_of_therapy')->nullable();
            $table->longText('deliveries')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('therapist_profiles', function (Blueprint $table) {
            //
            $table->dropColumn('about');
            $table->dropColumn('types_of_therapy');
            $table->dropColumn('deliveries');
        });
    }
}
