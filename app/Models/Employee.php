<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'employees';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'hospital_id',
        'institution_id',
        'department_id',
        'designation_id',
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone',
        'emergency_contact',
        'date_of_birth',
        'gender',
        'address',
        'joining_date',
        'confirmation_date',
        'contract_end_date',
        'employment_type',
        'basic_salary',
        'gross_salary',
        'is_active',
        'is_confirmed',
        'status_reason',
        'exit_date',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'joining_date' => 'date',
        'confirmation_date' => 'date',
        'contract_end_date' => 'date',
        'exit_date' => 'date',
        'basic_salary' => 'decimal:2',
        'gross_salary' => 'decimal:2',
        'is_active' => 'boolean',
        'is_confirmed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = Str::upper(Str::random(30));
            }

            // Auto-generate employee_id if not provided
            if (!$model->employee_id) {
                $prefix = match ($model->employment_type ?? 'Full-time') {
                    'Doctor' => 'DOC',
                    'Nurse' => 'NUR',
                    'Admin' => 'ADM',
                    default => 'EMP'
                };
                $model->employee_id = $prefix . str_pad(Employee::count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });

        static::updating(function ($model) {
            if (!$model->employee_id) {
                $prefix = match ($model->employment_type) {
                    'Doctor' => 'DOC',
                    'Nurse' => 'NUR',
                    'Admin' => 'ADM',
                    default => 'EMP'
                };
                $model->employee_id = $prefix . str_pad(Employee::where('id', '!=', $model->id)->count() + 1, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Relationships
    public function hospital()
    {
        return $this->belongsTo(Hospital::class, 'hospital_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class, 'designation_id');
    }

    // HR Dashboard Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByInstitution($query, $institutionId)
    {
        return $query->where('institution_id', $institutionId);
    }

    public function scopeByHospital($query, $hospitalId)
    {
        return $query->where('hospital_id', $hospitalId);
    }

    public function scopeByDepartment($query, $departmentId)
    {
        return $query->where('department_id', $departmentId);
    }

    // Computed Attributes
    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }

    public function getAgeAttribute()
    {
        return $this->date_of_birth ? Carbon::parse($this->date_of_birth)->age : null;
    }

    public function getTenureAttribute()
    {
        return $this->joining_date ? Carbon::parse($this->joining_date)->diffInMonths() : 0;
    }

    public function getContractStatusAttribute()
    {
        if (!$this->contract_end_date) {
            return 'Permanent';
        }

        $daysLeft = Carbon::parse($this->contract_end_date)->diffInDays();

        return $daysLeft > 30 ? 'Active' : ($daysLeft > 0 ? 'Expiring' : 'Expired');
    }

    // Query Scopes for Reports
    public function scopeDoctors($query)
    {
        return $query->whereHas('designation', function ($q) {
            $q->where('designation_name', 'like', '%Doctor%');
        });
    }

    public function scopeNurses($query)
    {
        return $query->whereHas('designation', function ($q) {
            $q->where('designation_name', 'like', '%Nurse%');
        });
    }

    public function scopeNewJoinees($query, $days = 30)
    {
        return $query->where('joining_date', '>=', now()->subDays($days));
    }

    // Status Checkers
    public function isCurrentlyEmployed()
    {
        return $this->is_active && !$this->exit_date;
    }

    public function isContractExpiringSoon()
    {
        return $this->contract_end_date &&
            Carbon::parse($this->contract_end_date)->lte(now()->addDays(30));
    }

    // Search Scope
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('employee_id', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        });
    }
}
