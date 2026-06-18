<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GlobalTimezone extends Model
{
    use SoftDeletes;

    /*
    |--------------------------------------------------------------------------
    | TABLE NAME
    |--------------------------------------------------------------------------
    */

    protected $table = 'global_timezones';

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
        'timezone_name',
        'timezone_code',
        'date_format',
        'time_format',
        'is_default'

    ];

    /*
    |--------------------------------------------------------------------------
    | TYPE CASTING
    |--------------------------------------------------------------------------
    */

    protected $casts = [

        'is_default' => 'boolean'

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
