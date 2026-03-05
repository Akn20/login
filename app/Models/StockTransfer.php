<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockTransfer extends Model
{
    protected $fillable = [
        'transfer_number',
        'transfer_date'
    ];

    public function items()
    {
        return $this->hasMany(StockTransferItem::class);
    }
}
