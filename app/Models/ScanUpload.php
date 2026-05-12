<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanUpload extends Model
{
    protected $fillable = [
        'scan_request_id',
        'file_path',
        'file_type',
        'notes'
    ];

    public function scanRequest()
    {
        return $this->belongsTo(ScanRequest::class);
    }
}

