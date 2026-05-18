<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UsageTracker extends Model
{
    protected $table = 'usage_trackers';

    protected $fillable = [
        'organization_id',
        'current_users',
        'current_patients',
        'current_hospitals',
        'storage_used_mb'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}