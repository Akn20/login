<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesBill extends Model
{
    protected $table = 'sales_bills';

    protected $primaryKey = 'bill_id';   // important
    protected $keyType = 'string';  // UUID
    public $incrementing = false;   // UUID not auto increment

   protected $fillable = [
    'bill_id',
    'bill_number',
    'patient_id',
    'patient_name',
    'prescription_id',
    'total_amount',
    'paid_amount',
    'balance_amount',
    'payment_status',
    'invoice_status',
    'payment_mode',
    'remarks'
];

   public function items()
{
    return $this->hasMany(SalesBillItem::class, 'sales_bill_id', 'bill_id');
}

    public function patient()
{
    return $this->belongsTo(\App\Models\Patient::class, 'patient_id', 'id');
}

public function getDisplayPatientNameAttribute()
{
    // If patient_name column has value → use it
    if (!empty($this->patient_name)) {
        return $this->patient_name;
    }

    // Else fallback to relation
    if ($this->patient) {
        return $this->patient->first_name . ' ' . $this->patient->last_name;
    }

    return '';
}

}