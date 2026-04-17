<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Staff;

class HourlyPayApproval extends Model
{
    use SoftDeletes;

    protected $table = 'hourly_pay_approvals';

    protected $fillable = [

        'staff_id',
        'work_type_code',
        'payroll_month',
        'attendance_date',
        'approved_hours',
        'shift_code',
        'day_type',
        'source_type',
        'approval_status',
        'approved_by',
        'approved_date',
        'locked_for_payroll',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_id',
            'id'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            Staff::class,
            'approved_by',
            'id'
        );
    }
}