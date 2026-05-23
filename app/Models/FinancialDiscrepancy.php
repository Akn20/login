<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\FinancialReconciliation;

class FinancialDiscrepancy extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'financial_reconciliation_id',

        'issue_type',

        'expected_amount',

        'actual_amount',

        'difference_amount',

        'status',

        'reviewed_by',

        'remarks',
    ];

    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {

                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * RELATIONSHIP
     */
    public function financialReconciliation()
    {
        return $this->belongsTo(
            FinancialReconciliation::class,
            'financial_reconciliation_id'
        );
    }
}