<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreventiveMaintenance extends Model
{
    use SoftDeletes;

    protected $table = 'preventive_maintenance';

    protected $fillable = [
        'id',
        'equipment_id',
        'frequency',
        'next_maintenance_date',
        'technician'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function equipment()
    {
        return $this->belongsTo(\App\Models\Equipment::class);
    }
}