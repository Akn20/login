<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesReturnItem extends Model
{
    use HasFactory;

    protected $table = 'sales_return_items';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'sales_return_id',
        'medicine_id',
        'batch_id',
        'quantity',
        'unit_price',
        'refund_amount' ,
        'reason'
    ];

    /**
     * Relation with Sales Return
     */
    public function salesReturn()
    {
        return $this->belongsTo(SalesReturn::class, 'sales_return_id');
    }

    /**
     * Relation with Medicine
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id');
    }

    /**
     * Relation with Medicine Batch
     */
    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'batch_id');
    }
}