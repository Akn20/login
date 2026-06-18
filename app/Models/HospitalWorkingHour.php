<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HospitalWorkingHour extends Model
{
    protected $fillable = [
        'hospital_id',
        'opening_time',
        'closing_time',
        'break_start',
        'break_end',
        'emergency_24x7',
        'status'
    ];
}