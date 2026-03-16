<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LabRequest;
use App\Models\Department;
class LabTestController extends Controller
{

    public function create()
    {
        return view('admin.laboratory.tests.create');
    }

    public function store(Request $request)
    {
        // save lab test
    }
    public function index(Request $request)
    {
        $query = LabRequest::with(['patient', 'consultation.doctor']);

        // Filter by priority (urgency)
        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        // Filter by department
        if ($request->department) {
            $query->whereHas('consultation.doctor', function ($q) use ($request) {
                $q->where('department_id', $request->department);
            });
        }

        $labRequests = $query->latest()->get();

        $departments = Department::all();

        return view(
            'admin.laboratory.tests.view-labrequests',
            compact('labRequests', 'departments')
        );
    }

}
