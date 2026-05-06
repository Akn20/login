<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClaimReconciliation extends Model
{
    protected $table = 'claim_reconciliations';

    protected $fillable = [
        'claim_id',
        'difference_amount',
        'is_reconciled',
        'remarks',
    ];

    protected $casts = [
        'difference_amount' => 'decimal:2',
        'is_reconciled' => 'boolean',
    ];

    public function claim()
    {
        return $this->belongsTo(InsuranceClaim::class, 'claim_id');
    }
}