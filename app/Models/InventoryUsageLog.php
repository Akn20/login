<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryUsageLog extends Model
{
    protected $table = 'inventory_usage_logs';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_id',
        'quantity_used',
        'used_by',
        'used_at'
    ];

    protected $casts = [
        'used_at' => 'datetime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    

    public function item()
    {
        return $this->belongsTo(InventoryItem::class, 'item_id');
    }

        public function user()
        {
            return $this->belongsTo(User::class, 'used_by');
        }

        
}