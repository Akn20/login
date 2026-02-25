<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAudit extends Model
{
    protected $fillable = [
        'audit_date',
        'item_id',
        'system_stock',
        'physical_stock',
        'difference'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}