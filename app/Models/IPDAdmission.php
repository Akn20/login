<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IPDAdmission extends Model
{
    protected $table = 'ipd_admissions';

    protected $fillable = [
        'id',
        'admission_id',
        'patient_id',
        'doctor_id',
        'department_id',
        'ward_id',
        'room_id',
        'bed_id',
        'admission_type',
        'status',
        'admission_date',
        'advance_amount',
        'insurance_flag',
        'insurance_provider',
        'policy_number',
        'notes',
        'created_by'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->id = (string) Str::uuid();

            $count = self::count() + 1;

            $model->admission_id =
                'IPD-' . date('Y') . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);
        });
    }
    public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
}

public function doctor()
{
    return $this->belongsTo(\App\Models\Staff::class, 'doctor_id');
}

public function department()
{
    return $this->belongsTo(\App\Models\Department::class, 'department_id');
}

public function bed()
{
    return $this->belongsTo(\App\Models\Bed::class, 'bed_id');
}

public function ward()
{
    return $this->belongsTo(\App\Models\Ward::class, 'ward_id');
}
public function room()
{
    return $this->belongsTo(\App\Models\Room::class, 'room_id');
}
}
