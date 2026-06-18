<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanModule extends Model
{
    protected $table = 'plan_modules';

    protected $fillable = [
        'plan_id',
        'module_id'
    ];
}