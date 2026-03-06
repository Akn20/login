<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Holiday extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'holidays';
    public $incrementing = false; // Required for UUID
    protected $keyType = 'string';
    

    protected $casts = [
    'start_date' => 'date',
    'end_date'   => 'date',
];

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'details',
        'document',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}