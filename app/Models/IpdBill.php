<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdBill extends Model
{
    protected $table = 'ipd_bills';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
         'id',
        'patient_id',
        'ipd_id',
        'bill_no',
        'bill_date',
        'status',
        'total_amount',
        'discount',
        'tax',
        'discount_percent',
        'tax_percent',
        'advance_amount',
        'grand_total',
        'payable_amount',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) \Str::uuid();
            }
        });
    }

    // Relationship
    public function items()
    {
        return $this->hasMany(IpdBillItem::class, 'bill_id');
    }
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }
    public function ipd()
    {
        return $this->belongsTo(\App\Models\IpdAdmission::class, 'ipd_id');
    }

    //payments
    public function payments()
    {
        return $this->hasMany(AccountantPayment::class, 'bill_id');
    }

    public function getPaidAmountAttribute()
    {
        return $this->payments()->sum('amount');
    }

    public function getDueAmountAttribute()
    {
        return max((float) $this->payable_amount - (float) $this->paid_amount, 0);
    }

    public function getPaymentStatusAttribute()
    {
        if ($this->due_amount <= 0) return 'paid';
        if ($this->paid_amount == 0) return 'unpaid';
        if ($this->paid_amount < $this->payable_amount) return 'partial';
        return 'paid';
    }
}
