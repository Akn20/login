<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MedicationAdministration extends Model
{
    use SoftDeletes;

    protected $table = 'medication_administration';

    protected $fillable = [
        'id',
        'patient_id',
        'nurse_id',
        'prescription_item_id',
        'administered_time',
        'status',
        'notes'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    public function prescriptionItem()
    {
        return $this->belongsTo(PrescriptionItem::class, 'prescription_item_id');
    }
}