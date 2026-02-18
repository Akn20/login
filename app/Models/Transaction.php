<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'hospital_id',
        'financial_year_id',
        'reference',
        'amount',
    ];

    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    public function financialYear()
    {
        return $this->belongsTo(FinancialYear::class);
    }
}
