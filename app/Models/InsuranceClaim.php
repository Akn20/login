<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\ClaimApproval;
use App\Models\ClaimPayment;
use App\Models\ClaimReconciliation;
use App\Models\Patient;

class InsuranceClaim extends Model
{
    use SoftDeletes;
    protected $table = 'insurance_claims';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'claim_number',
        'patient_id',
        'insurance_provider',
        'billed_amount',
        'claim_date',
        'status'
    ];

    protected $casts = [
        'claim_date' => 'date',
        'billed_amount' => 'decimal:2',
    ];

    // Auto-generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relationships
    public function approval()
    {
        return $this->hasOne(ClaimApproval::class, 'claim_id');
    }

    public function payments()
    {
        return $this->hasMany(ClaimPayment::class, 'claim_id');
    }

    public function reconciliation()
    {
        return $this->hasOne(ClaimReconciliation::class, 'claim_id');
    }
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}