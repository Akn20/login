<?php

namespace App\Http\Controllers\Admin\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\Grn;

class ReportController extends Controller
{
    public function index()
    {
        $totalItems = Item::count();

        $lowStockItems = Item::whereColumn('stock', '<=', 'reorder_level')->count();

        $totalPO = PurchaseOrder::count();

        $totalStockValue = Item::sum(\DB::raw('stock * purchase_price'));

        $recentPOs = PurchaseOrder::latest()->take(5)->get();

        $recentGrns = Grn::latest()->take(5)->get();

        return view('admin.inventory.reports.index', compact(
            'totalItems',
            'lowStockItems',
            'totalPO',
            'totalStockValue',
            'recentPOs',
            'recentGrns'
        ));
    }
}