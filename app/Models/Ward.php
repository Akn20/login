<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use SoftDeletes;
    public $incrementing = false;
protected $keyType = 'string';
    protected $fillable = [
        'ward_name',
        'ward_type',
        'floor_number',
        'total_beds',
        'status'
    ];

    protected $casts = [
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

    public function beds()
    {
        return $this->hasMany(Bed::class);
    }

}
