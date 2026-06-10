<?php

use App\Models\AuditLog;
use App\Models\DoctorAuditLog;

if (!function_exists('logAudit')) {
    function logAudit($module, $action, $referenceId = null, $description = null)
    {
         AuditLog::create([
            'user_id' => auth()->id(),
            'module' => $module,
            'action' => $action,
            'reference_id' => $referenceId,
            'description' => $description,
            'performed_at' => now(),
        ]);
    }
}

if (!function_exists('logDoctorAudit')) {
    function logDoctorAudit(
        $moduleName,
        $actionType,
        $patientId = null,
        $doctorId = null,
        $oldValue = null,
        $newValue = null
    ) {
        DoctorAuditLog::create([
            'patient_id'  => $patientId,
            'doctor_id'   => $doctorId,
            'module_name' => $moduleName,
            'action_type' => $actionType,
            'old_value'   => $oldValue,
            'new_value'   => $newValue,
            'ip_address'  => request()->ip(),
            'device_info' => request()->userAgent(),
        ]);
    }
}