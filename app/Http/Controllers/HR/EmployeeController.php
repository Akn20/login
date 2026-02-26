<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $stats = [
            'total' => Employee::where('institution_id', auth()->user()->institution_id)->count(),
            'active' => Employee::where('is_active', true)->count(),
        ];

        $employees = Employee::search($request->search ?? '')
            ->with(['department', 'designation'])
            ->paginate(15);

        return view('hr.employees.index', compact('employees', 'stats'));
    }

    public function create()
    {
        return view('hr.employees.create', [
            'departments' => Department::where('status', true)->get(),
            'designations' => Designation::where('status', true)->get(),
        ]);
    }
}
