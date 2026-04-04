<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompOff extends Model
{
    use SoftDeletes;

    protected $table = 'comp_offs';

    protected $fillable = [
        'id',
        'employee_id',
        'worked_on',
        'comp_off_credited',
        'expiry_date'
    ];

    public $incrementing = false;

    protected $keyType = 'string';

  public function employee()
    {
        return $this->belongsTo(Staff::class, 'employee_id', 'id');
    }
}