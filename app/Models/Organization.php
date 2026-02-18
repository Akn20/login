<?php

namespace App\Models;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Organization extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'type',
        'registration_number',
        'gst',

        'address',
        'city',
        'state',
        'country',
        'pincode',

        'contact_number',
        'email',
        'timezone',

        'organization_url',
        'software_url',
        'logo',
        'language',

        'admin_name',
        'admin_email',
        'admin_mobile',

        'status',

        'mou_copy',
        'po_number',
        'po_start_date',
        'po_end_date',

        'plan_type',
        'enabled_modules',

        'invoice_type',
        'invoice_frequency',
        'invoice_amount',

        'payment_status',
        'payment_date',
        'transaction_reference',

        'poc_name',
        'poc_email',
        'poc_contact',
        'support_sla'
    ];

    protected $casts = [
        'po_start_date' => 'date',
        'po_end_date'   => 'date',
        'payment_date'  => 'date',
    ];
    

public $incrementing = false;
protected $keyType = 'string';

protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (!$model->getKey()) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        }
    });
}

public function institutions()
{
    return $this->hasMany(Institution::class);
}

}

