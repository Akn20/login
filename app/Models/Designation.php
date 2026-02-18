<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\Department;

class Designation extends Model
{
    use SoftDeletes;

    protected $table = 'designation_master';

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'designation_code',
        'designation_name',
        'department_id',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

    /*
    |--------------------------------------------------------------------------
    | Auto-generate UUID
    |--------------------------------------------------------------------------
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

    /*
    |--------------------------------------------------------------------------
    | Relationship (optional for now)
    |--------------------------------------------------------------------------
    */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }

}
