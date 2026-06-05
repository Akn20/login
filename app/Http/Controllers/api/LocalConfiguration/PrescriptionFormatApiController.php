<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\PrescriptionFormatSetting;

class PrescriptionFormatApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => PrescriptionFormatSetting::all()
        ]);
    }
}