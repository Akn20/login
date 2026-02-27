<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrnItem extends Model
{
    protected $table = 'grn_items';

    protected $fillable = [
        'grn_id',
        'medicine_name',
        'batch_no',
        'expiry',
        'qty',
        'free_qty',
        'purchase_rate',
        'discount_percent',
        'tax_percent',
        'amount',
    ];

    public function grn()
    {
        return $this->belongsTo(Grn::class, 'grn_id');
    }
}