<?php

namespace App\Http\Controllers\api\surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Surgery;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\PreOperative;
use App\Models\PostOperative;
use App\Models\OTManagement;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class SurgeryApiController extends Controller
{
    /**
     * Display a listing of surgeries
     */
    public function index(Request $request)
    {
        try {
            $query = Surgery::with(['patient', 'surgeon', 'assistantDoctor', 'anesthetist']);

            // Filter by date if provided
            if ($request->has('date')) {
                $query->whereDate('surgery_date', $request->date);
            }

            // Filter by patient if provided
            if ($request->has('patient_id')) {
                $query->where('patient_id', $request->patient_id);
            }

            // Filter by surgeon if provided
            if ($request->has('surgeon_id')) {
                $query->where('surgeon_id', $request->surgeon_id);
            }

            // Filter by priority if provided
            if ($request->has('priority')) {
                $query->where('priority', $request->priority);
            }

            $surgeries = $query->latest()->get();

            // Add additional info for each surgery
            $surgeries->transform(function ($surgery) {
                $surgery->has_postoperative = PostOperative::where('surgery_id', $surgery->id)->exists();
                $surgery->has_ot_record = OTManagement::where('surgery_id', $surgery->id)->exists();
                $surgery->preoperative = PreOperative::where('surgery_id', $surgery->id)->first();
                return $surgery;
            });

            return response()->json([
                'success' => true,
                'data' => $surgeries,
                'message' => 'Surgeries retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve surgeries',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created surgery
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'patient_id' => 'required|exists:patients,id',
                'surgery_type' => 'required|string|max:255',
                'surgery_date' => 'required|date',
                'surgery_time' => 'required',
                'ot_room' => 'nullable|string|max:255',
                'surgeon_id' => 'nullable|exists:staff,id',
                'assistant_doctor_id' => 'nullable|exists:staff,id',
                'anesthetist_id' => 'nullable|exists:staff,id',
                'priority' => 'required|in:Normal,Emergency',
                'notes' => 'nullable|string',
                // Pre-operative fields
                'bp' => 'nullable|string|max:255',
                'heart_rate' => 'nullable|string|max:255',
                'fasting_status' => 'nullable|string|max:255',
                'allergies' => 'nullable|string',
                'consent_obtained' => 'nullable|boolean',
                'instructions' => 'nullable|string',
                'risk_factors' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Create surgery
            $surgery = Surgery::create([
                'id' => Str::uuid(),
                'patient_id' => $request->patient_id,
                'surgery_type' => $request->surgery_type,
                'surgery_date' => $request->surgery_date,
                'surgery_time' => $request->surgery_time,
                'ot_room' => $request->ot_room,
                'surgeon_id' => $request->surgeon_id,
                'assistant_doctor_id' => $request->assistant_doctor_id,
                'anesthetist_id' => $request->anesthetist_id,
                'priority' => $request->priority,
                'notes' => $request->notes
            ]);

            // Create pre-operative record if data provided
            if ($request->hasAny(['bp', 'heart_rate', 'fasting_status', 'allergies', 'consent_obtained', 'instructions', 'risk_factors'])) {
                PreOperative::create([
                    'surgery_id' => $surgery->id,
                    'bp' => $request->bp,
                    'heart_rate' => $request->heart_rate,
                    'fasting_status' => $request->fasting_status,
                    'allergies' => $request->allergies,
                    'consent_obtained' => $request->consent_obtained,
                    'instructions' => $request->instructions,
                    'risk_factors' => $request->risk_factors
                ]);
            }

            // Load relationships for response
            $surgery->load(['patient', 'surgeon', 'assistantDoctor', 'anesthetist']);

            return response()->json([
                'success' => true,
                'data' => $surgery,
                'message' => 'Surgery scheduled successfully'
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to schedule surgery',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified surgery
     */
    public function show($id)
    {
        try {
            $surgery = Surgery::with(['patient', 'surgeon', 'assistantDoctor', 'anesthetist'])->findOrFail($id);

            // Add additional info
            $surgery->has_postoperative = PostOperative::where('surgery_id', $surgery->id)->exists();
            $surgery->has_ot_record = OTManagement::where('surgery_id', $surgery->id)->exists();
            $surgery->preoperative = PreOperative::where('surgery_id', $surgery->id)->first();
            $surgery->postoperative = PostOperative::where('surgery_id', $surgery->id)->first();
            $surgery->ot_record = OTManagement::where('surgery_id', $surgery->id)->first();

            return response()->json([
                'success' => true,
                'data' => $surgery,
                'message' => 'Surgery retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Surgery not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update the specified surgery
     */
    public function update(Request $request, $id)
    {
        try {
            $surgery = Surgery::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'patient_id' => 'sometimes|exists:patients,id',
                'surgery_type' => 'sometimes|string|max:255',
                'surgery_date' => 'sometimes|date',
                'surgery_time' => 'sometimes',
                'ot_room' => 'nullable|string|max:255',
                'surgeon_id' => 'nullable|exists:staff,id',
                'assistant_doctor_id' => 'nullable|exists:staff,id',
                'anesthetist_id' => 'nullable|exists:staff,id',
                'priority' => 'sometimes|in:Normal,Emergency',
                'notes' => 'nullable|string',
                // Pre-operative fields
                'bp' => 'nullable|string|max:255',
                'heart_rate' => 'nullable|string|max:255',
                'fasting_status' => 'nullable|string|max:255',
                'allergies' => 'nullable|string',
                'consent_obtained' => 'nullable|boolean',
                'instructions' => 'nullable|string',
                'risk_factors' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Update surgery
            $surgery->update($request->only([
                'patient_id', 'surgery_type', 'surgery_date', 'surgery_time',
                'ot_room', 'surgeon_id', 'assistant_doctor_id', 'anesthetist_id',
                'priority', 'notes'
            ]));

            // Update or create pre-operative record
            PreOperative::updateOrCreate(
                ['surgery_id' => $id],
                $request->only([
                    'bp', 'heart_rate', 'fasting_status', 'allergies',
                    'consent_obtained', 'instructions', 'risk_factors'
                ])
            );

            // Load relationships for response
            $surgery->load(['patient', 'surgeon', 'assistantDoctor', 'anesthetist']);

            return response()->json([
                'success' => true,
                'data' => $surgery,
                'message' => 'Surgery updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update surgery',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified surgery
     */
    public function destroy($id)
    {
        try {
            $surgery = Surgery::findOrFail($id);

            // Delete related records
            PreOperative::where('surgery_id', $id)->delete();
            PostOperative::where('surgery_id', $id)->delete();
            OTManagement::where('surgery_id', $id)->delete();

            // Delete surgery
            $surgery->delete();

            return response()->json([
                'success' => true,
                'message' => 'Surgery deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete surgery',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get surgeries for a specific patient
     */
    public function getByPatient($patientId)
    {
        try {
            $surgeries = Surgery::with(['patient', 'surgeon'])
                ->where('patient_id', $patientId)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $surgeries,
                'message' => 'Patient surgeries retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve patient surgeries',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get surgeries for a specific date
     */
    public function getByDate($date)
    {
        try {
            $surgeries = Surgery::with(['patient', 'surgeon'])
                ->whereDate('surgery_date', $date)
                ->latest()
                ->get();

            return response()->json([
                'success' => true,
                'data' => $surgeries,
                'message' => 'Surgeries for date retrieved successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve surgeries for date',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}