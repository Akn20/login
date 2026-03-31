<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class NurseNotes extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'nurse_notes';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'institution_id',
        'patient_id',
        'nurse_id',
        'shift',
        'patient_condition',
        'intake_details',
        'output_details',
        'wound_care_notes',
    ];
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Staff::class, 'nurse_id');
    }
}
