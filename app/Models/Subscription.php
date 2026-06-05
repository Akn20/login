<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Subscription extends Model
{
    use SoftDeletes;

    protected $table = 'subscriptions';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'organization_id',
        'plan_id',
        'start_date',
        'expiry_date',
        'status',
        'auto_renew'
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
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
    public function invoices()
{
    return $this->hasMany(
        SubscriptionInvoice::class
    );
}
}