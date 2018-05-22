<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notification', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('doctor_id')->nullable();
            $table->unsignedInteger('patient_id')->nullable();
            $table->unsignedInteger('appointment_id')->nullable();
            $table->string('notification_patient', 300)->nullable();
            $table->string('notification_doctor', 300)->nullable();
            $table->string('notification_admin', 300)->nullable();
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
        Schema::dropIfExists('notification');
    }
}
