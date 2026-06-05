<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExpenseCategory extends Model
{
    protected $table = 'expense_categories';

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'category_name',
        'is_deleted',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}