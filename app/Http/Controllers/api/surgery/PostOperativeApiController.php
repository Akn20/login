<?php

namespace App\Http\Controllers\Api\Surgery;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PostOperative;
use Illuminate\Support\Facades\Validator;

class PostOperativeApiController extends Controller
{

    /**
     * List all post operative records
     */
    public function index(Request $request)
    {
        try {

            $query = PostOperative::with(['surgery.patient', 'surgery.surgeon']);

            if ($request->has('surgery_id')) {
                $query->where('surgery_id', $request->surgery_id);
            }

            $posts = $query->latest()->get();

            return response()->json([
                'success' => true,
                'data' => $posts,
                'message' => 'Post operative records retrieved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve records',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store post operative record
     */
    public function store(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [

                'surgery_id' => 'required|exists:surgeries,id',
                'procedure_performed' => 'nullable|string',
                'duration' => 'nullable|string|max:255',
                'blood_loss' => 'nullable|string|max:255',
                'patient_condition' => 'nullable|string',
                'recovery_instructions' => 'nullable|string',
                'complication_type' => 'nullable|string|max:255',
                'complication_description' => 'nullable|string'

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            $post = PostOperative::updateOrCreate(

                ['surgery_id' => $request->surgery_id],

                [
                    'procedure_performed' => $request->procedure_performed,
                    'duration' => $request->duration,
                    'blood_loss' => $request->blood_loss,
                    'patient_condition' => $request->patient_condition,
                    'recovery_instructions' => $request->recovery_instructions,
                    'complication_type' => $request->complication_type,
                    'complication_description' => $request->complication_description
                ]

            );

            $post->load(['surgery.patient', 'surgery.surgeon']);

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post operative record saved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to save record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show single post operative record
     */
    public function show($id)
    {
        try {

            $post = PostOperative::with(['surgery.patient', 'surgery.surgeon'])
                ->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post operative record retrieved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Record not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Update post operative record
     */
    public function update(Request $request, $id)
    {
        try {

            $post = PostOperative::findOrFail($id);

            $validator = Validator::make($request->all(), [

                'procedure_performed' => 'nullable|string',
                'duration' => 'nullable|string|max:255',
                'blood_loss' => 'nullable|string|max:255',
                'patient_condition' => 'nullable|string',
                'recovery_instructions' => 'nullable|string',
                'complication_type' => 'nullable|string|max:255',
                'complication_description' => 'nullable|string'

            ]);

            if ($validator->fails()) {

                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors(),
                    'message' => 'Validation failed'
                ], 422);
            }

            $post->update([
                'procedure_performed' => $request->procedure_performed,
                'duration' => $request->duration,
                'blood_loss' => $request->blood_loss,
                'patient_condition' => $request->patient_condition,
                'recovery_instructions' => $request->recovery_instructions,
                'complication_type' => $request->complication_type,
                'complication_description' => $request->complication_description
            ]);

            $post->load(['surgery.patient', 'surgery.surgeon']);

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Post operative record updated successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to update record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete record
     */
    public function destroy($id)
    {
        try {

            $post = PostOperative::findOrFail($id);
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post operative record deleted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete record',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get record by surgery
     */
    public function getBySurgery($surgeryId)
    {
        try {

            $post = PostOperative::with(['surgery.patient', 'surgery.surgeon'])
                ->where('surgery_id', $surgeryId)
                ->first();

            if (!$post) {

                return response()->json([
                    'success' => false,
                    'message' => 'No post operative record found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $post,
                'message' => 'Record retrieved successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve record',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}