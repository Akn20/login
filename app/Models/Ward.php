<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $fillable = [
        'ward_name',
        'ward_type',
        'floor_number'
    ];
}
