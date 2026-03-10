<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreOperative extends Model
{

    protected $fillable = [

        'surgery_id',
        'bp',
        'heart_rate',
        'allergies',
        'consent_obtained',
        'fasting_status',
        'instructions',
        'risk_factors'

    ];

}