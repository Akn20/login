<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Opd extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'opd';

    protected $fillable = [
        'appointment_id',
        'patient_id',
        'doctor_id',
        'visit_date',
        'visit_status',
    ];

    protected $casts = [
        'visit_date' => 'date',
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

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
