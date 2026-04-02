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
        'taxable',
        'pf',
        'esi',
        'earning_type',
        'show_in_payslip',
        'display_order',
    ];

    // 🔹 Casts (VERY IMPORTANT for checkboxes)
    protected $casts = [
        'taxable' => 'boolean',
        'pf' => 'boolean',
        'esi' => 'boolean',
        'show_in_payslip' => 'boolean',
    ];
}