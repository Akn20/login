<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryStructure extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'salary_structure_code',
        'salary_structure_name',
        'structure_category',
        'status',

        'fixed_allowance_components',
        'variable_allowance_allowed',
        'residual_component_id',

        'hourly_pay_eligible',
        'overtime_eligible',
        'allowed_work_types',

        'fixed_deduction_components',
        'variable_deduction_allowed',

        'pf_applicable',
        'esi_applicable',
        'pt_applicable',
        'tds_applicable',

        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'fixed_allowance_components' => 'array',
        'allowed_work_types' => 'array',
        'fixed_deduction_components' => 'array',

        'variable_allowance_allowed' => 'boolean',
        'hourly_pay_eligible' => 'boolean',
        'overtime_eligible' => 'boolean',
        'variable_deduction_allowed' => 'boolean',

        'pf_applicable' => 'boolean',
        'esi_applicable' => 'boolean',
        'pt_applicable' => 'boolean',
        'tds_applicable' => 'boolean',
    ];
}