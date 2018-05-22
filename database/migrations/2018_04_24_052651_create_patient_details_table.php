<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patient_details', function (Blueprint $table) {

            $table->increments('id');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('street');
            $table->string('suburb');
            $table->string('state');
            $table->string('post');
            $table->string('contact');
            $table->String('age');
            $table->String('gender');
            $table->string('disease')->nullable();
            $table->string('email')->unique();
            $table->string('detailsFilled')->default(0);
            $table->unsignedInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('Patients')->onDelete('cascade');
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
        Schema::dropIfExists('patient_details');

    }
}
