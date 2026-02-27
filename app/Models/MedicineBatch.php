<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
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

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
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

    // One batch belongs to one medicine


    // One batch has many stock movements
    public function stockMovements()
    {
        return $this->hasMany(StockMovement::class, 'batch_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper Methods
    |--------------------------------------------------------------------------
    */

    // Check if low stock
    public function isLowStock()
    {
        return $this->quantity <= $this->reorder_level;
    }

    // Check if expired
    public function isExpired()
    {
        return now()->greaterThan($this->expiry_date);
    }
}