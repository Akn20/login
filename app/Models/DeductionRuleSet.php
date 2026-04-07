<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DeductionRuleSet extends Model
{
    use SoftDeletes;

    // ✅ REQUIRED FOR UUID
    protected $keyType = 'string';
    public $incrementing = false;

    // ✅ AUTO GENERATE UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::uuid();
            }
        });
    }

    protected $fillable = [
        'rule_set_code',
        'rule_set_name',
        'rule_category',
        'calculation_type',
        'calculation_base',
        'calculation_value',
        'calculation_applies_on',
        'slab_reference',
        'maximum_limit',
        'minimum_limit',
        'rounding_rule',
        'prorata_applicable',
        'lop_impact',
        'editable_at_payroll',
        'priority',
        'effective_from',
        'effective_to',
        'status',
        'remarks',
        'skip_if_insufficient_salary',
        'max_percent_net_salary'
    ];
}