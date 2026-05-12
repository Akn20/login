<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InsuranceDocument extends Model
{
    protected $table = 'insurance_documents';

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    public $timestamps = false;

    protected $fillable = [
        'id',
        'insurance_id',
        'document_type',
        'file_path',
        'uploaded_at',
    ];

    public function insurance()
    {
        return $this->belongsTo(PatientInsurance::class, 'insurance_id');
    }

    public function documents()
{
    return $this->hasMany(InsuranceDocument::class, 'insurance_id');
}
}