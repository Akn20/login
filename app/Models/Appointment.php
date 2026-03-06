<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'department_id',
        'appointment_date',
        'appointment_time',
        'appointment_status',
        'consultation_fee',
        'hospital_id',
        'receptionist_user_id',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'consultation_fee' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function receptionist()
    {
        return $this->belongsTo(User::class, 'receptionist_user_id');
    }

    public function opd()
    {
        return $this->hasOne(Opd::class);
    }
}
