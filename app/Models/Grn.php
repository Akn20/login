<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grn extends Model
{
    use SoftDeletes;

    protected $table = 'grns';

    protected $fillable = [
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
    ];

    public function items()
    {
        return $this->hasMany(GrnItem::class, 'grn_id');
    }
}