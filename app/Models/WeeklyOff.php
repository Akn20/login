<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WeeklyOff extends Model
{
    use SoftDeletes;
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