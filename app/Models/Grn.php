<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Grn extends Model
{
    use SoftDeletes;

    protected $table = 'grns';

    protected $fillable = [
        'purchase_order_id',
        'grn_no',
        'grn_date',
        'vendor_name',
        'vendor_id',
        'invoice_no',
        'invoice_date',
        'po_no',
        'status',
        'remarks',
        'verify_remarks',
        'reject_reason',
        'sub_total',
        'total_discount',
        'total_tax',
        'grand_total',
        'invoice_file',
    ];

    public function items()
    {
        return $this->hasMany(GrnItem::class, 'grn_id');
    }

 public function purchaseOrder()
{
    return $this->belongsTo(
        PurchaseOrder::class,
        'purchase_order_id'
    )->withDefault([
        'po_number' => 'N/A'
    ]);
}

    // Accessors for OLD UI

    public function getGrnNumberAttribute()
    {
        return $this->grn_no;
    }

    public function getReceivedDateAttribute()
    {
        return $this->grn_date;
    }

    public function getTotalAmountAttribute()
    {
        return $this->grand_total;
    }
}