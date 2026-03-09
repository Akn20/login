<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReturnMedicine extends Model
{
    use SoftDeletes;

    protected $table = 'returns';

    protected $fillable = [
        'medicine_name',
        'return_date',
        'quantity',
        'reason',
    ];

    protected $dates = [
        'return_date',
        'deleted_at',
    ];
}