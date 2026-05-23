<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Plan extends Model
{
    use SoftDeletes;

    protected $table = 'plans';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'monthly_price',
        'yearly_price',
        'trial_days',
        'grace_days',
        'status'
    ];

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
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function limits()
    {
        return $this->hasOne(PlanLimit::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function modules()
    {
        return $this->belongsToMany(
            Module::class,
            'plan_modules',
            'plan_id',
            'module_id'
        );
    }
}