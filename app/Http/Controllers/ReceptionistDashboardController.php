<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReceptionistDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // ✅ 1. Waiting Patients (tokens not completed)
        $waitingPatients = DB::table('tokens')
            ->where('status', 'WAITING')
            ->count();

        // ✅ 2. Token Queue
        $currentToken = DB::table('tokens')
            ->where('status', 'WAITING')
            ->orderBy('token_number')
            ->value('token_number');

        $waitingTokens = DB::table('tokens')
            ->where('status', 'WAITING')
            ->count();

        // ✅ 3. New Registrations Today
        $newRegistrations = DB::table('patients')
            ->whereDate('created_at', $today)
            ->count();

        // ✅ 4. Pending Admissions
        $pendingAdmissions = DB::table('ipd_admissions')
            ->where('status', 'active')
            ->count();

        // ✅ 5. Doctors Available (from staff table)
        $doctorRoleId = DB::table('roles')
            ->where('name', 'doctor')
            ->value('id');

        $totalDoctors = DB::table('staff')
            ->where('role_id', $doctorRoleId)
            ->count();

        $availableDoctors = DB::table('staff')
            ->where('role_id', $doctorRoleId)
            ->where('status', 'Active')
            ->count();

        // ✅ 6. Emergency Arrivals
        $emergencyCount = DB::table('emergency_cases')
            ->whereDate('created_at', $today)
            ->count();

        // ✅ 7. Appointments Chart (Last 7 days)
        $appointmentsChart = DB::table('appointments')
            ->select(
                DB::raw('DATE(appointment_date) as date'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('appointment_date', [
                Carbon::now()->subDays(6),
                Carbon::now()
            ])
            ->groupBy('date')
            ->pluck('total', 'date');

        // Fill missing days
        $appointmentData = [];
        $appointmentLabels = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $appointmentLabels[] = Carbon::parse($date)->format('D');
            $appointmentData[] = $appointmentsChart[$date] ?? 0;
        }

        // ✅ 8. Collection Chart (Last 7 days)
        $collectionChart = DB::table('receptionist_billing')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->whereBetween('created_at', [
                Carbon::now()->subDays(6),
                Carbon::now()
            ])
            ->groupBy('date')
            ->pluck('total', 'date');

        $collectionData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $collectionData[] = $collectionChart[$date] ?? 0;
        }

        return view('admin.Receptionist.Dashboard.dashboard', compact(
            'waitingPatients',
            'currentToken',
            'waitingTokens',
            'newRegistrations',
            'pendingAdmissions',
            'availableDoctors',
            'totalDoctors',
            'emergencyCount',
            'appointmentLabels',
            'appointmentData',
            'collectionData'
        ));
    }


//API function

    public function apiDashboard()  
    {
        $today = Carbon::today();

        // ✅ 1. Waiting Patients
        $waitingPatients = DB::table('tokens')
            ->where('status', 'WAITING')
            ->count();

        // ✅ 2. Token Queue
        $currentToken = DB::table('tokens')
            ->where('status', 'WAITING')
            ->orderBy('token_number')
            ->value('token_number');

        $waitingTokens = DB::table('tokens')
            ->where('status', 'WAITING')
            ->count();

        // ✅ 3. New Registrations
        $newRegistrations = DB::table('patients')
            ->whereDate('created_at', $today)
            ->count();

        // ✅ 4. Pending Admissions
        $pendingAdmissions = DB::table('ipd_admissions')
            ->where('status', 'active')
            ->count();

        // ✅ 5. Doctors
        $doctorRoleId = DB::table('roles')
            ->where('name', 'doctor')
            ->value('id');

        $totalDoctors = DB::table('staff')
            ->where('role_id', $doctorRoleId)
            ->count();

        $availableDoctors = DB::table('staff')
            ->where('role_id', $doctorRoleId)
            ->where('status', 'Active')
            ->count();

        // ✅ 6. Emergency
        $emergencyCount = DB::table('emergency_cases')
            ->whereDate('created_at', $today)
            ->count();

        // ✅ 7. Appointments Chart
        $appointmentsChart = DB::table('appointments')
            ->select(
                DB::raw('DATE(appointment_date) as date'),
                DB::raw('count(*) as total')
            )
            ->whereBetween('appointment_date', [
                Carbon::now()->subDays(6),
                Carbon::now()
            ])
            ->groupBy('date')
            ->pluck('total', 'date');

        $appointmentLabels = [];
        $appointmentData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $appointmentLabels[] = Carbon::parse($date)->format('D');
            $appointmentData[] = $appointmentsChart[$date] ?? 0;
        }

        // ✅ 8. Collection Chart
        $collectionChart = DB::table('receptionist_billing')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(amount) as total')
            )
            ->whereBetween('created_at', [
                Carbon::now()->subDays(6),
                Carbon::now()
            ])
            ->groupBy('date')
            ->pluck('total', 'date');

        $collectionData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $collectionData[] = $collectionChart[$date] ?? 0;
        }

        // ✅ FINAL JSON RESPONSE
        return response()->json([
            'success' => true,
            'data' => [
                'waiting_patients' => $waitingPatients,
                'token_queue' => [
                    'current' => $currentToken,
                    'waiting' => $waitingTokens,
                ],
                'new_registrations' => $newRegistrations,
                'pending_admissions' => $pendingAdmissions,
                'doctors' => [
                    'available' => $availableDoctors,
                    'total' => $totalDoctors,
                ],
                'emergency_arrivals' => $emergencyCount,
                'charts' => [
                    'appointments' => [
                        'labels' => $appointmentLabels,
                        'data' => $appointmentData,
                    ],
                    'collection' => [
                        'labels' => $appointmentLabels,
                        'data' => $collectionData,
                    ]
                ]
            ]
        ]);
    }
}