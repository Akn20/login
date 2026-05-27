<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClinicalNote extends Model
{
    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'report_id',
        'clinical_observation',
        'diagnosis',
        'follow_up_advice'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function booted()
    {
        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }

        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function report()
    {
        return $this->belongsTo(LabReport::class, 'report_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }
}