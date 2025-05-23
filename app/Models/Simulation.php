<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simulation extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_running', 'frequency', 'aqi_min', 'aqi_max', 'pattern_variation'
    ];
}
