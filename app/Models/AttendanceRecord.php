<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;

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
    //added by sushan for api
    public function department()
{
    return $this->belongsTo(
        Department::class,
        'department_id'
    );
}
public function designation()
{
    return $this->belongsTo(
        Designation::class,
        'designation_id'
    );
}

}