<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScanType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
}