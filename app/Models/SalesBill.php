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
        'id',
        'bill_number',
        'total_amount'
    ];

   public function items()
{
    return $this->hasMany(SalesBillItem::class, 'sales_bill_id', 'bill_id');
}
}