<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorRadiologyNote extends Model
{
     protected $fillable = [
        'doctor_id',
        'patient_id',
        'radiology_report_id',
        'interpretation_notes'
    ];

    public function report()
    {
        return $this->belongsTo(RadiologyReport::class,'radiology_report_id');
    }
}
