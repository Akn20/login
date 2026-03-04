<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Expiry extends Model
{
    use SoftDeletes, HasUuids;

    protected $table = 'expiry_logs';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'batch_id',
        'expiry_date',
        'quantity',
        'status',
        'remarks',
        'created_by',
        'updated_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'batch_id');
    }

    public function medicine()
    {
        return $this->hasOneThrough(
            Medicine::class,
            MedicineBatch::class,
            'id',
            'id',
            'batch_id',
            'medicine_id'
        );
    }
}