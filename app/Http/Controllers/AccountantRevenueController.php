<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountantRevenueController extends Controller
{
    public function index(Request $request)
    {
        // ============================================
        //  FILTER INPUTS
        // ============================================

        $fromDate   = $request->from_date;
        $toDate     = $request->to_date;
        $department = $request->department;
        $doctor     = $request->doctor;

        // ============================================
        //  DROPDOWN DATA
        // ============================================

        $departments = DB::table('department_master')
            ->orderBy('department_name')
            ->get();

        $doctors = DB::table('staff')
            ->orderBy('name')
            ->get();

        // ============================================
        //  SUMMARY QUERY
        // ============================================

        $summaryQuery = DB::table('ipd_bills');

        if ($fromDate) {
            $summaryQuery->whereDate('bill_date', '>=', $fromDate);
        }

        if ($toDate) {
            $summaryQuery->whereDate('bill_date', '<=', $toDate);
        }

        // ============================================
        //  SUMMARY DATA
        // ============================================

        // TOTAL REVENUE
        $totalRevenue = (clone $summaryQuery)
            ->sum('grand_total');

        // TODAY REVENUE
        $todayRevenue = DB::table('ipd_bills')
            ->whereDate('bill_date', Carbon::today())
            ->sum('grand_total');

        // MONTHLY REVENUE
        $monthlyRevenue = DB::table('ipd_bills')
            ->whereMonth('bill_date', Carbon::now()->month)
            ->whereYear('bill_date', Carbon::now()->year)
            ->sum('grand_total');

        // ANNUAL REVENUE
        $annualRevenue = DB::table('ipd_bills')
            ->whereYear('bill_date', Carbon::now()->year)
            ->sum('grand_total');

        // ============================================
        //  REVENUE TABLE QUERY
        // ============================================

        $revenues = DB::table('ipd_bills as b')

            ->leftJoin('ipd_admissions as ipd', 'ipd.id', '=', 'b.ipd_id')

            ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')

            ->leftJoin(
                'department_master as d',
                'd.id',
                '=',
                'ipd.department_id'
            )

            ->select(
    'b.bill_date as date',

    DB::raw("IFNULL(d.department_name, '-') as department"),
    DB::raw("IFNULL(s.name, '-') as doctor"),

    DB::raw("'IPD Bill' as service"), // ✅ temporary service

    'b.grand_total as amount' // ✅ FIXED
);
        // ============================================
        // 🔹 APPLY FILTERS
        // ============================================

        if ($fromDate) {
            $revenues->whereDate('b.bill_date', '>=', $fromDate);
        }

        if ($toDate) {
            $revenues->whereDate('b.bill_date', '<=', $toDate);
        }

        if ($department) {
            $revenues->where('ipd.department_id', $department);
        }

        if ($doctor) {
            $revenues->where('ipd.doctor_id', $doctor);
        }

        // ============================================
        //  PAGINATION
        // ============================================

        $revenues = $revenues
            ->orderBy('b.bill_date', 'desc')
            ->paginate(10);

        // ============================================
        //  RETURN VIEW
        // ============================================

        return view(
            'admin.Accountant.Revenue-Management.index',
            compact(
                'totalRevenue',
                'todayRevenue',
                'monthlyRevenue',
                'annualRevenue',
                'revenues',
                'departments',
                'doctors'
            )
        );
    }
//--------------API methods-----------------------
public function apiIndex(Request $request)
{
    $fromDate   = $request->from_date;
    $toDate     = $request->to_date;
    $department = $request->department;
    $doctor     = $request->doctor;

    $query = DB::table('ipd_bills as b')
        ->leftJoin('ipd_admissions as ipd', 'ipd.id', '=', 'b.ipd_id');

    if ($fromDate) {
        $query->whereDate('b.bill_date', '>=', $fromDate);
    }

    if ($toDate) {
        $query->whereDate('b.bill_date', '<=', $toDate);
    }

    if ($department) {
        $query->where('ipd.department_id', $department);
    }

    if ($doctor) {
        $query->where('ipd.doctor_id', $doctor);
    }

    return response()->json([
        'total_revenue' => (clone $query)->sum('b.grand_total'),

        'today_revenue' => DB::table('ipd_bills')
            ->whereDate('bill_date', now())
            ->sum('grand_total'),

        'monthly_revenue' => DB::table('ipd_bills')
            ->whereMonth('bill_date', now()->month)
            ->whereYear('bill_date', now()->year)
            ->sum('grand_total'),

        'annual_revenue' => DB::table('ipd_bills')
            ->whereYear('bill_date', now()->year)
            ->sum('grand_total'),
    ]);
}
public function revenueList(Request $request)
{
    $query = DB::table('ipd_bills as b')

        ->leftJoin('ipd_admissions as ipd', 'ipd.id', '=', 'b.ipd_id')

        ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')

        ->leftJoin('department_master as d', 'd.id', '=', 'ipd.department_id')

        ->select(
            'b.bill_date as date',
            DB::raw("COALESCE(d.department_name, 'N/A') as department"),
            DB::raw("COALESCE(s.name, 'N/A') as doctor"),
            DB::raw("'IPD Billing' as service"),
            'b.grand_total as amount'
        );

    // ⚠️ REMOVE filters temporarily for testing

    return response()->json(
        $query->orderBy('b.bill_date', 'desc')->get()
    );
}
public function dropdowns()
{
    return response()->json([
        'departments' => DB::table('department_master')
            ->select('id', 'department_name as name')
            ->orderBy('department_name')
            ->get(),

        'doctors' => DB::table('staff')
            ->select('id', 'name')
            ->orderBy('name')
            ->get(),
    ]);
}
public function departmentRevenue()
{
    $data = DB::table('ipd_bills as b')
        ->leftJoin('ipd_admissions as ipd', 'ipd.id', '=', 'b.ipd_id')
        ->leftJoin('department_master as d', 'd.id', '=', 'ipd.department_id')
        ->select(
            DB::raw("IFNULL(d.department_name, 'Unknown') as department"),
            DB::raw('SUM(b.grand_total) as revenue')
        )
        ->groupBy('d.department_name')
        ->get();

    return response()->json($data);
}
public function doctorRevenue()
{
    $data = DB::table('ipd_bills as b')
        ->leftJoin('ipd_admissions as ipd', 'ipd.id', '=', 'b.ipd_id')
        ->leftJoin('staff as s', 's.id', '=', 'ipd.doctor_id')
        ->select(
            DB::raw("IFNULL(s.name, 'Unknown') as doctor"),
            DB::raw('SUM(b.grand_total) as revenue')
        )
        ->groupBy('s.name')
        ->get();

    return response()->json($data);
}
public function serviceRevenue()
{
    $data = DB::table('ipd_services')
        ->select(
            'service_name as service',
            DB::raw('SUM(amount) as revenue')
        )
        ->groupBy('service_name')
        ->get();

    return response()->json($data);
}

}