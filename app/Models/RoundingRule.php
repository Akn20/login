<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class RoundingRule extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | TABLE NAME
    |--------------------------------------------------------------------------
    */

    protected $table = 'rounding_rules';

    /*
    |--------------------------------------------------------------------------
    | UUID SETTINGS
    |--------------------------------------------------------------------------
    */

    public $incrementing = false;

    protected $keyType = 'string';

    /*
    |--------------------------------------------------------------------------
    | MASS ASSIGNMENT
    |--------------------------------------------------------------------------
    */

    protected $fillable = [

        'id',
        'module_name',
        'rounding_type',
        'decimal_places',
        'is_active'

    ];

    /*
    |--------------------------------------------------------------------------
    | TYPE CASTING
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'decimal_places' => 'integer',

        'is_active' => 'boolean'

    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE UUID
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {

                $model->id = (string) Str::uuid();

            }

        });
    }
}
