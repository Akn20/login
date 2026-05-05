<?php

namespace App\Http\Controllers\Admin\Nurse;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vital;
use App\Models\MedicationAdministration;
use App\Models\Patient;

class NurseReportController extends Controller
{
    public function vitals(Request $request)
    {
         $query = DB::table('vitals as v')
        ->leftJoin('patients as p', 'v.patient_id', '=', 'p.id')
        ->leftJoin('staff as s', 'v.nurse_id', '=', 's.id')
        ->select(
            'v.*',
            DB::raw("CONCAT(p.first_name, ' ', p.last_name) as patient_name"),
           's.name as nurse_name'
        );

        // Filter by patient_id 
        if ($request->patient_id) {
            $query->where('v.patient_id', $request->patient_id);
        }

        // Filter by Date Range 
        if ($request->from && $request->to) {
            $query->whereBetween('recorded_at', [
                $request->from,
                $request->to
            ]);
        }
        $vitals = $query->orderBy('recorded_at', 'desc')->paginate(10);        

        $patients = DB::table('patients')
            ->select('id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->pluck('name', 'id');


        return view('admin.nurse.reports.vitals', compact('vitals', 'patients'));
    }

    public function medications(Request $request)
    {
        $query = DB::table('medication_administration as m')
            ->leftJoin('patients as p', 'm.patient_id', '=', 'p.id')
            ->leftJoin('staff as s', 'm.nurse_id', '=', 's.id')
            ->leftJoin('offline_prescription_items as pi', 'm.prescription_item_id', '=', 'pi.id')
            ->select(
                'm.*',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as patient_name"),
                's.name as nurse_name',
                'pi.medicine_name as medication_name'
            );

        if ($request->patient_id) {
            $query->where('patient_id', $request->patient_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $data = $query->orderBy('administered_time', 'desc')->paginate(10);

        return view('admin.nurse.reports.medication', compact('data'));
    }


    public function shiftReport(Request $request)
    {
        $query = DB::table('nurse_shift_handover as nsh')
            ->leftJoin('shift_assignments as sa', 'nsh.shift_assignment_id', '=', 'sa.id')
            ->leftJoin('shifts as sh', 'sa.shift_id', '=', 'sh.id')
            ->leftJoin('staff as st', 'sa.staff_id', '=', 'st.id')
            ->leftJoin('users as u', 'st.user_id', '=', 'u.id')
            ->select(
                'nsh.*',
                'u.name as nurse_name',
                'sh.shift_name',
                'sh.start_time',
                'sh.end_time'
            );

        // Filter by entry type
        if ($request->entry_type) {
            $query->where('nsh.entry_type', $request->entry_type);
        }

        // Filter by task status
        if ($request->task_status) {
            $query->where('nsh.task_status', $request->task_status);
        }

        $data = $query->orderBy('nsh.created_at', 'desc')->paginate(10);

        return view('admin.nurse.reports.shift', compact('data'));
    }

    public function patientSummary(Request $request)
    {
        $patientId = $request->patient_id;

        // Patient list for dropdown
        $patients = DB::table('patients')
            ->select('id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->pluck('name', 'id');

        $patient = null;
        $vitals = [];
        $medications = [];
        $notes = [];

        if ($patientId) {

            // Patient info
            $patient = DB::table('patients')->where('id', $patientId)->first();

            // Latest vitals
            $vitals = DB::table('vitals')
                ->where('patient_id', $patientId)
                ->orderBy('recorded_at', 'desc')
                ->limit(5)
                ->get();

            // Medications
            $medications = DB::table('medication_administration')
                ->where('patient_id', $patientId)
                ->orderBy('administered_time', 'desc')
                ->limit(5)
                ->get();

            // Nursing notes
            $notes = DB::table('nurse_notes')
                ->where('patient_id', $patientId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return view('admin.nurse.reports.patient-summary', compact(
            'patients',
            'patient',
            'vitals',
            'medications',
            'notes'
        ));
    }

    // API METHODS FOR MOBILE APP

    public function apiVitals(Request $request)
    {
        $query = DB::table('vitals as v')
            ->leftJoin('patients as p', 'v.patient_id', '=', 'p.id')
            ->leftJoin('staff as s', 'v.nurse_id', '=', 's.id')
            ->select(
                'v.*',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as patient_name"),
                's.name as nurse_name'
            );

        // Filter by patient_id 
        if ($request->patient_id) {
            $query->where('v.patient_id', $request->patient_id);
        }

        // Filter by Date Range 
        if ($request->from && $request->to) {
            $query->whereBetween('recorded_at', [
                $request->from,
                $request->to
            ]);
        }
        
        $vitals = $query->orderBy('recorded_at', 'desc')->get();        

        $patients = DB::table('patients')
            ->select('id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->pluck('name', 'id');

        return response()->json([
            'success' => true,
            'data' => $vitals,
            'patients' => $patients
        ]);
    }

    public function apiMedications(Request $request)
    {
        $query = DB::table('medication_administration as m')
            ->leftJoin('patients as p', 'm.patient_id', '=', 'p.id')
            ->leftJoin('staff as s', 'm.nurse_id', '=', 's.id')
            ->leftJoin('offline_prescription_items as pi', 'm.prescription_item_id', '=', 'pi.id')
            ->select(
                'm.*',
                DB::raw("CONCAT(p.first_name, ' ', p.last_name) as patient_name"),
                's.name as nurse_name',
                'pi.medicine_name as medication_name'
            );

        if ($request->patient_id) {
            $query->where('m.patient_id', $request->patient_id);
        }

        if ($request->status) {
            $query->where('m.status', $request->status);
        }

        $data = $query->orderBy('administered_time', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function apiShiftReport(Request $request)
    {
        $query = DB::table('nurse_shift_handover as nsh')
            ->leftJoin('shift_assignments as sa', 'nsh.shift_assignment_id', '=', 'sa.id')
            ->leftJoin('shifts as sh', 'sa.shift_id', '=', 'sh.id')
            ->leftJoin('staff as st', 'sa.staff_id', '=', 'st.id')
            ->leftJoin('users as u', 'st.user_id', '=', 'u.id')
            ->select(
                'nsh.*',
                'u.name as nurse_name',
                'sh.shift_name',
                'sh.start_time',
                'sh.end_time'
            );

        // Filter by entry type
        if ($request->entry_type) {
            $query->where('nsh.entry_type', $request->entry_type);
        }

        // Filter by task status
        if ($request->task_status) {
            $query->where('nsh.task_status', $request->task_status);
        }

        $data = $query->orderBy('nsh.created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ]);
    }

    public function apiPatientSummary(Request $request)
    {
        $patientId = $request->patient_id;

        // Patient list for dropdown
        $patients = DB::table('patients')
            ->select('id', DB::raw("CONCAT(first_name, ' ', last_name) as name"))
            ->pluck('name', 'id');

        $patient = null;
        $vitals = [];
        $medications = [];
        $notes = [];

        if ($patientId) {
            // Patient info
            $patient = DB::table('patients')->where('id', $patientId)->first();

            // Latest vitals
            $vitals = DB::table('vitals')
                ->where('patient_id', $patientId)
                ->orderBy('recorded_at', 'desc')
                ->limit(5)
                ->get();

            // Medications
            $medications = DB::table('medication_administration')
                ->where('patient_id', $patientId)
                ->orderBy('administered_time', 'desc')
                ->limit(5)
                ->get();

            // Nursing notes
            $notes = DB::table('nurse_notes')
                ->where('patient_id', $patientId)
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'success' => true,
            'patient' => $patient,
            'vitals' => $vitals,
            'medications' => $medications,
            'notes' => $notes,
            'patients' => $patients
        ]);
    }
}
