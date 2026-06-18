<?php

namespace App\Http\Controllers\Api\Inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryVendor;

class VendorApiController extends Controller
{
    public function index()
    {
        return InventoryVendor::select(
            'id',
            'vendor_name'
        )->get();
    }
}