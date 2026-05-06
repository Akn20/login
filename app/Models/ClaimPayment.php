<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimPayment extends Model
{
    protected $table = 'claim_payments';

    protected $fillable = [
        'claim_id',
        'payment_amount',
        'payment_date',
        'payment_mode',
        'transaction_reference',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'payment_amount' => 'decimal:2',
    ];

    public function claim()
    {
        return $this->belongsTo(InsuranceClaim::class, 'claim_id');
    }
}