<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Surgery extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';
    protected $fillable = [

        'id',
        'patient_id',
        'surgery_type',
        'surgery_date',
        'surgery_time',
        'ot_room',
        'surgeon_id',
        'assistant_doctor_id',
        'anesthetist_id',
        'priority',
        'notes'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function surgeon()
    {
        return $this->belongsTo(Staff::class, 'surgeon_id');
    }
}
