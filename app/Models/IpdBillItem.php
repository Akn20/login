<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdBillItem extends Model
{
    protected $table = 'ipd_bill_items';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'bill_id',
        'type',
        'reference_id',
        'description',
        'quantity',
        'rate',
        'amount'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relationship
    public function bill()
    {
        return $this->belongsTo(IpdBill::class, 'bill_id');
    }
}