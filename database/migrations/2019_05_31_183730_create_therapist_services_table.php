<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTherapistServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('therapist_id');
            $table->foreign('therapist_id')->references('id')->on('therapists')
                ->onDelete('cascade');
            $table->string('service');
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('therapist_services');
    }
}
