<?php

namespace App\Http\Controllers\Admin\PatientPortal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\PatientAlert;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientAlertController extends Controller
{
    /**
     * Display alerts list
     */

    public function index()
    {
        $this->generatePaymentAlerts();

        $this->generatePharmacyPaymentAlerts();

        $this->generateLabAlerts();

        $this->generateScanAlerts();

        $this->generateAppointmentAlerts();

        $this->generateFollowupAlerts();

        $alerts = PatientAlert::with('patient')
            ->latest()
            ->get();

        return view(
            'admin.patient-portal.PatientAlerts.index',
            compact('alerts')
        );
    }

    public function generatePaymentAlerts()
    {
        $bills = DB::table('ipd_bills')

            ->leftJoin(
                'accountant_payments',
                'ipd_bills.id',
                '=',
                'accountant_payments.bill_id'
            )

            ->select(
                'ipd_bills.id',
                'ipd_bills.patient_id',
                'ipd_bills.bill_no',
                'ipd_bills.payable_amount',

                DB::raw(
                    'COALESCE(SUM(accountant_payments.amount),0)
                    as paid_amount'
                )
            )

            ->groupBy(
                'ipd_bills.id',
                'ipd_bills.patient_id',
                'ipd_bills.bill_no',
                'ipd_bills.payable_amount'
            )

            ->get();

        foreach ($bills as $bill) {

            $dueAmount =
                $bill->payable_amount -
                $bill->paid_amount;

            if ($dueAmount <= 0) {
                continue;
            }

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'bill',
                    'related_id' => $bill->id,
                ],

                [
                    'hospital_id' => '1',
                    'patient_id' => $bill->patient_id,
                    'alert_type' => 'payment',
                    'title' => 'Pending Payment',
                    'message' => 'Outstanding due amount: ₹' .
                        number_format($dueAmount, 2),
                    'alert_date' => now(),
                ]
            );
        }
    }

    public function generatePharmacyPaymentAlerts()
    {
        $bills = DB::table('sales_bills')
            ->whereNotNull('patient_id')
            ->where('balance_amount', '>', 0)
            ->get();

            // Remove alerts whose dues are already cleared
            $activeBillIds = $bills->pluck('bill_id')->toArray();

            PatientAlert::where('related_type', 'pharmacy_bill')
                ->whereNotIn('related_id', $activeBillIds)
                ->delete();

        foreach ($bills as $bill) {

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'pharmacy_bill',
                    'related_id'   => $bill->bill_id,
                ],

                [
                    'hospital_id' => '1',

                    'patient_id' => $bill->patient_id,

                    'alert_type' => 'pharmacy',

                    'title' => 'Pharmacy Payment Pending',

                    'message' =>
                        'Outstanding pharmacy due amount: ₹' .
                        number_format($bill->balance_amount, 2),

                    'alert_date' => now(),
                ]
            );
        }
    }

    public function generateLabAlerts()
    {
        $labs = DB::table('lab_requests')
            ->where('status', 'completed')
            ->get();

        $activeLabIds = $labs->pluck('id')->toArray();

        PatientAlert::where('related_type', 'lab_request')
            ->whereNotIn('related_id', $activeLabIds)
            ->delete();

        foreach ($labs as $lab) {

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'lab_request',
                    'related_id'   => $lab->id,
                ],

                [
                    'hospital_id' => '1',

                    'patient_id' => $lab->patient_id,

                    'alert_type' => 'lab',

                    'title' => 'Lab Report Ready',

                    'message' =>
                        'Lab test "' . $lab->test_name . '" report is ready.',

                    'alert_date' => now(),
                ]
            );
        }
    }

    public function generateScanAlerts()
    {
        $scans = DB::table('scan_requests')
            ->where('status', 'Uploaded')
            ->get();

        $activeScanIds = $scans->pluck('id')->toArray();

        PatientAlert::where('related_type', 'scan_request')
            ->whereNotIn('related_id', $activeScanIds)
            ->delete();

        foreach ($scans as $scan) {

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'scan_request',
                    'related_id'   => $scan->id,
                ],

                [
                    'hospital_id' => '1',

                    'patient_id' => $scan->patient_id,

                    'alert_type' => 'radiology',

                    'title' => 'Scan Report Ready',

                    'message' =>
                        'Radiology scan report has been uploaded and is ready for viewing.',

                    'alert_date' => now(),
                ]
            );
        }
    }

    public function generateAppointmentAlerts()
    {
        $appointments = DB::table('appointments')
            ->where('appointment_status', 'Scheduled')
            ->whereDate('appointment_date', '>=', now()->toDateString())
            ->get();

        $activeAppointmentIds = $appointments->pluck('id')->toArray();

        PatientAlert::where('related_type', 'appointment')
            ->whereNotIn('related_id', $activeAppointmentIds)
            ->delete();

        foreach ($appointments as $appointment) {

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'appointment',
                    'related_id'   => $appointment->id,
                ],

                [
                    'hospital_id' => '1',

                    'patient_id' => $appointment->patient_id,

                    'alert_type' => 'appointment',

                    'title' => 'Upcoming Appointment',

                    'message' =>
                        'Appointment scheduled on ' .
                        date('d M Y', strtotime($appointment->appointment_date))
                        . ' at ' .
                        date('h:i A', strtotime($appointment->appointment_time)),

                    'alert_date' => $appointment->appointment_date . ' ' . $appointment->appointment_time,
                ]
            );
        }
    }

    public function generateFollowupAlerts()
    {
        $discharges = DB::table('ipd_discharges')

            ->join(
                'ipd_admissions',
                'ipd_discharges.ipd_id',
                '=',
                'ipd_admissions.id'
            )

            ->whereNotNull('ipd_discharges.follow_up')

            ->where('ipd_discharges.follow_up', '!=', '')

            ->select(
                'ipd_discharges.id',
                'ipd_discharges.follow_up',
                'ipd_discharges.date',
                'ipd_admissions.patient_id'
            )

            ->get();

        $activeIds = $discharges->pluck('id')->toArray();

        PatientAlert::where('related_type', 'followup')
            ->whereNotIn('related_id', $activeIds)
            ->delete();

        foreach ($discharges as $discharge) {

            PatientAlert::updateOrCreate(

                [
                    'related_type' => 'followup',
                    'related_id'   => $discharge->id,
                ],

                [
                    'hospital_id' => '1',

                    'patient_id' => $discharge->patient_id,

                    'alert_type' => 'followup',

                    'title' => 'Follow-up Reminder',

                    'message' => $discharge->follow_up,

                    'alert_date' => $discharge->date ?? now(),
                ]
            );
        }
    }

    /**
     * Show create form
     */
    public function create()
    {
        $patients = Patient::orderBy('first_name')->get();

        return view(
            'admin.patient-portal.PatientAlerts.create',
            compact('patients')
        );
    }

    /**
     * Store alert
     */
    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'alert_type' => 'required',

            'title' => 'required',

            'message' => 'required',

        ]);

        PatientAlert::create([

            'hospital_id' => 1,

            'patient_id' => $request->patient_id,

            'alert_type' => $request->alert_type,

            'title' => $request->title,

            'message' => $request->message,

            'alert_date' => $request->alert_date,

            'is_read' => false,

        ]);

        return redirect()
            ->route('patient-alerts.index')
            ->with('success', 'Patient alert created successfully.');
    }

    /**
     * Show alert details
     */
    public function show($id)
    {
        $alert = PatientAlert::with('patient')
            ->findOrFail($id);
        // Mark as read
            if (!$alert->is_read) {

                $alert->update([
                    'is_read' => true
                ]);
            }

        return view(
            'admin.patient-portal.PatientAlerts.show',
            compact('alert')
        );
    }

    //API FUNCTIONS

    /**
     * API - Alert List
     */
    public function apiList()
    {
        $this->generatePaymentAlerts();

        $this->generatePharmacyPaymentAlerts();

        $this->generateLabAlerts();

        $this->generateScanAlerts();

        $this->generateAppointmentAlerts();

        $this->generateFollowupAlerts();

        $alerts = PatientAlert::with('patient')
            ->latest()
            ->get();

        return response()->json([

            'success' => true,

            'message' => 'Alerts fetched successfully.',

            'data' => $alerts

        ]);
    }

    /**
     * API - Alert Details
     */
    public function apiView($id)
    {
        $alert = PatientAlert::with('patient')
            ->find($id);

        if (!$alert) {

            return response()->json([

                'success' => false,

                'message' => 'Alert not found.'

            ], 404);
        }

        if (!$alert->is_read) {

            $alert->update([
                'is_read' => true
            ]);
        }

        return response()->json([

            'success' => true,

            'message' => 'Alert details fetched successfully.',

            'data' => $alert

        ]);
    }

    /**
     * API - Create Alert
     */
    public function apiCreate(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'alert_type' => 'required',

            'title' => 'required',

            'message' => 'required',

        ]);

        $alert = PatientAlert::create([

            'hospital_id' => 1,

            'patient_id' => $request->patient_id,

            'alert_type' => $request->alert_type,

            'title' => $request->title,

            'message' => $request->message,

            'alert_date' => $request->alert_date,

            'is_read' => false,

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Alert created successfully.',

            'data' => $alert

        ]);
    }

    /**
     * API - Mark Alert Read
     */
    public function apiMarkRead($id)
    {
        $alert = PatientAlert::find($id);

        if (!$alert) {

            return response()->json([

                'success' => false,

                'message' => 'Alert not found.'

            ], 404);
        }

        $alert->update([

            'is_read' => true

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Alert marked as read.'

        ]);
    }

    public function apiCreateData()
    {
        $patients = Patient::orderBy('first_name')
            ->select(
                'id',
                'first_name',
                'last_name'
            )
            ->get();

        return response()->json([

            'success' => true,

            'message' => 'Create data fetched successfully.',

            'patients' => $patients

        ]);
    }    

}