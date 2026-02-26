<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrnItem extends Model
{
    protected $fillable = [
        'grn_id',
        'item_id',
        'ordered_quantity',
        'received_quantity',
        'unit_price',
        'total'
    ];

    public function grn()
    {
        return $this->belongsTo(Grn::class);
    } 

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}