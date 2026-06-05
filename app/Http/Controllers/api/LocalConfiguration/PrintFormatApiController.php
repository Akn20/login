<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\PrintFormatSetting;

class PrintFormatApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => PrintFormatSetting::all()
        ]);
    }
}