<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('alert_thresholds', function (Blueprint $table) {
            $table->id();
            $table->string('level'); // e.g., Good, Moderate, Unhealthy
            $table->integer('min_aqi');
            $table->integer('max_aqi');
            $table->string('message');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alert_thresholds');
    }
};
