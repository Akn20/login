<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PharmacyBill extends Model
{
    use HasFactory;

    protected $table = 'pharmacy_bills';

    protected $fillable = [
        'id',
        'bill_number',
        'patient_id',
        'prescription_id',
        'payment_status'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    public function items()
    {
        return $this->hasMany(PharmacyBillItem::class,'bill_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

}