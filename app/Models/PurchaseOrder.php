<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
       use SoftDeletes;
    protected $fillable = [
        'po_number',
        'vendor_id',
        'order_date',
        'expected_date',
        'total_amount',
        'status'
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    // public function purchaseOrder()
    // {
    //     return $this->belongsTo(PurchaseOrder::class);
    // }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class,'purchase_order_id');
    }
}