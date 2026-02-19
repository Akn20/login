<?php
// app/Models/Hospital.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'code',
        'institution_id',
        'address',
        'contact_number',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function financialYears()
    {
        return $this->belongsToMany(FinancialYear::class, 'hospital_financial_years')
            ->withPivot(['is_current', 'locked'])
            ->withTimestamps();
    }
}
