<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LeaveRequestApprovals extends Model
{
    protected $table = 'leave_request_approvals';

    protected $keyType = 'string';

    protected $fillable = [
        'leave_request_id',
        'approver_id',
        'level',
        'status',
        'remarks',
    ];

    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid(); // Required for UUID primary keys
            }
        });
    }

    public function leaveRequest()
    {
        return $this->belongsTo(LeaveRequests::class, 'leave_request_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
