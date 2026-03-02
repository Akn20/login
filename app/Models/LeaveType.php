<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class LeaveType extends Model
{
    use SoftDeletes;

    protected $table = 'leave_types';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'display_name',
        'description',
        'allow_half_day',
        'min_leave_unit',
        'max_continuous_days',
        'count_weekends',
        'count_holidays',
        'sandwich_enabled',
        'sandwich_applies_on',
        'approval_required',
        'approval_level',
        'allow_backdate',
        'max_backdate_days',
        'attendance_code'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}