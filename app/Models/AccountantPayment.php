<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AccountantPayment extends Model
{
    protected $table = 'accountant_payments';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'bill_id',
        'patient_id',
        'amount',
        'payment_mode',
        'transaction_id',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function bill()
    {
        return $this->belongsTo(IpdBill::class, 'bill_id');
    }
}
