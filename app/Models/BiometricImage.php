<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BiometricImage extends Model
{
    protected $fillable = ['user_id', 'slot', 'path', 'url'];

    protected $casts = [
        'user_id' => 'string',
        'slot'    => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
