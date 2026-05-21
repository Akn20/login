<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\InsuranceClaim;

class ClaimApproval extends Model
{
    protected $table = 'claim_approvals';

    protected $fillable = [
        'claim_id',
        'approved_amount',
        'approval_date',
        'document',
    ];

    protected $casts = [
        'approval_date' => 'date',
        'approved_amount' => 'decimal:2',
    ];

    public function claim()
    {
        return $this->belongsTo(InsuranceClaim::class, 'claim_id');
    }
}