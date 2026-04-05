<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
class Medicine extends Model
{
    use HasUuids;
    
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'medicine_name',
        'generic_name',
        'category',
        'manufacturer',
        'status'
    ];

    public function batches()
    {
        return $this->hasMany(MedicineBatch::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    // One medicine has many batches


    public function consultations()
    {
        return $this->belongsToMany(
            Consultation::class,
            'consultation_medicines',
            'medicine_id',
            'consultation_id'
        )->withPivot('dosage', 'frequency', 'duration', 'instructions');
    }

}