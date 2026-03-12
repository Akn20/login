<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftRotation extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'staff_id',
        'first_shift_id',
        'second_shift_id',
        'rotation_days',
        'start_date',
        'status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function firstShift()
    {
        return $this->belongsTo(Shift::class,'first_shift_id');
    }

    public function secondShift()
    {
        return $this->belongsTo(Shift::class,'second_shift_id');
    }
}