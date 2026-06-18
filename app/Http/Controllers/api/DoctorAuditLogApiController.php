<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DoctorAuditLog;
use Illuminate\Http\Request;

class DoctorAuditLogApiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | List Audit Logs
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = DoctorAuditLog::with([
            'patient',
            'doctor'
        ]);

        // Filters

        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );

        }

        if ($request->patient_id) {

            $query->where(
                'patient_id',
                $request->patient_id
            );

        }

        if ($request->module_name) {

            $query->where(
                'module_name',
                $request->module_name
            );

        }

        if ($request->action_type) {

            $query->where(
                'action_type',
                $request->action_type
            );

        }

        // Date Filter

        if ($request->from_date && $request->to_date) {

            $query->whereBetween(
                'created_at',
                [
                    $request->from_date,
                    $request->to_date
                ]
            );

        }

        $logs = $query
            ->latest()
            ->paginate(20);

        return response()->json([

            'status' => true,

            'message' => 'Doctor audit logs fetched successfully',

            'data' => $logs

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Show Single Audit
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $log = DoctorAuditLog::with([
            'patient',
            'doctor'
        ])->find($id);

        if (! $log) {

            return response()->json([

                'status' => false,

                'message' => 'Audit log not found'

            ], 404);

        }

        return response()->json([

            'status' => true,

            'data' => $log

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Audit Log
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $log = DoctorAuditLog::find($id);

        if (! $log) {

            return response()->json([

                'status' => false,

                'message' => 'Audit log not found'

            ], 404);

        }

        $log->delete();

        return response()->json([

            'status' => true,

            'message' => 'Audit log deleted successfully'

        ]);
    }
}