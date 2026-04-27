<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdPrescription extends Model
{
    protected $table = 'ipd_prescriptions';

   protected $fillable = [
    'id', //added
    'ipd_id',
    'patient_id',
    'doctor_id',
    'prescription_date'
];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}