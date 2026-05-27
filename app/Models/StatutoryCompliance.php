<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StatutoryCompliance extends Model
{
    use SoftDeletes;

    protected $table =
        'statutory_compliances';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'employee_id',
        'employee_name',
        'department',
        'pf_applicable',
        'pf_number',
        'pf_amount',
        'pf_start_date',
        'esi_applicable',
        'esi_number',
        'esi_amount',
        'pt_applicable',
        'pt_amount',
        'state_applicable',
        'tds_applicable',
        'pan_number',
        'tds_percentage',

    ];
}