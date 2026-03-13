<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{

    protected $fillable = [
        'employee_id',
        'department_id',
        'designation_id',
        'shift_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'late_minutes',
        'overtime_minutes'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class,'employee_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

}