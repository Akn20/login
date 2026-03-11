<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PrescriptionItem extends Model
{
    use HasFactory;

    protected $table = 'prescription_items';

    protected $fillable = [
        'id',
        'prescription_id',
        'medicine_id',
        'dosage',
        'frequency',
        'duration',
        'quantity',
        'instructions'
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}