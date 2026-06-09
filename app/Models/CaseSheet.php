<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class CaseSheet extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'patient_id',
        'doctor_id',
        'opd_id',
        'ipd_id',
        'visit_type',
        'symptoms',
        'diagnosis',
        'clinical_notes',
        'status'

    ];

    public $incrementing = false;

    protected $keyType = 'string';

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
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }

    public function opd()
    {
        return $this->belongsTo(Opd::class, 'opd_id');
    }

    public function ipd()
    {
        return $this->belongsTo(IPDAdmission::class, 'ipd_id');
    }
}