<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasUlids,SoftDeletes;

    protected $keyType="string";
    public $incrementing=false;

    protected $fillable = [
        'room_number',
        'ward_id',
        'room_type',
        'total_beds',
        'status'
    ];
    public function ward()
    {
        return $this->belongsTo(Ward::class); 
        
    }
    public function beds()
    {
        return $this->hasMany(Bed::class);
    }
}
