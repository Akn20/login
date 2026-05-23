<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Expense extends Model
{
    use SoftDeletes;

    protected $table = 'expenses';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'category_id',
        'vendor_id',
        'entry_date',
        'expense_type',
        'invoice_date',
        'invoice_number',
        'po_attachment',
        'grand_total',
        'payment_status',
        'payment_mode',
        'payment_date',
        'paid_amount',
        'transaction_id',
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
     * Category Relation
     */
    public function category()
    {
        return $this->belongsTo(
            ExpenseCategory::class,
            'category_id'
        );
    }

    /**
     * Vendor Relation
     */
    public function vendor()
    {
        return $this->belongsTo(
            InventoryVendor::class,
            'vendor_id'
        );
    }

    /**
     * Expense Items Relation
     */
    public function items()
    {
        return $this->hasMany(
            ExpenseItem::class,
            'expense_id'
        );
    }
}