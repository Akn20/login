<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefundApprovalLog extends Model
{
    protected $table = 'refund_approval_logs';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'refund_id',
        'approver_id',
        'approval_status',
        'remarks',
        'action_time',
    ];

    protected $casts = [

        'action_time' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Auto UUID
    |--------------------------------------------------------------------------
    */

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
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function refund()
    {
        return $this->belongsTo(
            Refund::class,
            'refund_id'
        );
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approver_id'
        );
    }
}