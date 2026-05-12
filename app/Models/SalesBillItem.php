<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class SalesBillItem extends Model
{
    use HasUuids;

    protected $table = 'sales_bill_items';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

   protected $fillable = [
    'id',
    'sales_bill_id',
    'medicine_id',
    'batch_id',
    'quantity',
    'unit_price',
    'total_price'
];



   public function medicine()
{
    return $this->belongsTo(Medicine::class, 'medicine_id');
}

public function batch()
{
    return $this->belongsTo(MedicineBatch::class, 'batch_id');
}

    public function bill()
    {
        return $this->belongsTo(SalesBill::class, 'sales_bill_id', 'bill_id');
    }
}