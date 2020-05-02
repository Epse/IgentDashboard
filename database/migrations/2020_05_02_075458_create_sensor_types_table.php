<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorTypesTable extends Migration
{
    public function up()
    {
        Schema::create('sensor_types', function (Blueprint $table) {
            $table->id();

            $table->string('type');
            $table->string('unit')->default('no-units');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensor_types');
    }
}
