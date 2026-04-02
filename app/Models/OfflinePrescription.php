<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflinePrescription extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'prescription_number',
        'patient_name',
        'patient_phone',
        'doctor_name',
        'clinic_name',
        'prescription_date',
        'uploaded_prescription',
        'status'
    ];
}
