<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class AlertAuditLog extends Model
{
    protected $table = 'alert_audit_logs';

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'alert_id',
        'user_id',
        'action',
        'remarks',
        'timestamp'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }
}