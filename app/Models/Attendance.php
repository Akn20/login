<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Attendance extends Model
{
    
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
        'user_id',
        'date',
        'checkin_time',
        'checkout_time',
        'checkin_lat',
        'checkin_lng',
        'distance',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
