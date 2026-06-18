<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

use App\Models\Patient;
use App\Models\User;
use App\Models\Department;

use Illuminate\Database\Eloquent\SoftDeletes;
class Referral extends Model
{
    use HasUuids;

    use SoftDeletes;
    protected $table = 'referrals';

    protected $fillable = [

        'hospital_id',

        'patient_id',

        'doctor_id',

        'referred_doctor_id',

        'referred_department_id',

        'referral_type',

        'priority',

        'referral_reason',

        'clinical_notes',

        'followup_date',

        'status',

        'created_by',

        'updated_by',
    ];

    /**
     * UUID Configuration
     */
    public $incrementing = false;

    protected $keyType = 'string';

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function referredDoctor()
    {
        return $this->belongsTo(User::class, 'referred_doctor_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'referred_department_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}