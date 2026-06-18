<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class DigitalPayment extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'financial_reconciliation_id',

        'payment_method',

        'payment_gateway',

        'payment_amount',

        'payment_date',

        'transaction_reference',

        'matching_status',

        'settlement_status',

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
     * Relationship
     */
    public function financialReconciliation()
{
    return $this->belongsTo(
        FinancialReconciliation::class,
        'financial_reconciliation_id'
    );
}
}