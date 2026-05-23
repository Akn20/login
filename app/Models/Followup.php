<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Followup extends Model
{

    protected $table = 'follow_ups';
    protected $fillable = [
        'consultation_id',
        'patient_id',
        'doctor_id',
        'follow_up_date',
        'status',
        'remarks'
    ];

    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }
}
