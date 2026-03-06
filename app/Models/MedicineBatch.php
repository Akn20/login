<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MedicineBatch extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'medicine_id',
        'batch_number',
        'expiry_date',
        'purchase_price',
        'mrp',
        'quantity',
        'reorder_level',
   ];
 
    protected $casts = [
        'expiry_date' => 'date',
        'purchase_price' => 'decimal:2',
        'mrp' => 'decimal:2',
        'quantity' => 'integer',
        'reorder_level' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'batch_id');
    }

    public function expiryLogs()
    {
        return $this->hasMany(Expiry::class, 'batch_id');
    }

    public function latestExpiryLog()
    {
        return $this->hasOne(Expiry::class, 'batch_id')->latestOfMany();
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */
 
    public function isLowStock()
    {
        return $this->reorder_level && $this->quantity <= $this->reorder_level;
    }
 
    public function isExpired()
    {
        return $this->expiry_date && now()->gt($this->expiry_date);
    }
}