<?php

namespace App\Observers;

use App\Models\Consultation;

class ConsultationObserver
{
    /**
     * Handle Consultation Created
     */
    public function created(Consultation $consultation): void
    {
        logDoctorAudit(

            'Consultation',

            'CREATE',

            $consultation->patient_id,

            $consultation->doctor_id,

            null,

            $consultation->toArray()

        );
    }

    /**
     * Handle Consultation Updated
     */
    public function updated(Consultation $consultation): void
    {
        logDoctorAudit(

            'Consultation',

            'UPDATE',

            $consultation->patient_id,

            $consultation->doctor_id,

            $consultation->getOriginal(),

            $consultation->getChanges()

        );
    }

    /**
     * Handle Consultation Deleted
     */
    public function deleted(Consultation $consultation): void
    {
        logDoctorAudit(

            'Consultation',

            'DELETE',

            $consultation->patient_id,

            $consultation->doctor_id,

            $consultation->getOriginal(),

            null

        );
    }
}