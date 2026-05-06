<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Refund extends Model
{
    protected $table = 'refunds';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'patient_id',
        'bill_id',
        'bill_type',

        'refund_no',
        'refund_date',

        'refund_type',
        'refund_amount',
        'refund_reason',

        'remarks',

        'refund_mode',
        'transaction_no',

        'status',

        'requested_by',
        'approved_by',
        'approved_at',

        'document',
    ];

    protected $casts = [

        'refund_date' => 'date',

        'approved_at' => 'datetime',

        'refund_amount' => 'decimal:2',
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

            /*
            |--------------------------------------------------------------------------
            | Auto Refund Number
            |--------------------------------------------------------------------------
            */

            if (!$model->refund_no) {

                $count = self::count() + 1;

                $model->refund_no =
                    'REF-' . date('Y') . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(
            Patient::class,
            'patient_id'
        );
    }

    public function requestedBy()
    {
        return $this->belongsTo(
            User::class,
            'requested_by'
        );
    }

    public function approvedBy()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }

    public function approvalLogs()
    {
        return $this->hasMany(
            RefundApprovalLog::class,
            'refund_id'
        );
    }

    public function auditLogs()
    {
        return $this->hasMany(
            RefundAuditLog::class,
            'refund_id'
        );
    }
}