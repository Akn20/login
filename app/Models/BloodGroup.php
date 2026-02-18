<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BloodGroup extends Model
{
    use SoftDeletes;

    protected $table = 'blood_group_master';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'blood_group_name',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            // generate a short UUID-like id within 30 chars
            if (!$model->id) {
                $model->id = Str::upper(Str::random(30));
            }
        });

    }
    

}
