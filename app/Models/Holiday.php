<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Holiday extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'details',
        'document',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];
}