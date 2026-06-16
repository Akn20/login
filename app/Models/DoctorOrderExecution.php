<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DoctorOrderExecution extends Model
{
    use HasUuids;

    protected $table = 'doctor_order_executions';

    protected $fillable = [
        'order_type',
        'order_reference_id',
        'patient_id',
        'execution_status',
        'remarks',
        'escalation_reason',
        'executed_by',
        'executed_at'
    ];

    protected $casts = [
        'executed_at' => 'datetime'
    ];
}