<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PayrollResultDeduction extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'payroll_result_deductions';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [

        'payroll_result_id',

        'deduction_code',

        'deduction_name',

        'deduction_type',

        'rule_set_code',

        'calculation_base',

        'calculation_logic',

        'calculation_value',

        'amount',

        'editable_flag',

        'display_order',

        'created_by'
    ];

    

    public function payrollResult()
    {
        return $this->belongsTo(
            PayrollResult::class,
            'payroll_result_id'
        );
    }
}