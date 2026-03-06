<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        'user_id',
        'employee_id',
        'name',
        'joining_date',
        'status',
       'department_id',
'designation_id',
        'role_id',
        'document_path',
        'basic_salary',
        'hra',
        'allowance',
    ];

    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
public function department()
{
    return $this->belongsTo(Department::class, 'department_id', 'id');
}

public function designation()
{
    return $this->belongsTo(Designation::class, 'designation_id', 'id');
}
}