<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlledDrugLog extends Model
{

    protected $table = "controlled_drug_log";

    protected $primaryKey = "log_id";

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'log_id',

        'controlled_drug_id',

        'transaction_type',

        'quantity',

        'transaction_date',

        'pharmacist_id'

    ];
    public function drug()
    {
        return $this->belongsTo(
            ControlledDrug::class,
            'controlled_drug_id',
            'controlled_drug_id'
        );
    }

}