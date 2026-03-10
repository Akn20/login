<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Token extends Model
{
    use HasUuids;

    protected $fillable = [
        'appointment_id',
        'token_number',
        'status'
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}