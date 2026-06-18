<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrintFormatSetting extends Model
{
    protected $fillable = [
        'hospital_id',
        'hospital_logo',
        'hospital_name',
        'address',
        'phone_number',
        'footer_text',
        'disclaimer',
        'signature_area',
        'paper_size',
        'orientation',
        'margins',
        'status'
    ];
}