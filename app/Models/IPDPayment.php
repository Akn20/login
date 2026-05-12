<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPDPayment extends Model
{
    protected $table = 'ipd_payments';

    protected $fillable = [
        'patient_id',
        'ipd_id',
        'amount',
        'payment_mode',
        'transaction_type'
    ];
}
