<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InventoryItem;

class InventoryExpiryController extends Controller
{
    public function index()
    {
        $items = InventoryItem::whereNotNull('expiry_date')->get();

        return view('admin.laboratory.inventory.expiry.index', compact('items'));
    }
}