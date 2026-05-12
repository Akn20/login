<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class EquipmentMaintenance extends Model
{
    use SoftDeletes;
    protected $table = 'equipment_maintenance';

    protected $fillable = [
        'id',
        'equipment_id',
        'maintenance_type',
        'maintenance_date',
        'technician',
        'description',
        'status'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}