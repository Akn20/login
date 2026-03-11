<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeaveRequests extends Model
{
    protected $table = 'leave_requests';
    public $incrementing = false;
    protected $keyType = 'string'; 
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Required for UUID primary keys 
            }
        });
    }

    protected $fillable = [
        'employee_id',
        'leave_type_id',
        'from_date',
        'to_date',
        'from_session',
        'to_session',
        'total_leave_days',
        'purpose',
        'attachment',
        'calculated_leave_days',
        'balance_before',
        'balance_after',
        'status',
        'current_approval_level'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class,'employee_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
     public function approvals()
{
    return $this->hasMany(LeaveRequestApprovals::class,'leave_request_id');
}
}