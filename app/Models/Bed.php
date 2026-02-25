<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
