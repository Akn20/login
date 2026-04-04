<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SampleCollection extends Model
{
        protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'lab_request_id',
        'patient_id',
        'sample_id',
        'barcode',
        'collection_time',
        'status',
        'rejection_reason'
    ];

    // Auto-generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function labRequest()
    {
        return $this->belongsTo(LabRequest::class, 'lab_request_id');
    }

    public function labReport()
    {
        return $this->hasOne(LabReport::class, 'sample_id');
    }

}
