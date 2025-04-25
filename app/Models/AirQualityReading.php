<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirQualityReading extends Model
{
    use HasFactory;

    protected $fillable = [
        'sensor_id',
        'aqi',
        'pm25',
        'pm10',
        'co',
        'no2',
        'o3',
        'so2',
    ];

    /**
     * Relationship: Each air quality reading belongs to a sensor.
     */
    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }
}
