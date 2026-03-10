<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PharmacyBillItem extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_bill_items';

    protected $fillable = [
        'id',
        'bill_id',
        'medicine_id',
        'quantity',
        'price'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    public function bill()
    {
        return $this->belongsTo(PharmacyBill::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

}