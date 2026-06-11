<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsultationMedicine extends Model
{
    use HasFactory;

    protected $table = 'consultation_medicines';

    public $incrementing = true;

    protected $fillable = [
        'consultation_id',
        'medicine_id',
        'dosage',
        'frequency',
        'duration',
        'instructions'
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class, 'medicine_id', 'id');
    }

    public function consultation()
    {
        return $this->belongsTo(Consultation::class, 'consultation_id', 'id');
    }
}