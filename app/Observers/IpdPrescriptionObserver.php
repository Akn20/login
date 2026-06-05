<?php

namespace App\Observers;

use App\Models\IpdPrescription;

class IpdPrescriptionObserver
{
    /*
    |--------------------------------------------------------------------------
    | Prescription Created
    |--------------------------------------------------------------------------
    */

    public function created(IpdPrescription $prescription): void
    {
        logDoctorAudit(

            'Prescription',

            'CREATE',

            $prescription->patient_id,

            $prescription->doctor_id,

            null,

            $prescription->toArray()

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Prescription Updated
    |--------------------------------------------------------------------------
    */

    public function updated(IpdPrescription $prescription): void
    {
        logDoctorAudit(

            'Prescription',

            'UPDATE',

            $prescription->patient_id,

            $prescription->doctor_id,

            $prescription->getOriginal(),

            $prescription->getChanges()

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Prescription Deleted
    |--------------------------------------------------------------------------
    */

    public function deleted(IpdPrescription $prescription): void
    {
        logDoctorAudit(

            'Prescription',

            'DELETE',

            $prescription->patient_id,

            $prescription->doctor_id,

            $prescription->getOriginal(),

            null

        );
    }
}