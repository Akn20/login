<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DispensingRecord extends Model
{
    use HasFactory;

    protected $table = 'dispensing_records';

    protected $fillable = [
        'id',
        'prescription_id',
        'medicine_id',
        'batch_id',
        'quantity_dispensed',
        'dispensed_by'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

}