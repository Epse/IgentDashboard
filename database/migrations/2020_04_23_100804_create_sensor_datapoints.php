<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorDatapoints extends Migration
{
    public function up()
    {
        Schema::create('sensor_datapoints', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('sensor_id');
            $table->foreign('sensor_id')
                  ->references('id')
                  ->on('sensors')
                  ->onDelete('cascade');
            // 4 digits before the decimal point, certainly enough for temps
            // And probably enough for pressure
            $table->double('value');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_datapoints');
    }
}
