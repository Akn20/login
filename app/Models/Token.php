<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Token extends Model
{
    use HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

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