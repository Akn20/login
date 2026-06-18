<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Referral;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Patient;
use App\Models\Department;
use App\Models\Roles;
class ReferralController extends Controller
{
    /**
     * Referral List Page
     */
    public function index(Request $request)
    {
        $query = Referral::query();

        // Search Filter
        if ($request->filled('search')) {

            $query->where('patient_id', 'like', '%' . $request->search . '%');
        }

        // Status Filter
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        // Priority Filter
        if ($request->filled('priority')) {

            $query->where('priority', $request->priority);
        }

        // Date Filter
        if ($request->filled('date')) {

            $query->whereDate('created_at', $request->date);
        }

        $referrals = $query
            ->with(['patient', 'referredDoctor', 'department'])
            ->latest()
            ->paginate(10);

        return view('doctor.referrals.index', compact('referrals'));
    }

    /**
     * Create Referral Page
     */


    public function create()
    {
        $patients = Patient::all();

        $doctors = User::whereHas('role', function ($query) {

            $query->where('name', 'doctor');

        })->get();

        $departments = Department::all();

        return view('doctor.referrals.create', compact(
            'patients',
            'doctors',
            'departments'
        ));
    }

    /**
     * Store Referral
     */
    public function store(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'referred_doctor_id' => 'required',

            'referral_reason' => 'required',

            'priority' => 'required',

        ]);

        Referral::create([

            'id' => Str::uuid(),

            'hospital_id' => null,

            'patient_id' => $request->patient_id,

            'doctor_id' => auth()->id(),

            'referred_doctor_id' => $request->referred_doctor_id,

            'referred_department_id' => $request->referred_department_id,

            'referral_type' => $request->referral_type,

            'priority' => $request->priority,

            'referral_reason' => $request->referral_reason,

            'clinical_notes' => $request->clinical_notes,

            'followup_date' => $request->followup_date,

            'status' => 'Pending',

            'created_by' => auth()->id(),

            'updated_by' => auth()->id(),

        ]);

        return redirect()
            ->route('doctor.referrals.index')
            ->with('success', 'Referral Created Successfully');
    }

    /**
     * View Referral
     */
    public function view($id)
    {
        $referral = Referral::with([
            'patient',
            'referredDoctor',
            'department'
        ])->findOrFail($id);

        return view(
            'doctor.referrals.view',
            compact('referral')
        );
    }

    /**
     * Edit Referral Page
     */
    public function edit($id)
    {
        $referral = Referral::findOrFail($id);

        $patients = Patient::all();

        // doctors using role_id
        $doctorRole = Roles::where('name', 'doctor')->first();

        $doctors = User::where('role_id', $doctorRole->id)->get();

        // departments
        $departments = Department::all();

        return view(
            'doctor.referrals.edit',
            compact(
                'referral',
                'patients',
                'doctors',
                'departments'
            )
        );
    }

    /**
     * Update Referral
     */
    public function update(Request $request, $id)
    {
        $request->validate([

            'referred_doctor_id' => 'required',

            'priority' => 'required',

            'referral_reason' => 'required',

            'status' => 'required',

        ]);

        $referral = Referral::findOrFail($id);

        $referral->update([

            'referred_doctor_id' => $request->referred_doctor_id,

            'referred_department_id' => $request->referred_department_id,

            'referral_type' => $request->referral_type,

            'priority' => $request->priority,

            'followup_date' => $request->followup_date,

            'referral_reason' => $request->referral_reason,

            'clinical_notes' => $request->clinical_notes,

            'status' => $request->status,

            'updated_by' => auth()->id(),

        ]);

        return redirect()
            ->route('doctor.referrals.index')
            ->with('success', 'Referral Updated Successfully');
    }

    /**
     * Delete Referral
     */
    public function destroy($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->delete();

        return redirect()
            ->back()
            ->with('success', 'Referral Moved To Trash');
    }

    /**
     * Update Status
     */
    public function updateStatus(Request $request, $id)
    {
        $referral = Referral::findOrFail($id);

        $referral->update([

            'status' => $request->status,

            'updated_by' => auth()->id(),

        ]);

        return redirect()
            ->back()
            ->with('success', 'Referral Status Updated');
    }

    public function markCompleted($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->status = 'Completed';

        $referral->save();

        return redirect()
            ->back()
            ->with('success', 'Referral Marked as Completed');
    }

    public function reject($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->status = 'Rejected';

        $referral->save();

        return redirect()
            ->back()
            ->with('success', 'Referral Rejected Successfully');
    }

    public function trash()
    {
        $referrals = Referral::onlyTrashed()
            ->latest()
            ->paginate(10);

        return view(
            'doctor.referrals.trash',
            compact('referrals')
        );
    }

    public function restore($id)
    {
        $referral = Referral::onlyTrashed()
            ->findOrFail($id);

        $referral->restore();

        return redirect()
            ->back()
            ->with('success', 'Referral Restored Successfully');
    }

    public function forceDelete($id)
    {
        $referral = Referral::onlyTrashed()
            ->findOrFail($id);

        $referral->forceDelete();

        return redirect()
            ->back()
            ->with('success', 'Referral Permanently Deleted');
    }

    //API functions
    public function apiIndex(Request $request)
    {
        try {

            $query = Referral::query();

            // Search Filter
            if ($request->filled('search')) {

                $query->whereHas('patient', function ($q) use ($request) {

                    $q->where('first_name', 'like', '%' . $request->search . '%')
                    ->orWhere('last_name', 'like', '%' . $request->search . '%');

                });

            }

            // Status Filter
            if ($request->filled('status')) {

                $query->where('status', $request->status);

            }

            // Priority Filter
            if ($request->filled('priority')) {

                $query->where('priority', $request->priority);

            }

            // Date Filter
            if ($request->filled('date')) {

                $query->whereDate('created_at', $request->date);

            }

            $referrals = $query
                ->with([
                    'patient',
                    'referredDoctor',
                    'department'
                ])
                ->latest()
                ->paginate(10);

            return response()->json([

                'status' => true,

                'message' => 'Referral List Fetched Successfully',

                'data' => $referrals

            ], 200);

        } catch (\Exception $e) {

            return response()->json([

                'status' => false,

                'message' => 'Failed To Fetch Referrals',

                'error' => $e->getMessage()

            ], 500);

        }
    }

    public function apiCreateData()
    {
        try {

            // Patients
            $patients = Patient::select(
                    'id',
                    'patient_code',
                    'first_name',
                    'last_name',
                    'gender',
                    'date_of_birth'
                )
                ->get();

            // Doctors
            $doctors = User::whereHas('role', function ($query) {

                    $query->where('name', 'doctor');

                })
                ->select('id', 'name')
                ->get();

            // Departments
            $departments = Department::select(
                    'id',
                    'department_name'
                )
                ->get();

            return response()->json([

                'status' => true,

                'message' => 'Create Referral Data Fetched Successfully',

                'patients' => $patients,

                'doctors' => $doctors,

                'departments' => $departments,

            ], 200);

        } catch (\Exception $e) {

            return response()->json([

                'status' => false,

                'message' => 'Failed To Fetch Create Data',

                'error' => $e->getMessage()

            ], 500);

        }
    }

    public function apiStore(Request $request)
    {
        $request->validate([

            'patient_id' => 'required',

            'referred_doctor_id' => 'required',

            'referral_reason' => 'required',

            'priority' => 'required',

        ]);

        $referral = Referral::create([

            'id' => Str::uuid(),

            'hospital_id' => null,

            'patient_id' => $request->patient_id,

            //'doctor_id' => auth()->id(),
            'doctor_id' => $request->doctor_id,


            'referred_doctor_id' => $request->referred_doctor_id,

            'referred_department_id' => $request->referred_department_id,

            'referral_type' => $request->referral_type,

            'priority' => $request->priority,

            'referral_reason' => $request->referral_reason,

            'clinical_notes' => $request->clinical_notes,

            'followup_date' => $request->followup_date,

            'status' => 'Pending',

            //'created_by' => auth()->id(),

            //'updated_by' => auth()->id(),

            'created_by' => $request->doctor_id,

            'updated_by' => $request->doctor_id,

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Referral Created Successfully',

            'data' => $referral

        ], 201);
    }

    public function apiView($id)
    {
        $referral = Referral::with([
            'patient',
            'doctor',
            'referredDoctor',
            'department'
        ])->findOrFail($id);

        return response()->json([

            'status' => true,

            'message' => 'Referral Details Fetched Successfully',

            'data' => $referral

        ], 200);
    }

    public function apiEditData($id)
    {
        $referral = Referral::with([
            'patient',
            'referredDoctor',
            'department'
        ])->findOrFail($id);

        $patients = Patient::all();

        // Doctor Role
        $doctorRole = Roles::where('name', 'doctor')->first();

        // Doctors List
        $doctors = User::where('role_id', $doctorRole->id)->get();

        // Departments List
        $departments = Department::all();

        return response()->json([

            'status' => true,

            'message' => 'Edit Referral Data Fetched Successfully',

            'data' => [

                'referral' => $referral,

                'patients' => $patients,

                'doctors' => $doctors,

                'departments' => $departments,

            ]

        ], 200);
    }

    public function apiUpdate(Request $request, $id)
    {
        $request->validate([

            'referred_doctor_id' => 'required',

            'priority' => 'required',

            'referral_reason' => 'required',

            'status' => 'required',

        ]);

        $referral = Referral::findOrFail($id);

        $referral->update([

            'referred_doctor_id' => $request->referred_doctor_id,

            'referred_department_id' => $request->referred_department_id,

            'referral_type' => $request->referral_type,

            'priority' => $request->priority,

            'followup_date' => $request->followup_date,

            'referral_reason' => $request->referral_reason,

            'clinical_notes' => $request->clinical_notes,

            'status' => $request->status,

            'updated_by' => $request->doctor_id,

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Referral Updated Successfully',

            'data' => $referral

        ], 200);
    }

    public function apiDelete($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->delete();

        return response()->json([

            'status' => true,

            'message' => 'Referral Moved To Trash'

        ], 200);
    }

    public function apiUpdateStatus(Request $request, $id)
    {
        $request->validate([

            'status' => 'required'

        ]);

        $referral = Referral::findOrFail($id);

        $referral->update([

            'status' => $request->status,

            'updated_by' => $request->doctor_id,

        ]);

        return response()->json([

            'status' => true,

            'message' => 'Referral Status Updated',

            'data' => $referral

        ], 200);
    }

    public function apiMarkCompleted($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->status = 'Completed';

        $referral->save();

        return response()->json([

            'status' => true,

            'message' => 'Referral Marked as Completed',

            'data' => $referral

        ], 200);
    }

    public function apiReject($id)
    {
        $referral = Referral::findOrFail($id);

        $referral->status = 'Rejected';

        $referral->updated_by = request()->doctor_id;

        $referral->save();

        return response()->json([

            'success' => true,

            'message' => 'Referral Rejected Successfully',

            'data' => $referral

        ], 200);
    }

    public function apiTrash()
    {
        $referrals = Referral::onlyTrashed()
            ->with([
                'patient',
                'referredDoctor',
                'department'
            ])
            ->latest()
            ->paginate(10);

        return response()->json([

            'status' => true,

            'message' => 'Deleted Referrals List',

            'data' => $referrals

        ], 200);
    }

    public function apiRestore($id)
    {
        $referral = Referral::onlyTrashed()
            ->findOrFail($id);

        $referral->restore();

        return response()->json([

            'status' => true,

            'message' => 'Referral Restored Successfully'

        ], 200);
    }

    public function apiForceDelete($id)
    {
        $referral = Referral::onlyTrashed()
            ->findOrFail($id);

        $referral->forceDelete();

        return response()->json([

            'status' => true,

            'message' => 'Referral Permanently Deleted'

        ], 200);
    }
}