<?php

namespace App\Observers;

use App\Models\IpdDischarge;

class IpdDischargeObserver
{
    /*
    |--------------------------------------------------------------------------
    | Discharge Created
    |--------------------------------------------------------------------------
    */

    public function created(IpdDischarge $discharge): void
    {
        logDoctorAudit(

            'Discharge Summary',

            'CREATE',

            optional($discharge->ipd)->patient_id,

            auth()->id(),

            null,

            $discharge->toArray()

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Discharge Updated
    |--------------------------------------------------------------------------
    */

    public function updated(IpdDischarge $discharge): void
    {
        logDoctorAudit(

            'Discharge Summary',

            'UPDATE',

            optional($discharge->ipd)->patient_id,

            auth()->id(),

            $discharge->getOriginal(),

            $discharge->getChanges()

        );
    }
}