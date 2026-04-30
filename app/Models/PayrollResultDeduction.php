<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PayrollResultDeduction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'payroll_result_id',
        'deduction_code',
        'deduction_name',
        'deduction_type',
        'rule_set_code',
        'calculation_logic',
        'amount',
        'editable_flag',
        'display_order',
        'created_by'
    ];
}