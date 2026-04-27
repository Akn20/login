<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScanRequest extends Model
{
    protected $fillable = [
        'patient_id',
        'scan_type_id',
        'body_part',
        'reason',
        'priority',
        'doctor_id',
        'status'
    ];

    // ✅ ADD THIS
    protected $keyType = 'string';
    public $incrementing = false;

    // ✅ AUTO UUID GENERATION
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function scanType()
    {
        return $this->belongsTo(\App\Models\ScanType::class);
    }

    public function doctor()
    {
        return $this->belongsTo(\App\Models\User::class, 'doctor_id');
    }

    public function uploads()
    {
        return $this->hasMany(\App\Models\ScanUpload::class);
    }

    public function schedule()
{
    return $this->hasOne(ScanSchedule::class);
}
}