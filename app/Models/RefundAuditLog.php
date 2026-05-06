<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RefundAuditLog extends Model
{
    protected $table = 'refund_audit_logs';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'refund_id',
        'action_type',
        'performed_by',
        'action_details',
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

    public function performedBy()
    {
        return $this->belongsTo(
            User::class,
            'performed_by'
        );
    }
}