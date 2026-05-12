<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestParameter extends Model
{
    protected $fillable = [
        'test_name',
        'parameter_id'
    ];

    public function parameter()
    {
        return $this->belongsTo(Parameter::class);
    }
}