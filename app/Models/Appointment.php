<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'appointments';

    // UUID settings
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'patient_id',
        'doctor_id',
        'department_id',
        'appointment_date',
        'appointment_time',
        'appointment_status',
        'consultation_fee',
        'hospital_id',
        'receptionist_user_id'
    ];

    protected $dates = [
        'appointment_date',
        'deleted_at'
    ];

    /*
    |--------------------------------------------------------------------------
    | Automatically generate UUID
    |--------------------------------------------------------------------------
    */

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Patient relationship
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    // Doctor (from staff table)
    public function doctor()
    {
        return $this->belongsTo(Staff::class, 'doctor_id');
    }

    // Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

}