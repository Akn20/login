<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class InventoryAlert extends Model
{
    protected $table = 'inventory_alerts';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'item_id',
        'alert_type',
        'message',
        'status'
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
}