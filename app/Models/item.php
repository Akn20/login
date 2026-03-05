<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'category',
        'unit',
        'purchase_price',
        'selling_price',
        'reorder_level',
        'stock',
        'status'
    ];
}