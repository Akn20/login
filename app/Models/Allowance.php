<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class Allowance extends Model
{
    use SoftDeletes;
     protected $keyType = 'string';
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected $fillable = [
        'name',
        'display_name',
        'nature',
        'pay_frequency',
        'start_date',
        'calculation_type',
        'calculation_base',
        'calculation_value',
        'rounding_rule',
        'max_limit',
        'lop_impact',
        'prorata',
        'taxable',
        'tax_exemption_section',
        'pf_applicable',
        'esi_applicable',
        'pt_applicable',
        'tds_applicable',
        'show_in_payslip',
        'display_order',
        'effective_from',
        'effective_to',
        'status',
    ];

    protected $casts = [
        'lop_impact' => 'boolean',
        'prorata' => 'boolean',
        'taxable' => 'boolean',
        'pf_applicable' => 'boolean',
        'esi_applicable' => 'boolean',
        'pt_applicable' => 'boolean',
        'tds_applicable' => 'boolean',
        'show_in_payslip' => 'boolean',
        'status' => 'boolean',
        'start_date' => 'date',
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}
