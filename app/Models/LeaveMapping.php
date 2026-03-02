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
        'leave_type_id', 'priority', 'employee_status', 'accrual_frequency', 
        'accrual_value', 'leave_nature', 'carry_forward_allowed', 'status'
    ];

    protected $casts = [
        'employee_status' => 'array', // Automatically handles JSON for multi-select [cite: 82, 171]
        'carry_forward_allowed' => 'boolean', 
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

    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class); 
    }
}
