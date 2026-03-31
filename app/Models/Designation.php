<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Designation extends Model
{
    use SoftDeletes;

    protected $table = 'designation_master';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'designation_code',
        'designation_name',
        'department_id',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::upper(Str::random(30));
            }
        });
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}