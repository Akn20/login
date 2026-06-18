<?php

use App\Models\DoctorAuditLog;

/*
|--------------------------------------------------------------------------
| Global Helper Functions
|--------------------------------------------------------------------------
|
| IMPORTANT:
| After updating this helper file run:
|
| composer dump-autoload
| php artisan optimize:clear
|
*/

if (!function_exists('logDoctorAudit')) {

    function logDoctorAudit(

        $moduleName,

        $actionType,

        $patientId = null,

        $doctorId = null,

        $oldValue = null,

        $newValue = null

    ) {

        try {

            DoctorAuditLog::create([

                'patient_id' => $patientId,

                'doctor_id' => $doctorId,

                'module_name' => $moduleName,

                'action_type' => $actionType,

                'old_value' => $oldValue,

                'new_value' => $newValue,

                'ip_address' => request()->ip(),

                'device_info' => request()->userAgent(),

            ]);

        } catch (\Exception $e) {

            \Log::error(
                'Doctor Audit Failed: ' . $e->getMessage()
            );

        }

    }

}