<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftAssignment extends Model
{
    protected $fillable = [
        'staff_id',
        'shift_id',
        'start_date',
        'end_date',
        'status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}