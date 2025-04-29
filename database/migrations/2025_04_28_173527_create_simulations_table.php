<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimulationsTable extends Migration
{
    public function up()
    {
        Schema::create('simulations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_running')->default(false);
            $table->integer('frequency')->default(5); // e.g., every 5 minutes
            $table->integer('aqi_min')->default(0);
            $table->integer('aqi_max')->default(500);
            $table->integer('pattern_variation')->default(0); // 0-100 slider
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('simulations');
    }
}
