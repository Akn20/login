<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesBillItem extends Model
{
    protected $table = 'sales_bill_items';

    protected $fillable = [
        'sales_bill_id',
        'medicine_id',
        'batch_id',
        'quantity',
        'unit_price',
        'total_price'
    ];

    // REMOVE UUID settings (because id is bigint auto increment)

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'id');
    }

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'batch_id', 'id');
    }

    public function bill()
    {
        return $this->belongsTo(SalesBill::class, 'sales_bill_id', 'id');
    }
}