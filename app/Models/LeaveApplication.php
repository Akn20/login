<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LeaveApplication extends Model
{
    use SoftDeletes;

    protected $table = 'leave_applications';
protected $fillable = [
    'staff_id',
    'leave_type_id',
    'leave_duration',
    'from_date',
    'to_date',
    'leave_days',
    'reason',
    'attachment',
    'status',
    'balance_before',
    'balance_after',
    'current_approval_level'
];

    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class,'leave_type_id');
    }
    public function approvals()
    {
        return $this->hasMany(LeaveRequestApprovals::class, 'leave_request_id');
    }
}