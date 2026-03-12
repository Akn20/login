<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Vital extends Model
{
    use SoftDeletes;

    protected $table = 'vitals';

    protected $fillable = [
        'institution_id',
        'patient_id',
        'nurse_id',
        'temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'pulse_rate',
        'respiratory_rate',
        'spo2',
        'blood_sugar',
        'weight',
        'recorded_at'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}