<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use Str;

class Otp extends Model
{
    use SoftDeletes;
     protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
   protected $fillable = [
        'mobile',
        'otp',
        'expires_at',
        'attempts',
        'resends',
        'used',
        'last_sent_at'
    ];
}

