<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class InfectionControlLog extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'infection_control_logs';

    protected $fillable = [
        'id',
        'patient_id',
        'nurse_id',
        'infection_type',
        'severity',
        'status',
        'notes',
        'recorded_at'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    /*
    |----------------------------------------
    | Relationships
    |----------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(\App\Models\Staff::class, 'nurse_id');
    }
}