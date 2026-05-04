<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\PayrollResult;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class PayrollResultEarning extends Model
{
    use SoftDeletes;
     public $incrementing = false;

  

    protected $fillable = [
        'payroll_result_id',
        'earning_code',
        'earning_name',
        'earning_type',
        'calculation_base',
        'calculation_value',
        'amount',
        'taxable',
        'pf_applicable',
        'esi_applicable',
        'display_order',
        'created_by',
    ];

    protected $casts = [
        'taxable' => 'boolean',
        'pf_applicable' => 'boolean',
        'esi_applicable' => 'boolean',
    ];

public function payrollResult()
{
    return $this->belongsTo(
        PayrollResult::class,
        'payroll_result_id'
    );
}
}