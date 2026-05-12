<?php

namespace App\Http\Controllers\Admin\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccountantPayment;
use App\Models\IpdBill;
use Illuminate\Support\Facades\DB;

class AccountantDashboardController extends Controller
{
    public function index()
    {
        // Today's Revenue
        $todayRevenue = AccountantPayment::whereDate('created_at', today())
            ->sum('amount');

        // Daily Cash Collection
        $cashCollection = AccountantPayment::whereDate('created_at', today())
            ->where('payment_mode', 'Cash')
            ->sum('amount');

        // Total Bills
        $totalBills = IpdBill::count();

        // Pending Bills
        $pendingBills = IpdBill::get()
            ->filter(fn($bill) => $bill->payment_status == 'unpaid')
            ->count();

        // Partial Bills
        $partialBills = IpdBill::get()
            ->filter(fn($bill) => $bill->payment_status == 'partial')
            ->count();

        // Paid Bills
        $paidBills = IpdBill::get()
            ->filter(fn($bill) => $bill->payment_status == 'paid')
            ->count();

        // Outstanding Dues
        $outstandingDues = IpdBill::all()->sum('due_amount');

        return view('admin.Accountant.dashboard', compact(
            'todayRevenue',
            'cashCollection',
            'totalBills',
            'pendingBills',
            'partialBills',
            'paidBills',
            'outstandingDues'
        ));
    }
}
