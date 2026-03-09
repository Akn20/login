<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'role_id',
        'mpin',
        'status',
        'failed_attempts',
        'locked_until',
        'is_enrolled',
    ];

    protected $hidden = [
        'mpin',
    ];

    public function getAuthPassword()
    {
        return $this->mpin;
    }

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id', 'id');
    }

    public function biometricImages()
    {
        return $this->hasMany(BiometricImage::class);
    }

    public function getBiometricImagesCountAttribute()
    {
        return $this->biometricImages()->count();
    }
}
