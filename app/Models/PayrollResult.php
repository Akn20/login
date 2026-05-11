<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\PrePayrollAdjustment;
use App\Models\EmployeeSalaryAssignment;
use App\Models\SalaryStructure;
use App\Models\Staff;
use App\Models\User;

class PayrollResult extends Model
{

    protected $table = 'payroll_results';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    public $timestamps = false;



    protected $fillable = [

        'id',

        'payroll_run_id',
        'staff_id',

        'payroll_month',
        'financial_year',
        'academic_year',

        'salary_assignment_id',
        'salary_structure_code',

        'working_days',
        'paid_days',
        'lop_days',
        'overtime_hours',

        'fixed_earnings_total',
        'variable_earnings_total',
        'gross_earnings',

        'fixed_deductions_total',
        'variable_deductions_total',

        'pf_employee',
        'esi_employee',
        'professional_tax',
        'tds_amount',

        'total_deductions',
        'net_payable',

        'status',
        'locked_on',
        'locked_by',

        'created_on',
        'remarks'

    ];



    /**
     * ======================================
     * RELATIONSHIPS
     * ======================================
     */


    /**
     * Pre Payroll Adjustment
     */

    public function prePayroll()
    {
        return $this->belongsTo(
            PrePayrollAdjustment::class,
            'payroll_run_id',
            'payroll_run_id'
        );
    }



    /**
     * Salary Assignment
     */

    public function salaryAssignment()
    {
        return $this->belongsTo(
            EmployeeSalaryAssignment::class,
            'salary_assignment_id',
            'id'
        );
    }



    /**
     * Salary Structure
     */

    public function salaryStructure()
    {
        return $this->belongsTo(
            SalaryStructure::class,
            'salary_structure_code',
            'salary_structure_code'
        );
    }



    /**
     * Staff Mapping
     */

    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'staff_id',
            'employee_id'
        );
    }



    /**
     * Locked User
     */

    public function lockedByUser()
    {
        return $this->belongsTo(
            User::class,
            'locked_by',
            'id'
        );
    }

}