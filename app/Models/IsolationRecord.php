<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class IsolationRecord extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'isolation_records';

    protected $fillable = [
        'id',
        'patient_id',
        'nurse_id',
        'isolation_type',
        'start_date',
        'end_date',
        'status',
        'notes'
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