<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SalesReturn extends Model
{
    protected $table = 'sales_returns';
   protected $primaryKey = 'id';


    protected $fillable = [
        'id',
        'return_number',
        'bill_id',
        'patient_id',
        'total_refund',
        'status',
        'created_by'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

public function items()
{
    return $this->hasMany(SalesReturnItem::class, 'sales_return_id', 'id');
}

   public function bill()
{
    return $this->belongsTo(SalesBill::class, 'bill_id', 'bill_id');
}

    public function creator()
{
    return $this->belongsTo(User::class,'created_by');
}
public function patient()
{
    return $this->belongsTo(Patient::class, 'patient_id', 'id');
}
public function getRouteKeyName()
{
    return 'id';
}
}