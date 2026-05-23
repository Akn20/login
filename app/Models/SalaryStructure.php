<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SalaryStructure extends Model
{
    use SoftDeletes;

    // UUID SETTINGS
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = Str::uuid()->toString();
            }
        });
    }

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

        //  DATE CAST (GOOD PRACTICE)
        'effective_from' => 'date',
        'effective_to' => 'date',
    ];
}