<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OTManagement extends Model
{

    protected $table = 'ot_management';

    protected $fillable = [

        'surgery_id',
        'ot_room_used',
        'start_time',
        'end_time',
        'equipment_used',
        'approval_status',
        'notes'

    ];

    public function surgery()
    {
        return $this->belongsTo(Surgery::class, 'surgery_id');
    }

}