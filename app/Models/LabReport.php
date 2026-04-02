<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LabReport extends Model
{
    // UUID settings
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'sample_id',
        'result_data',
        'status',
        'entered_at'
    ];

    // JSON casting
    protected $casts = [
        'result_data' => 'array'
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

    // 🔗 Relationship
    public function sample()
    {
        return $this->belongsTo(SampleCollection::class, 'sample_id');
    }
}