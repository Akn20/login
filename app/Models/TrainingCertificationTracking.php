<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Staff;

class TrainingCertificationTracking extends Model
{
    use SoftDeletes;

    protected $table =
        'training_certification_trackings';

    protected $primaryKey = 'id';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [

        'id',

        // Employee
        'employee_id',
        'employee_name',
        'department',
        'designation',

        // Training
        'training_code',
        'training_name',
        'training_type',
        'training_provider',
        'training_location',

        'training_start_date',
        'training_end_date',

        // Certification
        'certification_name',
        'certification_number',

        'issue_date',
        'expiry_date',

        'certification_authority',

        // Renewal
        'renewal_required',

        // Status
        'status',

        // Reminder
        'reminder_days',
        'reminder_enabled',

        // Additional
        'remarks',
        'attachment',

        'created_by',
        'updated_by',
    ];

    /**
     * Staff Relationship
     */
    public function staff()
    {
        return $this->belongsTo(
            Staff::class,
            'employee_id',
            'employee_id'
        );
    }
}