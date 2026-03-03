<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ControlledDrugDispense extends Model
{

    protected $table = "controlled_drug_dispense";

    protected $primaryKey = "dispense_id";

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'dispense_id',

        'controlled_drug_id',

        'patient_id',

        'prescription_id',

        'quantity_dispensed',

        'dispense_date',

        'pharmacist_id'

    ];

}

