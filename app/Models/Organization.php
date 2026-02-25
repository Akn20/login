<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'name',
        'type',
        'registration_number',
        'gst',
        'contact_number',
        'email',
        'admin_name',
        'admin_email',
        'admin_mobile',
        'plan_type',
        'status',
        'address',
        'city',
        'state',
        'country',
        'pincode',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
