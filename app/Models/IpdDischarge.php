<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdDischarge extends Model
{
    protected $table = 'ipd_discharges';

    protected $fillable = [
        'ipd_id',
        'diagnosis',
        'treatment_given',
        'medication_advice',
        'follow_up',
        'doctor_name',
        'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}