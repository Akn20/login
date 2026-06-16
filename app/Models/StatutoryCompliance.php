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

    // PF
    'pf_applicable',
    'pf_number',
    'pf_amount',
    'pf_start_date',

    // ESI
    'esi_applicable',
    'esi_number',
    'esi_amount',

    // PT
    'pt_applicable',
    'pt_amount',
    'state_applicable',

    // TDS
    'tds_applicable',
    'pan_number',
    'tds_percentage',

    // Contract
    'contract_start_date',
    'contract_end_date',
    'contract_status',

    // License
    'license_number',
    'license_issue_date',
    'license_expiry_date',
    'license_upload',
    'license_status',

    // Additional
    'remarks',
    'status',

];
}

