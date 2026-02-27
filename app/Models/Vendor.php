<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\PurchaseOrder;

class Vendor extends Model
{
    use SoftDeletes;

    public $incrementing = false;      // Because UUID
    protected $keyType = 'string';     // UUID is string

    protected $fillable = [
        'vendor_name',
        'phone_number',
        'email',
        'address',
        'status',
        'created_by',
        'updated_by'
    ];

    // 🔥 Auto generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // 🔥 Allow $vendor->name in Blade
    public function getNameAttribute()
    {
        return $this->vendor_name;
    }

    // 🔥 Relationship
    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}