<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceptionistBilling extends Model
{
    protected $table = 'receptionist_billing';
    public $incrementing = false;   
    protected $keyType = 'string';  

    protected $fillable = [
        'id',
        'receipt_no',
        'patient_id',
        'visit_id',
        'amount',
        'payment_mode',
        'collected_by'
    ];

    //  Auto-generate UUID
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}

