<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Patient;
use App\Models\Staff;

class Vital extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'vitals';

    public $incrementing = false;
    protected $keyType = 'string';

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
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Staff::class, 'nurse_id');
    }
}