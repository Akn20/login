<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceReview extends Model
{
    use SoftDeletes;

    protected $table = 'performance_reviews';

    protected $fillable = [

        'id',

        'employee_id',
        'employee_name',
        'department',

        'reviewer_name',

        'review_date',

        'rating',

        'review_comments',

        'review_status',

        'cycle_name',

        'cycle_start_date',

        'cycle_end_date',

        'kpi_name',

        'target_value',

        'achieved_value',

        'kpi_score',

        'kpi_remarks',

        'old_designation',

        'new_designation',

        'promotion_date',

        'promotion_reason',

        'warning_type',

        'warning_date',

        'warning_remarks',

        'issued_by',

        'action_history',
    ];

    public $incrementing = false;

    protected $keyType = 'string';
}