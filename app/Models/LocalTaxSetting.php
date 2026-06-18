<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LocalTaxSetting extends Model
{
    protected $fillable = [
        'hospital_id',
        'tax_name',
        'tax_percentage',
        'tax_type',
        'applicable_on',
        'status'
    ];
}