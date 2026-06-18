<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanLimit extends Model
{
    protected $table = 'plan_limits';

    protected $fillable = [
        'plan_id',
        'max_users',
        'max_patients',
        'max_hospitals',
        'max_storage_mb'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}