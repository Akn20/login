<?php

namespace App\Http\Controllers\Api\LocalConfiguration;

use App\Http\Controllers\Controller;
use App\Models\HospitalWorkingHour;

class HospitalWorkingHoursApiController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => HospitalWorkingHour::all()
        ]);
    }
}