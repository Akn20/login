<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DoctorAuditLog extends Model
{
    protected $table = 'doctor_audit_logs';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',

        'patient_id',

        'doctor_id',

        'module_name',

        'action_type',

        'old_value',

        'new_value',

        'ip_address',

        'device_info',

    ];

    protected $casts = [

        'old_value' => 'array',

        'new_value' => 'array',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (! $model->id) {

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

    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }
}