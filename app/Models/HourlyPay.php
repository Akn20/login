<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HourlyPay extends Model
{
    use SoftDeletes;

    // 🔹 Table Name (optional if follows convention)
    protected $table = 'hourly_pays';

    // 🔹 Primary Key Type (since using UUID)
    protected $keyType = 'string';
    public $incrementing = false;

    // 🔹 Fillable Fields
    protected $fillable = [
        'id',
        'name',
        'code',
        'category',
       'is_taxable',
    'pf_applicable',
    'esi_applicable',
    'pt_applicable',
    'is_prorata',
    'lop_impact',
        'earning_type',
        'show_in_payslip',
        'display_order',
        'payslip_label',
      
        'status',
    ];

    // 🔹 Casts (VERY IMPORTANT for checkboxes)
    protected $casts = [
        'is_taxable' => 'boolean',
        'pf_applicable' => 'boolean',
        'esi_applicable' => 'boolean',
         'pt_applicable' => 'boolean',
          'is_prorata' => 'boolean',
           'lop_impact' => 'boolean',
        'show_in_payslip' => 'boolean',
    ];
}