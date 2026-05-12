<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DischargePreparation extends Model
{
    protected $fillable = [
        'id',
        'hospital_id',
        'patient_id',
        'ipd_admission_id',
        'nurse_id',
        'checklist',
        'belongings_status',
        'status',
        'is_ready',
        'prepared_at'
    ];

    protected $casts = [
        'checklist' => 'array',
        'belongings_status' => 'boolean',
        'is_ready' => 'boolean'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relationship
    public function ipd()
    {
        return $this->belongsTo(IPDAdmission::class, 'ipd_admission_id');
    }
}
