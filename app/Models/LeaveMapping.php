<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LeaveMapping extends Model
{
    use SoftDeletes;

    protected $keyType = 'string'; 
    public $incrementing = false; 

   protected $fillable = [
    'leave_type_id', 'priority', 'employee_status', 'designations', 
    'accrual_frequency', 'accrual_value', 'leave_nature', 
    'carry_forward_allowed', 'carry_forward_limit', 'carry_forward_expiry_days',
    'min_leave_per_application', 'max_leave_per_application', 'status','encashment_allowed', 
    'encashment_trigger','gender',
    'employment_type',
];

protected $casts = [
    'employee_status' => 'array',
    'designations' => 'array',
    'carry_forward_allowed' => 'boolean',
    'employee_status' => 'array',
    'encashment_allowed' => 'boolean',
];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Required for UUID primary keys 
            }
        });
    }

   public function leaveType() {
    return $this->belongsTo(LeaveType::class, 'leave_type_id');
}
}
