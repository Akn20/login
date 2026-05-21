<?php

namespace App\Http\Controllers\Admin\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountantPayment;
use App\Models\IpdBill;

class AccountantDashboardController extends Controller
{
    public function index()
    {
        $summary = $this->dashboardSummary();
        $revenueOverview = $this->revenueOverview();

        return view('admin.Accountant.dashboard', [
            'todayRevenue' => $summary['today_revenue'],
            'cashCollection' => $summary['daily_cash_collection'],
            'totalBills' => $summary['total_bills'],
            'pendingBills' => $summary['pending_bills'],
            'partialBills' => $summary['partial_bills'],
            'paidBills' => $summary['paid_bills'],
            'outstandingDues' => $summary['outstanding_dues'],
            'revenueChartLabels' => $revenueOverview['labels'],
            'revenueChartData' => $revenueOverview['data'],
        ]);
    }

    public function apiDashboard(Request $request)
    {
        $summary = $this->dashboardSummary();
        $revenueOverview = $this->revenueOverview();

        return response()->json([
            'status' => true,
            'data' => array_merge($summary, [
                'summary' => $summary,
                'revenue_overview' => $revenueOverview['items'],
                'revenue_chart_labels' => $revenueOverview['labels'],
                'revenue_chart_data' => $revenueOverview['data'],
            ]),
        ]);
    }

    public function apiSummary(Request $request)
    {
        return response()->json([
            'status' => true,
            'data' => $this->dashboardSummary(),
        ]);
    }

    public function apiRevenueOverview(Request $request)
    {
        $revenueOverview = $this->revenueOverview();

        return response()->json([
            'status' => true,
            'data' => [
                'labels' => $revenueOverview['labels'],
                'data' => $revenueOverview['data'],
                'revenue_overview' => $revenueOverview['items'],
            ],
        ]);
    }

    private function dashboardSummary(): array
    {
        $todayRevenue = AccountantPayment::whereDate('created_at', today())
            ->sum('amount');

        $cashCollection = AccountantPayment::whereDate('created_at', today())
            ->where('payment_mode', 'Cash')
            ->sum('amount');

        $bills = IpdBill::with('payments')->get();

        return [
            'today_revenue' => (float) $todayRevenue,
            'daily_cash_collection' => (float) $cashCollection,
            'cash_collection' => (float) $cashCollection,
            'outstanding_dues' => (float) $bills->sum(fn ($bill) => $bill->due_amount),
            'total_bills' => $bills->count(),
            'paid_bills' => $bills->filter(fn ($bill) => $bill->payment_status === 'paid')->count(),
            'partial_bills' => $bills->filter(fn ($bill) => $bill->payment_status === 'partial')->count(),
            'pending_bills' => $bills->filter(fn ($bill) => $bill->payment_status === 'unpaid')->count(),
        ];
    }

    private function revenueOverview(): array
    {
        $labels = [];
        $data = [];
        $items = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $amount = AccountantPayment::whereDate('created_at', $date)->sum('amount');

            $labels[] = $date->format('d M');
            $data[] = (float) $amount;
            $items[] = [
                'date' => $date->toDateString(),
                'label' => $date->format('d M'),
                'revenue' => (float) $amount,
            ];
        }

        return [
            'labels' => $labels,
            'data' => $data,
            'items' => $items,
        ];
    }
}