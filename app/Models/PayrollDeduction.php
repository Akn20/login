<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class PayrollDeduction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'deductions';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'display_name',
        'description',
        'nature',
        'category',
        'lop_impact',
        'prorata_applicable',
        'tax_deductible',
        'pf_impact',
        'esi_impact',
        'pt_impact',
        'rule_set_code',
        'show_in_payslip',
        'payslip_order',
        'status',
    ];

    protected $casts = [
        'payslip_order' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
