<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Module extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'module_label',
        'module_display_name',
        'parent_module',
        'priority',
        'icon',
        'file_url',
        'page_name',
        'type',
        'access_for',
        'status'
    ];


    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    public function institutions()
    {
        return $this->belongsToMany(Institution::class);
    }


}