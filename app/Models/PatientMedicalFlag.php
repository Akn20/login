<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedicalFlag extends Model
{
      protected $fillable = [
        'patient_id',
        'type',
        'title',
        'description',
        'severity'
    ];
}
