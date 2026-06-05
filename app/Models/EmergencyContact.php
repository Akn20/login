<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyContact extends Model
{
    protected $fillable = [
        'hospital_id',
        'contact_type',
        'contact_name',
        'mobile_no',
        'alternate_no',
        'email',
        'address',
        'status'
    ];
}