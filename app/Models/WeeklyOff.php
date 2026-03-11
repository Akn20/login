<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeeklyOff extends Model
{

    protected $fillable = [
        'staff_id',
        'week_day',
        'status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

}