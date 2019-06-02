<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTherapistEducationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_education', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('therapist_id');
            $table->foreign('therapist_id')->references('id')->on('therapists')
                ->onDelete('cascade');
            $table->string('college');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapist_education');
    }
}
