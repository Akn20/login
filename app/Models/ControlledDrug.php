<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ControlledDrug extends Model
{

    use SoftDeletes;

    protected $table = "controlled_drug";

    protected $primaryKey = "controlled_drug_id";

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'controlled_drug_id',
        'drug_name',
        'drug_id',
        'batch_number',
        'expiry_date',
        'stock_quantity',
        'supplier_id',
        'status'

    ];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $model->controlled_drug_id = Str::uuid();

        });

    }

    public function dispenses()
    {
        return $this->hasMany(
            ControlledDrugDispense::class,
            'controlled_drug_id',
            'controlled_drug_id'
        );
    }


    public function logs()
    {
        return $this->hasMany(
            ControlledDrugLog::class,
            'controlled_drug_id',
            'controlled_drug_id'
        );
    }

    public function vendor()
    {
        return $this->belongsTo(\App\Models\Vendor::class, 'supplier_id');
    }
}