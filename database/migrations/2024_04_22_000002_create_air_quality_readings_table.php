<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('air_quality_readings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sensor_id')->constrained()->onDelete('cascade');
            $table->decimal('aqi', 5, 2);
            $table->decimal('pm25', 5, 2);
            $table->decimal('pm10', 5, 2);
            $table->decimal('co', 5, 2);
            $table->decimal('no2', 5, 2);
            $table->decimal('o3', 5, 2);
            $table->decimal('so2', 5, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('air_quality_readings');
    }
}; 