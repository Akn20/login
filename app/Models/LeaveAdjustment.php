<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeaveAdjustment extends Model
{
    protected $table = 'leave_adjustments';

    protected $fillable = [
        'staff_id',
        'leave_type_id',
        'credit',
        'debit',
        'remarks',
        'year'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    //  Relationship with Staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    //  Relationship with LeaveType
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }
}