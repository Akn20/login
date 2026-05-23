<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Staff;

class EmployeeSalaryAssignment extends Model
{
    use SoftDeletes;

    protected $table = 'employee_salary_assignments';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $fillable = [
        'employee_id',
        'salary_structure_id',

        'salary_basis',
        'salary_amount',
        'pay_frequency',
        'currency',

        'hourly_pay_eligible',
        'overtime_eligible',
        'allowed_work_types',

        'effective_from',
        'effective_to',
        'status',

        'created_by'
    ];

    // 🔹 Relations
  public function employee()
{
    return $this->belongsTo(Staff::class, 'employee_id');
}

    public function salaryStructure()
    {
        return $this->belongsTo(SalaryStructure::class);
    }
    public function structure()
{
    return $this->belongsTo(\App\Models\SalaryStructure::class, 'salary_structure_id');
}
}