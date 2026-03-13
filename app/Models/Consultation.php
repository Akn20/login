<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\Medicine;


class Consultation extends Model
{
    protected $table = 'consultations';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'referral_doctor_id',
        'symptoms',
        'diagnosis',
        'tests',
        'consultation_date'
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

    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }

    public function medicines()
    {
        return $this->belongsToMany(
            Medicine::class,
            'consultation_medicines',
            'consultation_id',
            'medicine_id'
        )->withPivot('dosage', 'frequency', 'duration', 'instructions');
    }
    public function referralDoctor()
    {
        return $this->belongsTo(Staff::class, 'referral_doctor_id');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }
}