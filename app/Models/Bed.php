<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bed extends Model
{
    use SoftDeletes;
    public $incrementing = false;      
    protected $keyType = 'string';     
    protected $fillable = [
    'bed_code',
    'ward_id',
    'room_number',
    'bed_type',
    'status',
    ];

        protected static function boot()
        {
            parent::boot();

            static::creating(function ($model) {
                if (!$model->getKey()) {
                    $model->{$model->getKeyName()} = (string) Str::uuid();
                }
            });
        }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
