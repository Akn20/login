<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Department extends Model
{
    use SoftDeletes;

    protected $table = 'department_master';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'department_code',
        'department_name',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::upper(Str::random(30)); // 30-char UUID-like
            }
        });
    }
}
