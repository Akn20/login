<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SurgeryConsent extends Model
{
    protected $table = 'surgery_consents';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',
        'patient_id',
        'surgery_id',
        'consent_status',
        'procedure_explained',
        'risks_explained',
        'remarks',
        'document_path',
        'consent_taken_at',
        'recorded_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function surgery()
    {
        return $this->belongsTo(Surgery::class);
    }
}