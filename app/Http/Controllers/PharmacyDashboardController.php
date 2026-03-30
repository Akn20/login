<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MedicineBatch;
use App\Models\OfflinePrescription;
use App\Models\Expiry;
use App\Models\ControlledDrug;
use App\Models\ReturnMedicine;
use App\Models\SalesBill;
use Illuminate\Http\Request;

class PharmacyDashboardController extends Controller
{
    public function index()
    {
        // 1. Pending Prescriptions (you have status here ✅)
        $pendingPrescriptions = OfflinePrescription::where('status', 'pending')->count();

        // 2. Today's Sales
        $todaySales = SalesBill::whereDate('created_at', Carbon::today())
                        ->sum('total_amount');

        // 3. Low Stock (use your helper logic)
        $lowStock = MedicineBatch::whereColumn('quantity', '<=', 'reorder_level')->count();

        // 4. Expiry Alerts (next 30 days)
        $expiryAlerts = MedicineBatch::whereBetween('expiry_date', [
                            Carbon::today(),
                            Carbon::today()->addDays(30)
                        ])->count();

        // 5. Controlled Drugs (use status if needed)
        $controlledDrugs = ControlledDrug::count();

        // 6. Return Requests (NO status column ❗)
        $returnRequests = ReturnMedicine::count();

        return view('admin.pharmacy.dashboard', compact(
            'pendingPrescriptions',
            'todaySales',
            'lowStock',
            'expiryAlerts',
            'controlledDrugs',
            'returnRequests'
        ));
    }
}
