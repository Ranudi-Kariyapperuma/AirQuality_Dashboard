<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sensor_id',
        'latitude',
        'longitude',
        'is_active',
        'description'
    ];

    public function readings()
    {
        return $this->hasMany(AirQualityReading::class);
    }

    public function latestReading()
    {
        return $this->hasOne(AirQualityReading::class)->latest();
    }

    public function airQualityReadings()
    {
        return $this->hasMany(AirQualityReading::class);
    }

} 