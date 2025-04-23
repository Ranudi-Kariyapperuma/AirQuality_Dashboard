<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
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
        'so2'
    ];
    
    protected $dates = ['timestamp'];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function getAqiCategory()
    {
        if ($this->aqi <= 50) return ['category' => 'Good', 'color' => 'green'];
        if ($this->aqi <= 100) return ['category' => 'Moderate', 'color' => 'yellow'];
        if ($this->aqi <= 150) return ['category' => 'Unhealthy for Sensitive Groups', 'color' => 'orange'];
        if ($this->aqi <= 200) return ['category' => 'Unhealthy', 'color' => 'red'];
        if ($this->aqi <= 300) return ['category' => 'Very Unhealthy', 'color' => 'purple'];
        return ['category' => 'Hazardous', 'color' => 'maroon'];
    }
} 