<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; // ✅ ADD THIS

class StatutoryDeduction extends Model
{
    use SoftDeletes;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected $table = 'statutory_deductions';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'statutory_code',
        'statutory_name',
        'statutory_category',
        'status',
        'rule_set_id',
        'eligibility_flag',
        'salary_ceiling_applicable',
        'salary_ceiling_amount',
        'state_applicable',
        'applicable_states',
        'prorata_applicable',
        'lop_impact',
        'rounding_rule',
        'show_in_payslip',
        'payslip_order',
        'compliance_head',
        'authority_code'
    ];

    public function ruleSet()
    {
        return $this->belongsTo(DeductionRuleSet::class, 'rule_set_id');
    }
}