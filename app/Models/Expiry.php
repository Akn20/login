<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expiry extends Model
{
    use SoftDeletes;
    protected $table = 'expiry_logs';

    protected $fillable = [
        'batch_id',
        'expiry_date',
        'quantity',
        'status',
        'remarks',
        'created_by',
        'updated_by',
    ];
     public function batch()
    {
        return $this->belongsTo(\App\Models\MedicineBatch::class, 'batch_id');
    }
    
}