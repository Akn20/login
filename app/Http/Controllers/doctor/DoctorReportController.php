<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Staff;
use App\Models\Surgery;
use App\Models\FollowUp;
use App\Models\IPDAdmission;
use App\Models\Department;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class DoctorReportController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | CONSULTATION SUMMARY PAGE
    |--------------------------------------------------------------------------
    */

    public function consultationSummary(Request $request)
    {

        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER : DOCTOR
        |--------------------------------------------------------------------------
        */

        if ($request->doctor_id) {

            $query->where('doctor_id', $request->doctor_id);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : DEPARTMENT
        |--------------------------------------------------------------------------
        */

        if ($request->department_id) {

            $query->whereHas('doctor.department', function ($q) use ($request) {

                $q->where('id', $request->department_id);

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : DATE RANGE
        |--------------------------------------------------------------------------
        */

        if ($request->from_date) {

            $query->whereDate(
                'consultation_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'consultation_date',
                '<=',
                $request->to_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : PATIENT NAME
        |--------------------------------------------------------------------------
        */

        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->patient_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | CONSULTATION DATA
        |--------------------------------------------------------------------------
        */

        $consultations = $query
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD COUNTS
        |--------------------------------------------------------------------------
        */

        $totalConsultations = Consultation::count();

        $todayConsultations = Consultation::whereDate(
            'consultation_date',
            Carbon::today()
        )->count();

        $opdCount = Consultation::count();

        $ipdCount = IPDAdmission::count();

        /*
        |--------------------------------------------------------------------------
        | DROPDOWNS
        |--------------------------------------------------------------------------
        */



        $departments = Department::all();

        return view(
            'doctor.reports.consultation-summary',
            compact(
                'consultations',
                'totalConsultations',
                'todayConsultations',
                'opdCount',
                'ipdCount',
                'departments'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | DOWNLOAD PDF REPORT
    |--------------------------------------------------------------------------
    */

    public function downloadConsultationReport(Request $request)
    {

        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        /*
        |--------------------------------------------------------------------------
        | APPLY FILTERS
        |--------------------------------------------------------------------------
        */



        if ($request->department_id) {

            $query->whereHas('doctor.department', function ($q) use ($request) {

                $q->where('id', $request->department_id);

            });
        }

        if ($request->from_date) {

            $query->whereDate(
                'consultation_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'consultation_date',
                '<=',
                $request->to_date
            );
        }

        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->patient_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

            });
        }

        /*
        |--------------------------------------------------------------------------
        | GET REPORT DATA
        |--------------------------------------------------------------------------
        */

        $consultations = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | PDF GENERATION
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'doctor.reports.consultation_report_pdf',
            compact('consultations')
        );

        /*
        |--------------------------------------------------------------------------
        | DOWNLOAD PDF
        |--------------------------------------------------------------------------
        */
        return $pdf->download('consultation_report.pdf');
    }

    public function opdSummary(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department'
        ]);

        // Doctor filter
        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        // Patient search
        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->patient_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

            });
        }

        // From date
        if ($request->from_date) {

            $query->whereDate(
                'consultation_date',
                '>=',
                $request->from_date
            );
        }

        // To date
        if ($request->to_date) {

            $query->whereDate(
                'consultation_date',
                '<=',
                $request->to_date
            );
        }

        $consultations = $query
            ->latest()
            ->get();

        $totalOpdCases = Consultation::count();

        $todayOpdCases = Consultation::whereDate(
            'consultation_date',
            today()
        )->count();

        $followUpCases = Consultation::whereNotNull(
            'diagnosis'
        )->count();

        $newPatients = Consultation::distinct(
            'patient_id'
        )->count('patient_id');

        $doctors = Staff::all();

        return view(
            'doctor.reports.opd-summary',
            compact(
                'consultations',
                'totalOpdCases',
                'todayOpdCases',
                'followUpCases',
                'newPatients',
                'doctors'
            )
        );
    }

    public function ipdSummary(Request $request)
    {
        $query = IPDAdmission::with([
            'patient',
            'doctor.department'
        ]);

        // Doctor filter
        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        // Patient search
        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where('first_name', 'like', '%' . $request->patient_name . '%')
                    ->orWhere('last_name', 'like', '%' . $request->patient_name . '%');

            });
        }

        // Status filter
        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        // From date
        if ($request->from_date) {

            $query->whereDate(
                'admission_date',
                '>=',
                $request->from_date
            );
        }

        // To date
        if ($request->to_date) {

            $query->whereDate(
                'admission_date',
                '<=',
                $request->to_date
            );
        }

        $admissions = $query
            ->latest()
            ->get();

        $totalAdmissions = IPDAdmission::count();

        $activeAdmissions = IPDAdmission::where(
            'status',
            'active'
        )->count();

        $dischargedPatients = IPDAdmission::where(
            'status',
            'discharged'
        )->count();

        $todayAdmissions = IPDAdmission::whereDate(
            'admission_date',
            today()
        )->count();

        $doctors = Staff::all();

        return view(
            'doctor.reports.ipd-summary',
            compact(
                'admissions',
                'totalAdmissions',
                'activeAdmissions',
                'dischargedPatients',
                'todayAdmissions',
                'doctors'
            )
        );
    }

    public function prescriptionSummary(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        // Doctor Filter
        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        // From Date
        if ($request->from_date) {

            $query->whereDate(
                'consultation_date',
                '>=',
                $request->from_date
            );
        }

        // To Date
        if ($request->to_date) {

            $query->whereDate(
                'consultation_date',
                '<=',
                $request->to_date
            );
        }

        $consultations = $query
            ->latest()
            ->get();

        $totalPrescriptions = Consultation::count();

        $todayPrescriptions = Consultation::whereDate(
            'consultation_date',
            today()
        )->count();

        $doctors = Staff::all();

        return view(
            'doctor.reports.prescription-summary',
            compact(
                'consultations',
                'totalPrescriptions',
                'todayPrescriptions',
                'doctors'
            )
        );
    }

    public function surgerySummary(Request $request)
    {
        $query = Surgery::with([
            'patient',
            'doctor.department'
        ]);

        // Doctor filter
        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        // Surgery status
        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        // From date
        if ($request->from_date) {

            $query->whereDate(
                'surgery_date',
                '>=',
                $request->from_date
            );
        }

        // To date
        if ($request->to_date) {

            $query->whereDate(
                'surgery_date',
                '<=',
                $request->to_date
            );
        }

        $surgeries = $query
            ->latest()
            ->get();

        $totalSurgeries = Surgery::count();

        $todaySurgeries = Surgery::whereDate(
            'surgery_date',
            today()
        )->count();

        $emergencySurgeries = Surgery::where(
            'priority',
            'Emergency'
        )->count();

        $normalSurgeries = Surgery::where(
            'priority',
            'Normal'
        )->count();
        $doctors = Staff::all();

        return view(
            'doctor.reports.surgery-summary',
            compact(
                'surgeries',
                'totalSurgeries',
                'emergencySurgeries',
                'normalSurgeries',
                'todaySurgeries',
                'doctors'
            )
        );
    }


    public function followupCompliance(Request $request)
    {

        /*
        |--------------------------------------------------------------------------
        | BASE QUERY
        |--------------------------------------------------------------------------
        */

        $query = FollowUp::with([
            'patient',
            'doctor.department',
            'consultation'
        ]);

        /*
        |--------------------------------------------------------------------------
        | FILTER : DOCTOR
        |--------------------------------------------------------------------------
        */

        if ($request->doctor_id) {

            $query->where(
                'doctor_id',
                $request->doctor_id
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : DEPARTMENT
        |--------------------------------------------------------------------------
        */

        if ($request->department_id) {

            $query->whereHas('doctor.department', function ($q) use ($request) {

                $q->where(
                    'id',
                    $request->department_id
                );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : PATIENT SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->patient_name) {

            $query->whereHas('patient', function ($q) use ($request) {

                $q->where(
                    'first_name',
                    'like',
                    '%' . $request->patient_name . '%'
                )

                    ->orWhere(
                        'last_name',
                        'like',
                        '%' . $request->patient_name . '%'
                    );

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER : DATE RANGE
        |--------------------------------------------------------------------------
        */

        if ($request->from_date) {

            $query->whereDate(
                'follow_up_date',
                '>=',
                $request->from_date
            );
        }

        if ($request->to_date) {

            $query->whereDate(
                'follow_up_date',
                '<=',
                $request->to_date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FOLLOW-UP DATA
        |--------------------------------------------------------------------------
        */

        $followUps = $query
            ->latest()
            ->paginate(10);

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD COUNTS
        |--------------------------------------------------------------------------
        */

        $totalFollowups = FollowUp::count();

        $todayFollowups = FollowUp::whereDate(
            'follow_up_date',
            today()
        )->count();

        $completedFollowups = FollowUp::where(
            'status',
            'Completed'
        )->count();

        $pendingFollowups = FollowUp::where(
            'status',
            'Pending'
        )->count();

        $missedFollowups = FollowUp::where(
            'status',
            'Missed'
        )->count();

        /*
        |--------------------------------------------------------------------------
        | COMPLIANCE %
        |--------------------------------------------------------------------------
        */

        $compliancePercentage = 0;

        if ($totalFollowups > 0) {

            $compliancePercentage = round(
                ($completedFollowups / $totalFollowups) * 100,
                2
            );
        }

        /*
        |--------------------------------------------------------------------------
        | DROPDOWNS
        |--------------------------------------------------------------------------
        */

        $doctors = Staff::all();

        $departments = Department::all();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'doctor.reports.followup-compliance',
            compact(
                'followUps',
                'totalFollowups',
                'todayFollowups',
                'completedFollowups',
                'pendingFollowups',
                'missedFollowups',
                'compliancePercentage',
                'doctors',
                'departments'
            )
        );
    }

    public function apiConsultationSummary(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->department_id) {
            $query->whereHas('doctor.department', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        if ($request->from_date) {
            $query->whereDate('consultation_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('consultation_date', '<=', $request->to_date);
        }

        if ($request->patient_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient_name}%")
                    ->orWhere('last_name', 'like', "%{$request->patient_name}%");
            });
        }

        return response()->json([
            'status' => true,
            'totalConsultations' => Consultation::count(),
            'todayConsultations' => Consultation::whereDate('consultation_date', today())->count(),
            'opdCount' => Consultation::count(),
            'ipdCount' => IPDAdmission::count(),
            'departments' => Department::all(),
            'data' => $query->latest()->get()
        ]);
    }

    public function apiDownloadConsultationReport(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        if ($request->department_id) {
            $query->whereHas('doctor.department', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        if ($request->from_date) {
            $query->whereDate('consultation_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('consultation_date', '<=', $request->to_date);
        }

        if ($request->patient_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient_name}%")
                    ->orWhere('last_name', 'like', "%{$request->patient_name}%");
            });
        }

        $consultations = $query->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $consultations
        ]);
    }

    public function apiOpdSummary(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->patient_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient_name}%")
                    ->orWhere('last_name', 'like', "%{$request->patient_name}%");
            });
        }

        if ($request->from_date) {
            $query->whereDate('consultation_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('consultation_date', '<=', $request->to_date);
        }

        return response()->json([
            'status' => true,
            'totalOpdCases' => Consultation::count(),
            'todayOpdCases' => Consultation::whereDate('consultation_date', today())->count(),
            'followUpCases' => Consultation::whereNotNull('diagnosis')->count(),
            'newPatients' => Consultation::distinct('patient_id')->count('patient_id'),
            'doctors' => Staff::all(),
            'data' => $query->latest()->get()
        ]);
    }

    public function apiIpdSummary(Request $request)
    {
        $query = IPDAdmission::with([
            'patient',
            'doctor.department'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->patient_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient_name}%")
                    ->orWhere('last_name', 'like', "%{$request->patient_name}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from_date) {
            $query->whereDate('admission_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('admission_date', '<=', $request->to_date);
        }

        return response()->json([
            'status' => true,
            'totalAdmissions' => IPDAdmission::count(),
            'activeAdmissions' => IPDAdmission::where('status', 'active')->count(),
            'dischargedPatients' => IPDAdmission::where('status', 'discharged')->count(),
            'todayAdmissions' => IPDAdmission::whereDate('admission_date', today())->count(),
            'doctors' => Staff::all(),
            'data' => $query->latest()->get()
        ]);
    }

    public function apiPrescriptionSummary(Request $request)
    {
        $query = Consultation::with([
            'patient',
            'doctor.department',
            'medicines'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->from_date) {
            $query->whereDate('consultation_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('consultation_date', '<=', $request->to_date);
        }

        return response()->json([
            'status' => true,
            'totalPrescriptions' => Consultation::count(),
            'todayPrescriptions' => Consultation::whereDate('consultation_date', today())->count(),
            'doctors' => Staff::all(),
            'data' => $query->latest()->get()
        ]);
    }

    public function apiSurgerySummary(Request $request)
    {
        $query = Surgery::with([
            'patient',
            'doctor.department'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->from_date) {
            $query->whereDate('surgery_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('surgery_date', '<=', $request->to_date);
        }

        return response()->json([
            'status' => true,
            'totalSurgeries' => Surgery::count(),
            'todaySurgeries' => Surgery::whereDate('surgery_date', today())->count(),
            'emergencySurgeries' => Surgery::where('priority', 'Emergency')->count(),
            'normalSurgeries' => Surgery::where('priority', 'Normal')->count(),
            'doctors' => Staff::all(),
            'data' => $query->latest()->get()
        ]);
    }

    public function apiFollowupCompliance(Request $request)
    {
        $query = FollowUp::with([
            'patient',
            'doctor.department',
            'consultation'
        ]);

        if ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->department_id) {
            $query->whereHas('doctor.department', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->patient_name) {
            $query->whereHas('patient', function ($q) use ($request) {
                $q->where('first_name', 'like', "%{$request->patient_name}%")
                    ->orWhere('last_name', 'like', "%{$request->patient_name}%");
            });
        }

        if ($request->from_date) {
            $query->whereDate('follow_up_date', '>=', $request->from_date);
        }

        if ($request->to_date) {
            $query->whereDate('follow_up_date', '<=', $request->to_date);
        }

        $total = FollowUp::count();

        $completed = FollowUp::where(
            'status',
            'Completed'
        )->count();

        return response()->json([
            'status' => true,
            'totalFollowups' => $total,
            'todayFollowups' => FollowUp::whereDate('follow_up_date', today())->count(),
            'completedFollowups' => $completed,
            'pendingFollowups' => FollowUp::where('status', 'Pending')->count(),
            'missedFollowups' => FollowUp::where('status', 'Missed')->count(),
            'compliancePercentage' => $total > 0 ? round(($completed / $total) * 100, 2) : 0,
            'doctors' => Staff::all(),
            'departments' => Department::all(),
            'data' => $query->latest()->get()
        ]);
    }
}