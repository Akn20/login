<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expiry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medicine_name',
        'batch_number',
        'expiry_date',
        'quantity',
    ];

    protected $dates = [
        'expiry_date',
        'deleted_at',
    ];
}