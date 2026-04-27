<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class IpdBill extends Model
{
    protected $table = 'ipd_bills';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'patient_id',
        'ipd_id',
        'bill_no',
        'bill_date',
        'status',
        'total_amount',
        'discount',
        'tax',
        'grand_total',
        'payable_amount'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    // Relationship
    public function items()
    {
        return $this->hasMany(IpdBillItem::class, 'bill_id');
    }
}