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

    // Casts for better type handling
    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = Str::upper(Str::random(30));
            }
        });
    }

    // Scopes for HR dashboard
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class, 'department_id');
    }
}
