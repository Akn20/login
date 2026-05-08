<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryItem extends Model
{
    protected $table = 'inventory_items';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'category',
        'quantity',
        'unit',
        'threshold',
        'expiry_date'
    ];

    protected $casts = [
        'expiry_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

   

    public function usageLogs()
    {
        return $this->hasMany(InventoryUsageLog::class, 'item_id');
    }

    public function alerts()
    {
        return $this->hasMany(InventoryAlert::class, 'item_id');
    }
}