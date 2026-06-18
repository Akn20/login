<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SubscriptionInvoice extends Model
{
    use SoftDeletes;

    protected $table = 'subscription_invoices';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [

        'id',

        'subscription_id',

        'invoice_number',

        'amount',

        'tax',

        'discount',

        'total_amount',

        'invoice_date',

        'due_date',

        'status',

        'notes'
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}