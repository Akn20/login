<?php

namespace App\Observers;

use App\Models\LabRequest;

class LabRequestObserver
{
    public function created(LabRequest $labRequest): void
    {
        logDoctorAudit(

            'Lab Request',

            'CREATE',

            $labRequest->patient_id,

            optional($labRequest->consultation)->doctor_id,

            null,

            $labRequest->toArray()

        );
    }

    public function updated(LabRequest $labRequest): void
    {
        logDoctorAudit(

            'Lab Request',

            'UPDATE',

            $labRequest->patient_id,

            optional($labRequest->consultation)->doctor_id,

            $labRequest->getOriginal(),

            $labRequest->getChanges()

        );
    }
}