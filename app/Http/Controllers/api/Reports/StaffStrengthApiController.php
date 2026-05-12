<?php

namespace App\Http\Controllers\Api\Reports;

use App\Http\Controllers\Controller;




class StaffStrengthApiController extends Controller
{
    public function index()
    {
        $staff = \App\Models\Staff::with(['department','designation'])->get();

        return response()->json([
            'total' => $staff->count(),
            'active' => $staff->where('status','Active')->count(),
            'inactive' => $staff->where('status','Inactive')->count(),
            'data' => $staff
        ]);
    }
}