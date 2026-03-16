<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'shift_name',
        'start_time',
        'end_time',
        'grace_minutes',
        'break_minutes',
        'remarks',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Shift Assignments
     */
    public function assignments()
    {
        return $this->hasMany(ShiftAssignment::class);
    }
}