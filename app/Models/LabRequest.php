<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Patient;
use App\Models\Consultation;
use App\Models\LabTest;
use App\Models\Staff;
use App\Models\SampleCollection;

class LabRequest extends Model
{
    use HasUuids;

    protected $table = 'lab_requests';

    protected $fillable = [
        'patient_id',
        'consultation_id',
        'test_name',
        'priority',
        'status',
        'doctor_id',
        'department',
        'clinical_notes',
        'doctor_remarks',

    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Lab Request belongs to Patient
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // Lab Request belongs to Consultation
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }


    public function labTest()
    {
        return $this->belongsTo(LabTest::class);
    }

    // Lab Request belongs to Doctor (Staff)
    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }

    public function sample()
    {
        return $this->hasOne(SampleCollection::class);
    }

}