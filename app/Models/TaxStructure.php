<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TaxStructure extends Model
{
    use SoftDeletes;

    protected $table = 'tax_structures';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',
        'tax_name',
        'tax_percentage',
        'tax_type',
        'calculation_type',
        'is_active'

    ];

    /*
    |--------------------------------------------------------------------------
    | AUTO UUID
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