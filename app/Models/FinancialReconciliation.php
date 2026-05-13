<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FinancialReconciliation extends Model
{
    use SoftDeletes;

    protected $table = 'financial_reconciliations';

    protected $fillable = [
        'reconciliation_date',
        'total_cash',
        'total_digital',
        'total_bank_deposit',
        'difference_amount',
        'status',

        // Bank Verification
    'bank_name',
    'deposit_reference',
    'verification_status',

    // Digital Payment
    'payment_gateway',
    'gateway_reference',
    'digital_payment_status',

    // Remarks
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

    public function bankVerifications()
    {
        return $this->hasMany(
            BankVerification::class,
            'financial_reconciliation_id'
        );
    }

    public function digitalPayments()
    {
        return $this->hasMany(
            DigitalPayment::class,
            'financial_reconciliation_id'
        );
    }

    public function discrepancies()
    {
        return $this->hasMany(
            FinancialDiscrepancy::class,
            'financial_reconciliation_id'
        );
    }
}