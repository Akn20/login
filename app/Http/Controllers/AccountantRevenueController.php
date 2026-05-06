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
                'b.bill_date',
                'b.grand_total',

                DB::raw("IFNULL(s.name, '-') as doctor"),

                DB::raw("IFNULL(d.department_name, '-') as department")
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
}