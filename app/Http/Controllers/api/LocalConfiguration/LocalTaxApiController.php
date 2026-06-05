<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\LocalTaxSetting;

class LocalTaxApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => LocalTaxSetting::all()
        ]);
    }
}