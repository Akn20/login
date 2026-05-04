<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InsuranceConsent extends Model
{
    protected $table = 'insurance_consents';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',
        'patient_id',
        'insurance_id',
        'consent_text',
        'consent_status',
        'consent_given_at',
        'document',
        'recorded_by'
    ];

    protected $casts = [

        'consent_given_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Auto UUID
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {

                $model->id = (string) Str::uuid();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function insurance()
    {
        return $this->belongsTo(
            PatientInsurance::class,
            'insurance_id'
        );
    }

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'recorded_by'
        );
    }
}