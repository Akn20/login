<?php

namespace App\Http\Controllers\Admin\Nurse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MedicationAdministration;

class MedicationAdministrationController extends Controller
{

    // 🔷 INDEX (Load page + medications)
    public function index(Request $request)
    {
        $patients = DB::table('patients')->whereNull('deleted_at')->get();

        $medications = [];

        if ($request->patient_id) {

            $patient = DB::table('patients')
                ->where('id', $request->patient_id)
                ->first();

            if ($patient) {

                $fullName = trim($patient->first_name . ' ' . $patient->last_name);

                $medications = DB::table('offline_prescription_items as items')
                    ->join('offline_prescriptions as p', 'items.offline_prescription_id', '=', 'p.id')

                    ->leftJoin('medication_administration as m', function ($join) {
                        $join->on('items.id', '=', 'm.prescription_item_id')
                            ->whereNull('m.deleted_at');
                    })

                    ->where('p.patient_name', $fullName)

                    ->select(
                        'items.*',
                        'm.status',
                        'm.administered_time'
                    )
                    ->get();
            }
        }

        return view('admin.nurse.medicationAdministration.index', compact('patients', 'medications'));
    }


    // 🔷 ADMINISTER MEDICATION
    public function administer(Request $request)
    {
        $request->validate([
            'prescription_item_id' => 'required'
        ]);

        $existing = MedicationAdministration::where('prescription_item_id', $request->prescription_item_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existing && $existing->status == 'administered') {
            return back()->with('error', 'Already administered');
        }

        // 🔹 Get patient_name
        $patientName = DB::table('offline_prescription_items')
            ->join('offline_prescriptions', 'offline_prescription_items.offline_prescription_id', '=', 'offline_prescriptions.id')
            ->where('offline_prescription_items.id', $request->prescription_item_id)
            ->value('offline_prescriptions.patient_name');

        // 🔹 Convert to patient_id
        $patient = DB::table('patients')
            ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), $patientName)
            ->first();

        MedicationAdministration::updateOrCreate(
            [
                'prescription_item_id' => $request->prescription_item_id
            ],
            [
                'patient_id' => $patient ? $patient->id : null,
                'nurse_id' => 1, // ✅ store staff.id here
                'administered_time' => now(),
                'status' => 'administered'
            ]
        );

        return back()->with('success', 'Medication administered successfully');
    }


    // 🔷 MARK AS MISSED
    public function markMissed(Request $request)
    {
        $request->validate([
            'prescription_item_id' => 'required'
        ]);

        $existing = MedicationAdministration::where('prescription_item_id', $request->prescription_item_id)
            ->whereNull('deleted_at')
            ->first();

        if ($existing && $existing->status == 'administered') {
            return back()->with('error', 'Already administered, cannot mark missed');
        }

        // 🔹 Get patient_name
        $patientName = DB::table('offline_prescription_items')
            ->join('offline_prescriptions', 'offline_prescription_items.offline_prescription_id', '=', 'offline_prescriptions.id')
            ->where('offline_prescription_items.id', $request->prescription_item_id)
            ->value('offline_prescriptions.patient_name');

        // 🔹 Convert to patient_id
        $patient = DB::table('patients')
            ->where(DB::raw("CONCAT(first_name, ' ', last_name)"), $patientName)
            ->first();

        MedicationAdministration::updateOrCreate(
            [
                'prescription_item_id' => $request->prescription_item_id
            ],
            [
                'patient_id' => $patient ? $patient->id : null,
                'nurse_id' => 1, // ✅ store staff.id here
                'status' => 'missed'
            ]
        );

        return back()->with('success', 'Medication marked as missed');
    }
}