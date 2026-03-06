<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Patient extends Model
{
    use SoftDeletes;

    protected $table = 'patients';

    protected $keyType = 'string';
    public $incrementing = false;

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
        'updated_by'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}