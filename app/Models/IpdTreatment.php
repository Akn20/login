<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdTreatment extends Model
{
    protected $table = 'ipd_treatments';

    protected $fillable = [
        'ipd_id',
        'treatment'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}