<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostOperative extends Model
{

    protected $fillable = [

        'surgery_id',
        'procedure_performed',
        'duration',
        'blood_loss',
        'patient_condition',
        'recovery_instructions',
        'complication_type',
        'complication_description'

    ];

    public function surgery()
    {
        return $this->belongsTo(Surgery::class, 'surgery_id');
    }

}