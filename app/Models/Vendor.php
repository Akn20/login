<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
<<<<<<< HEAD
=======
use Illuminate\Support\Str;
>>>>>>> 08a41432ec1737b40c74ea5b2910d7a80b1049a5

class Vendor extends Model
{
    use SoftDeletes;

<<<<<<< HEAD
    protected $fillable = [
        'name',
        'phone',
        'email',
        'address',
        'status'
    ];
}
=======
    protected $table = 'vendors';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'vendor_name',
        'phone_number',
        'email',
        'address',
        'status',
        'created_by',
        'updated_by',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'vendor_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'vendor_id');
    }
}
>>>>>>> 08a41432ec1737b40c74ea5b2910d7a80b1049a5
