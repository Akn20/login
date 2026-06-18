<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GlobalCurrency extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | TABLE
    |--------------------------------------------------------------------------
    */

    protected $table = 'global_currencies';

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
        'currency_name',
        'currency_code',
        'currency_symbol',
        'decimal_places',
        'is_default'

    ];

    /*
    |--------------------------------------------------------------------------
    | TYPE CASTING
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'is_default' => 'boolean',
        'decimal_places' => 'integer'

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

