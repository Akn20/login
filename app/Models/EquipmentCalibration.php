<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentCalibration extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_calibrations';

    protected $fillable = [
        'id',
        'equipment_id',
        'calibration_type',
        'calibration_date',
        'technician',
        'result',
        'next_due_date',
        'notes'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
