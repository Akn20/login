<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Holiday extends Model
{
    use SoftDeletes;
    protected $keyType = 'string';

    public $incrementing = false;
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'details',
        'document',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
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