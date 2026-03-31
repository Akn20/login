<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflinePrescriptionItem extends Model
{
    protected $fillable = [

'id',

'offline_prescription_id',

'medicine_name',

'dosage',

'frequency',

'duration',

'quantity',

'instructions'

];
}
