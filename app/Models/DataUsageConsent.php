<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DataUsageConsent extends Model
{
    protected $table = 'data_usage_consents';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',
        'patient_id',
        'purpose',
        'consent_status',
        'remarks',
        'document_path',
        'consent_taken_at',
        'recorded_by'

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

                $model->id = Str::uuid();
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
}