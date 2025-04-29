<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AlertThreshold extends Model
{
    protected $fillable = ['level', 'min_aqi', 'max_aqi', 'message'];

}
