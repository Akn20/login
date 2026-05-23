<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ExpenseItem extends Model
{
    protected $table = 'expense_items';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'expense_id',
        'expense_heading',
        'unit',
        'unit_price',
        'sub_total',
        'cgst',
        'sgst',
        'igst',
        'total',
        'attachment',
    ];

    /**
     * Auto UUID Generate
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    /**
     * Expense Relation
     */
    public function expense()
    {
        return $this->belongsTo(
            Expense::class,
            'expense_id'
        );
    }
}