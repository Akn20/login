<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadiologyReport extends Model
{
    protected $fillable = [
        'scan_request_id',
        'observations',
        'findings',
        'diagnosis',
        'status',
        'radiologist_id'
    ];

    public function request()
    {
        return $this->belongsTo(ScanRequest::class, 'scan_request_id');
    }
}