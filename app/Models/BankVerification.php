<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BankVerification extends Model
{
    use SoftDeletes;

    protected $fillable = [

        'financial_reconciliation_id',

        'bank_name',

        'deposit_amount',

        'deposit_date',

        'reference_number',

        'verification_status',

        'verified_by',

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