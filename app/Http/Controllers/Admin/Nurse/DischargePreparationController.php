<?php

namespace App\Http\Controllers\Admin\Nurse;
use App\Http\Controllers\Controller;
use App\Models\DischargePreparation;
use App\Models\Patient;
use App\Models\IPDAdmission;
use Illuminate\Http\Request;

class DischargePreparationController extends Controller
{
    
    // INDEX
    public function index()
    {
        $ipds = IPDAdmission::with(['patient','ward'])
            ->where('status', 'active')
            ->get();

        $discharges = DischargePreparation::all()->keyBy('ipd_admission_id');

        return view('admin.nurse.discharge.index', compact('ipds','discharges'));
    }

    // FORM
    public function form($ipd_id)
    {
        $ipd = IPDAdmission::with('patient')->findOrFail($ipd_id);

        if ($ipd->status !== 'active') {
            return back()->with('error', 'Patient not eligible');
        }

        $record = DischargePreparation::where('ipd_admission_id', $ipd_id)->first();

        return view('admin.nurse.discharge.form', compact('ipd','record'));
    }

    // SAVE
    public function save(Request $request)
    {
        $request->validate([
            'ipd_admission_id' => 'required'
        ]);

        $ipd = IPDAdmission::with('patient')->findOrFail($request->ipd_admission_id);

        DischargePreparation::updateOrCreate(
            ['ipd_admission_id' => $ipd->id],
            [
                'patient_id' => $ipd->patient_id,
                'ipd_admission_id' => $ipd->id,
                'hospital_id' => $ipd->patient->hospital_id,
                'nurse_id' => auth()->id(),
                'checklist' => $request->checklist ?? [],
                'belongings_status' => $request->belongings_status,
                'status' => 'in_progress'
            ]
        );
        return back()->with('success', 'Saved');
    }

    // MARK READY
    public function markReady($id)
    {
        $record = DischargePreparation::findOrFail($id);

        if (empty($record->checklist)) {
            return back()->with('error', 'Complete checklist');
        }

        $record->update([
            'status' => 'ready',
            'is_ready' => true,
            'prepared_at' => now()
        ]);
        return back()->with('success', 'Marked Ready');
    }

    // VIEW
    public function view($ipd_id)
    {
        $ipd = IPDAdmission::with('patient')->findOrFail($ipd_id);

        $record = DischargePreparation::where('ipd_admission_id', $ipd_id)->first();

        return view('admin.nurse.discharge.view', compact('ipd','record'));
    }

    //API METHODS

    public function apiIndex()
    {
        $ipds = IPDAdmission::with(['patient','ward'])
            ->where('status', 'active')
            ->get();

        $data = $ipds->map(function ($ipd) {

            $discharge = DischargePreparation::where('ipd_admission_id', $ipd->id)->first();

            return [
                'ipd_id' => $ipd->id,
                'admission_id' => $ipd->admission_id,

                'patient_name' =>
                    ($ipd->patient->first_name ?? '') . ' ' .
                    ($ipd->patient->last_name ?? ''),

                'ward' => $ipd->ward->ward_name ?? '-',

                'status' => $discharge->status ?? 'not_started'
            ];
        });

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function apiShow($ipd_id)
    {
        $ipd = IPDAdmission::with(['patient','ward'])->findOrFail($ipd_id);

        $record = DischargePreparation::where('ipd_admission_id', $ipd_id)->first();

        return response()->json([
            'status' => true,

            'data' => [
                'ipd_id' => $ipd->id,
                'admission_id' => $ipd->admission_id,

                'patient' => [
                    'name' =>
                        ($ipd->patient->first_name ?? '') . ' ' .
                        ($ipd->patient->last_name ?? ''),
                    'gender' => $ipd->patient->gender ?? null,
                    'mobile' => $ipd->patient->mobile ?? null,
                ],

                'ward' => $ipd->ward->ward_name ?? '-',

                'discharge' => [
                    'status' => $record->status ?? 'not_started',
                    'checklist' => $record->checklist ?? [],
                    'belongings_status' => $record->belongings_status ?? 0,
                    'prepared_at' => $record->prepared_at ?? null,
                ]
            ]
        ]);
    }

    public function apiSave(Request $request)
    {
        $request->validate([
            'ipd_admission_id' => 'required|exists:ipd_admissions,id',
            'nurse_id' => 'required'
        ]);

        $ipd = IPDAdmission::findOrFail($request->ipd_admission_id);

        $record = DischargePreparation::updateOrCreate(
            ['ipd_admission_id' => $ipd->id],
            [
                'patient_id' => $ipd->patient_id,
                'ipd_admission_id' => $ipd->id,
                'hospital_id' => $ipd->patient->hospital_id ?? null,
                'nurse_id' => $request->input('nurse_id'), 
                'checklist' => $request->checklist ?? [],
                'belongings_status' => $request->belongings_status ?? 0,
                'status' => 'in_progress'
            ]
        );

        return response()->json([
            'status' => true,
            'message' => 'Saved successfully'
        ]);
    }
    
    public function apiMarkReady($ipd_id)
    {
        $record = DischargePreparation::where('ipd_admission_id', $ipd_id)->firstOrFail();

        if (empty($record->checklist)) {
            return response()->json([
                'status' => false,
                'message' => 'Complete checklist first'
            ], 400);
        }

        $record->update([
            'status' => 'ready',
            'is_ready' => 1,
            'prepared_at' => now()
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Marked as Ready'
        ]);
    }
}
