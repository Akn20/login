<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Patient;
use App\Models\Consultation;

class LabRequest extends Model
{
    use HasUuids;

    protected $table = 'lab_requests';

    protected $fillable = [
        'patient_id',
        'consultation_id',
        'test_name',
        'status'
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
}