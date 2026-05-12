<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\Staff; // ✅ FIXED (was Employee)

class RateEmployeeMapping extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'rate_employee_mappings';

    protected $fillable = [

        // Identification

        'rule_set_code',
        'rule_set_name',
        'work_type_code',

        // Calculation Logic

        'rate_type',
        'base_rate_source',

        'base_rate_value',
        'multiplier_value',

        'maximum_hours',
        'round_off_rule',

        // Applicability

        'employee_type',
        'employee_id',
        'employee_category'

    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // ✅ FIXED RELATION → staff table

    public function employee()
    {
        return $this->belongsTo(
            Staff::class,
            'employee_id',
            'id'
        );
    }

}