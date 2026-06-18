<?php

namespace App\Observers;

use App\Models\RadiologyReport;

class RadiologyReportObserver
{
    /*
    |--------------------------------------------------------------------------
    | Radiology Report Created
    |--------------------------------------------------------------------------
    */

    public function created(RadiologyReport $report): void
    {
        logDoctorAudit(

            'Radiology Report',

            'CREATE',

            optional($report->request)->patient_id,

            $report->radiologist_id,

            null,

            $report->toArray()

        );
    }

    /*
    |--------------------------------------------------------------------------
    | Radiology Report Updated
    |--------------------------------------------------------------------------
    */

    public function updated(RadiologyReport $report): void
    {
        logDoctorAudit(

            'Radiology Report',

            'UPDATE',

            optional($report->request)->patient_id,

            $report->radiologist_id,

            $report->getOriginal(),

            $report->getChanges()

        );
    }
}