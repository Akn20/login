<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CriticalValueAlert extends Model
{
    protected $fillable = [
        'report_id',
        'parameter_name',
        'value',
        'threshold_min',
        'threshold_max',
        'doctor_id',
        'status',
        'acknowledged_at',
        'acknowledged_by'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) \Str::uuid();
        });
    }

    public function report()
    {
        return $this->belongsTo(LabReport::class);
    }
}
