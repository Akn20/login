<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PrePayrollAdjustment extends Model
{
    use SoftDeletes;

    protected $table = 'pre_payroll_adjustments';

    //  UUID settings
    protected $keyType = 'string';
    public $incrementing = false;

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        $model->id = (string) Str::uuid();

        //  ADD THIS LINE
        $model->pre_payroll_code = 'PPR_' . rand(1000, 9999);
    });
}

    // Fillable fields
    protected $fillable = [
        'pre_payroll_code',
        'payroll_run_id',
        'payroll_month',
        
        'employee_id',
        'salary_assignment_id',
        'pay_type',

        'working_days',
        'days_paid',
        'lop_days',
        'ot_hours',

        'fixed_earnings_total',
        'fixed_deductions_total',

        'pf_employee',
        'esi_employee',
        'professional_tax',
        'tds_amount',

        'adhoc_earnings',
        'earnings_remarks',
        'adhoc_deductions',
        'deduction_remarks',

        'gross_earnings',
        'total_deductions',
        'net_payable',

        'status',
        'submitted_by',
        'approved_by',
        'approved_on',
        'created_by'
    ];


    public function employee()
{
    return $this->belongsTo(\App\Models\Staff::class, 'employee_id');
}
}