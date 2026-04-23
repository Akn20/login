<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryUsageLog;

class InventoryUsageController extends Controller
{
    public function index()
    {
        $logs = InventoryUsageLog::with('item')->latest()->get();

        return view('admin.laboratory.inventory.usage.index', compact('logs'));
    }
}