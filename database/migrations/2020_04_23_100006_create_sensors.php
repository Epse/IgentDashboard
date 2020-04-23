<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensors extends Migration
{
    public function up()
    {
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('unit')->default('no-units');
            $table->string('name')->unique();
            $table->string('type');
            $table->string('room');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensors');
    }
}
