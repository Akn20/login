<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'institution_id',
        'patient_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'mobile',
        'email',
        'blood_group',
        'address',
        'emergency_contact',
        'is_vip',
        'status',
        'merged_to',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'is_vip' => 'boolean',
        'status' => 'boolean',
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

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
