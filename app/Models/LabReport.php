<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class LabReport extends Model
{
    // UUID settings
    use SoftDeletes;
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'sample_id',
        'result_data',
        'status',
        'entered_at'
    ];


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
    public function files()
    {
        return $this->hasMany(ReportFile::class, 'lab_report_id');
    }

    public function sample()
    {
        return $this->belongsTo(SampleCollection::class, 'sample_id');
    }
}