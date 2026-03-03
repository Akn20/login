<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'user_id',
        'date',
        'checkin_time',
        'checkout_time',
        'checkin_lat',
        'checkin_lng',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
