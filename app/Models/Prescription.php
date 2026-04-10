<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    //protected $table = 'prescriptions';

    protected $table = 'offline_prescriptions';

    protected $fillable = [
        'id',
        'prescription_number',
        'patient_id',
        'doctor_id',
        'prescription_type',
        'prescription_date',
        'status',
        'uploaded_prescription'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function items()
    {
        return $this->hasMany(PrescriptionItem::class);
    }

    public function bill()
    {
        return $this->hasOne(PharmacyBill::class);
    }
}