<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalCertification extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [

        'id',

        'employee_id',
        'employee_name',
        'department',
        'designation',

        'certificate_number',
        'certificate_type',

        'issue_date',
        'valid_from',
        'valid_until',

        'diagnosis_reason',
        'medical_remarks',

        'doctor_name',
        'registration_number',
        'hospital_name',

        'signature_status',
        'signed_by',
        'signed_at',
        'action_history',
         'status',
        'remarks'
    ];
}