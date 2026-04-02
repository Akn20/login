<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesBill extends Model
{
    protected $table = 'sales_bills';

    protected $primaryKey = 'id';   // important
    protected $keyType = 'string';  // UUID
    public $incrementing = false;   // UUID not auto increment

   protected $fillable = [
    'bill_id',
    'bill_number',
    'patient_id',
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
}