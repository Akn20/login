<?php

use App\Models\AuditLog;

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