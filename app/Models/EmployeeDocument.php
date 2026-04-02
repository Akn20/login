<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeDocument extends Model
{
    protected $fillable = [
        'staff_id',
        'document_type',
        'file_path',
        'expiry_date',
        'uploaded_by'
    ];

    public function staff()
    {
        return $this->belongsTo(\App\Models\Staff::class);
    }
}
