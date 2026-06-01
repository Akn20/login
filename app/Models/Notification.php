<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    public $incrementing = false;
    public $timestamps = true;
    protected $keyType = 'string';

    

    protected $fillable = [
    'user_id',
    'patient_id',
    'type',
    'title',
    'message',
    'priority',
    'reference_id',
    'is_read'
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}