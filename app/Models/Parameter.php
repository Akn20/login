<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parameter extends Model
{
    protected $fillable = [
        'name',
        'unit',
        'min_value',
        'max_value'
    ];

    public function testParameters()
    {
        return $this->hasMany(TestParameter::class);
    }
}