<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThingsToProfile extends Migration
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
            $table->longText('personal_statement')->nullable();
            $table->longText('education_statement')->nullable();
            $table->longText('price_statement')->nullable();
            $table->longText('address')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('contact')->nullable();
            $table->string('dp')->nullable();
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
            $table->dropColumn('personal_statement');
            $table->dropColumn('education_statement');
            $table->dropColumn('price_statement');
            $table->dropColumn('address');
            $table->dropColumn('postal_code');
            $table->dropColumn('contact');
            $table->dropColumn('dp');
        });
    }
}
