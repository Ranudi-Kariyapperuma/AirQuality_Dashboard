<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirQualityReading extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'datetime',
    ];
    

    protected $fillable = [
        'sensor_id',
        'aqi',
        'pm25',
        'pm10',
        'co',
        'no2',
        'o3',
        'so2',
        'created_at',
        'updated_at',
    ];

    /**
     * Relationship: Each air quality reading belongs to a sensor.
     */
    public function sensor()
    {
        return $this->belongsTo(Sensor::class, 'sensor_id');
    }
}
