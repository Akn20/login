<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentBreakdown extends Model
{
    use SoftDeletes;

    protected $table = 'equipment_breakdowns';

    protected $fillable = [
        'id',
        'equipment_id',
        'description',
        'reported_by',
        'breakdown_date',
        'severity',
        'status'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}