<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PpeComplianceLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ppe_compliance_logs';

    protected $fillable = [
        'id',
        'patient_id',
        'nurse_id',
        'ppe_used',
        'ppe_type',
        'compliance_status',
        'notes',
        'recorded_at'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'nurse_id');
    }
}