<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LabRequest;
use App\Models\ScanRequest;

class DoctorOrderExecutionController extends Controller
{
    public function index()
    {
        $labRequests = LabRequest::with('patient')
            ->latest()
            ->get();

        $scanRequests = ScanRequest::with([
            'patient',
            'scanType'
        ])
        ->latest()
        ->get();

        return view(
            'admin.nurse.doctor_order_execution.index',
            compact(
                'labRequests',
                'scanRequests'
            )
        );
    }

    public function show($id)
    {

    }

    public function execute($id)
    {

    }

    public function escalate($id)
    {

    }
}