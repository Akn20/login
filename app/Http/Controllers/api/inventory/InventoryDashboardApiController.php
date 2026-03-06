<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\Grn;

class InventoryDashboardApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'totalItems' => Item::count(),
            'lowStockItems' => Item::whereColumn('stock','<=','reorder_level')->count(),
            'totalPO' => PurchaseOrder::count(),
            'totalStockValue' => Item::sum(\DB::raw('stock * purchase_price')),
            //'recentPOs' => PurchaseOrder::latest()->take(5)->get(),
            //updated by sushan for api
            'recentPOs' => PurchaseOrder::with('vendor')->latest()->take(5)->get(),
            'recentGrns' => Grn::latest()->take(5)->get(),
        ]);
    }
}