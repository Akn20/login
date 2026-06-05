<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTemplate extends Model
{
    protected $fillable = [
        'hospital_id',
        'template_name',
        'invoice_prefix',
        'starting_number',
        'show_logo',
        'show_address',
        'show_phone',
        'show_gst',
        'terms_conditions',
        'status'
    ];
}