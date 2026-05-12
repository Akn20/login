<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PatientInsurance extends Model
{
    protected $table = 'patient_insurances';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'insurance_type',
        'provider_name',
        'policy_number',
        'policy_holder_name',
        'valid_from',
        'valid_to',
        'sum_insured',
        'tpa_name',
        'status',
        'created_by',
    ];

    // Auto UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

   public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
}

    // Relationship
    public function documents()
    {
        return $this->hasMany(InsuranceDocument::class, 'insurance_id');
    }

    
}