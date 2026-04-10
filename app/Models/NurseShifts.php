<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NurseShifts extends Model
{
    protected $table = 'nurse_shift_handover';

    protected $fillable = [
        'hospital_id',
        'nurse_id',
        'shift_assignment_id',
        'entry_type',
        'description',
        'task_status'
    ];
}
