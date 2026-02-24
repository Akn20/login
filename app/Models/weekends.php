<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class weekends extends Model
{
  use HasFactory, SoftDeletes;

    protected $table = 'weekends';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'days',
        'details',
        'status',
    ];

    protected $casts = [
        'days' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
