<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescriptionFormatSetting extends Model
{
    protected $fillable = [
        'hospital_id',
        'hospital_logo',
        'header_text',
        'footer_text',
        'show_doctor_name',
        'show_doctor_qualification',
        'show_registration_number',
        'show_patient_age',
        'show_patient_gender',
        'show_date',
        'paper_size',
        'orientation',
        'margins',
        'status'
    ];
}