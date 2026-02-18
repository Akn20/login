<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'name', 'code'];

    public function financialYears()
    {
        return $this->belongsToMany(FinancialYear::class, 'hospital_financial_years')
            ->withPivot(['is_current', 'locked'])
            ->withTimestamps();
    }
}
