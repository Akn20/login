<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipment extends Model
{
    use SoftDeletes;

    protected $table = 'equipment';

    protected $fillable = [
        'id',
        'equipment_code',
        'name',
        'type',
        'manufacturer',
        'model_number',
        'serial_number',
        'installation_date',
        'location',
        'condition_status',
        'status'
    ];

    public $incrementing = false;
    protected $keyType = 'string';
}