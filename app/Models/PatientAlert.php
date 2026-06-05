<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PatientAlert extends Model
{
    use HasUuids;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [

        'hospital_id',
        'patient_id',
        'alert_type',
        'title',
        'message',
        'related_id',
        'related_type',
        'alert_date',
        'is_read',

    ];

    /**
     * Patient Relationship
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}