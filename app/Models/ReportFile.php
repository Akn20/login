<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ReportFile extends Model
{
    protected $table = 'report_files';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'lab_report_id',
        'file_path',
        'file_name',
        'file_type',
        'version',
        'is_main',
        'uploaded_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function report()
    {
        return $this->belongsTo(LabReport::class, 'lab_report_id');
    }
}