<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanSchedule extends Model
{
    protected $fillable = [
        'scan_request_id',
        'scan_date',
        'scan_time',
        'technician_id'
    ];

    public function request()
    {
        return $this->belongsTo(ScanRequest::class, 'scan_request_id');
    }
}