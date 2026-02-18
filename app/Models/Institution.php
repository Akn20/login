<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Institution extends Model
{
    use SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'organization_id',
        'name',
        'code',
        'gst_number',
        'address',
        'city',
        'state',
        'country',
        'pincode',
        'contact_number',
        'email',
        'timezone',

        'institution_url',
        'login_template',
        'logo',
        'default_language',

        'admin_name',
        'admin_email',
        'admin_mobile',
        'role',
        'status',

        'mou_copy',
        'po_number',
        'po_start_date',
        'po_end_date',
        'subscription_plan',

        'invoice_type',
        'invoice_frequency',
        'payment_mode',
        'invoice_amount',
        'payment_status',
        'payment_received',
        'payment_date',
        'transaction_reference',

        'poc_name',
        'poc_email',
        'poc_contact',
        'support_sla'
    ];

    protected $casts = [
        'payment_received' => 'boolean',
        'po_start_date' => 'date',
        'po_end_date' => 'date',
        'payment_date' => 'date',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (!$model->getKey()) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function modules()
    {
        return $this->belongsToMany(
            Module::class,
            'institution_module',
            'institution_id',
            'module_id'
        );
    }
}
