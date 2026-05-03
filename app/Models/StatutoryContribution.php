<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class StatutoryContribution extends Model
{

    use SoftDeletes;

    protected $table = 'statutory_contributions';

    protected $keyType = 'string';
    public $incrementing = false;



    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {

                $model->id = (string) Str::uuid();

            }

        });
    }



    protected $fillable = [

        'contribution_code',
        'contribution_name',
        'statutory_category',
        'status',
        'rule_set_code',

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

        'included_in_ctc',

        'compliance_head',
        'statutory_code',

    ];

}