<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MedicationReviewReminder extends Model
{
    use HasUuids;

    protected $fillable = [

        'id',

        'consultation_medicine_id',

        'patient_id',

        'doctor_id',

        'review_date',

        'status',

        'remarks'
    ];
}