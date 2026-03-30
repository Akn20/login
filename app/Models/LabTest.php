<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LabTest extends Model
{
   protected $table = 'lab_tests';

    protected $fillable = [
        'test_name',
        'test_code',
        'test_category',
        'sample_type',
        'price',
        'turnaround_time',
        'status',
        'description'
    ];
}
