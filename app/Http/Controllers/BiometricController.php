<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Geofence;
use App\Models\User;
use App\Models\UserBiometrics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BiometricController extends Controller
{
    // ENORLL USER BIOMETRICS
    public function enroll(Request $request)
    {
        $admin = auth('sanctum')->user();

        if (!$admin) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated'
            ], 401);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|image'
        ]);

        try {

            // Target user to enroll
            $user = User::findOrFail($request->user_id);

            if ($user->is_enrolled) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'User already enrolled'
                ], 400);
            }

            $file = $request->file('file');

            // Send to Python AI service
            $response = Http::attach(
                'file',
                fopen($file->getRealPath(), 'r'),
                $file->getClientOriginalName()
            )->post('http://localhost:8099/enroll', [
                        'user_id' => $user->id
                    ]);

            $result = $response->json();

            if ($response->successful() && ($result['status'] ?? '') === 'success') {

                // Encrypt embedding
                $encryptedEmbedding = Crypt::encryptString(
                    json_encode($result['embedding'])
                );

                UserBiometrics::updateOrCreate(
                    ['user_id' => $user->id],
                    ['face_embeddings' => $encryptedEmbedding]
                );

                // Mark user enrolled
                $user->is_enrolled = true;
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Biometric enrolled successfully'
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => $result['message'] ?? 'Face not detected. Try again with better lighting.'
            ], 400);

        } catch (\Exception $e) {

            Log::error('Enrollment Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Internal Server Error during enrollment'
            ], 500);
        }
    }

    // CHECK IN USER
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'file' => 'required|image', // Base64 Image for verification
        ]);

        $user = auth()->user();

        // 1. Prevent Double Check-in
        $already = Attendance::where('user_id', $user->id)
            ->where('date', Carbon::today())
            ->first();

        if ($already) {
            return response()->json(['message' => 'Already checked in today'], 400);
        }

        // 2. Geofence Check

        $geoCheck = $this->isInsideGeofence($request->latitude, $request->longitude);
        if (!$geoCheck['status']) {
            return response()->json([
                'message' => 'Outside hospital area'
            ], 403);
        }

        // 3. Biometric Verification
        $biometricData = UserBiometrics::where('user_id', $user->id)->first();
        if (!$biometricData) {
            return response()->json(['message' => 'Biometrics not found. Please enroll first.'], 404);
        }

        try {
            $start = microtime(true);
            $storedEmbedding = Crypt::decryptString($biometricData->face_embeddings);

            $bioResult = $this->verifyFace($user->id, $storedEmbedding, $request->file('file'));

            if (($bioResult['status']) !== 'success') {
                return response()->json([
                    'status' => 'error',
                    'message' => $bioResult['message'],
                    'error' => $bioResult['message'] ?? 'Mismatch',
                ], 401);
            }

            // 4. Create Attendance Record
            if ($bioResult['status'] == 'success') {
                Attendance::create([
                    'user_id' => $user->id,
                    'date' => Carbon::today(),
                    'checkin_time' => now(),
                    'checkin_lat' => $request->latitude,
                    'checkin_lng' => $request->longitude,
                    'status' => 'present',
                ]);

                return response()->json(['status' => 'success', 'message' => 'Check-in successful']);
            }

        } catch (\Exception $e) {
            Log::error('Check-in Error: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Server error during verification'], 500);
        }
    }

    // CHECK OUT USER
    public function checkOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'file' => 'required|image', // Base64 Image for verification
        ]);

        $user = auth()->user();
        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', Carbon::today())
            ->first();

        if (!$attendance) {
            return response()->json(['status' => 'error', 'message' => 'No check-in found for today'], 400);
        }
        if ($attendance->checkout_time) {
            return response()->json(['status' => 'error', 'message' => 'Already checked out'], 400);
        }

        // 2. Geofence Check
        $geoCheck = $this->isInsideGeofence($request->latitude, $request->longitude);
        if (!$geoCheck['status']) {
            return response()->json([
                'message' => 'Outside hospital area'
            ], 403);
        }
        // 3. Biometric Verification
        $biometricData = UserBiometrics::where('user_id', $user->id)->first();
        if (!$biometricData) {
            return response()->json(['status' => 'error', 'message' => 'Biometrics not found. Please enroll first.'], 404);
        }

        try {
            $storedEmbedding = Crypt::decryptString($biometricData->face_embeddings);
            $fileResource = $request->file('file');

            $bioResult = $this->verifyFace($user->id, $storedEmbedding, $fileResource);

            Log::info($bioResult);

            if (($bioResult['status']) !== 'success') {
                return response()->json([
                    'status' => 'error',
                    'message' => $bioResult['message'],
                    'error' => $bioResult['message'] ?? 'Mismatch',
                ], 401);
            }

            if (($bioResult['status']) === 'success') {
                $attendance->update(['checkout_time' => now()]);
            }

            return response()->json(['status' => 'success', 'message' => 'Check-out successful']);
        } catch (\Exception $e) {
            Log::error('Check-in Error: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Server error during verification'], 500);
        }
    }

    // CHECK IF USER IS CHECKED IN
    public function checkstatus(Request $request)
    {
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->first();

        if (!$attendance || $attendance->checkin_time === null) {
            return response()->json(['status' => 'check-in']);
        }

        if ($attendance->checkout_time === null) {
            return response()->json(['status' => 'check-out']);
        }

        return response()->json(['status' => 'completed']);

    }

    // CALUCULATE DISTANCE
    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(
            pow(sin($latDelta / 2), 2) +
            cos($latFrom) * cos($latTo) *
            pow(sin($lonDelta / 2), 2)
        ));

        return $angle * $earthRadius;
    }

    // VERIFY FACE
    public function verifyFace($user_id, $storedEmbedding, $file)
    {
        $response = Http::attach(
            'file',
            fopen($file->getRealPath(), 'r'),
            $file->getClientOriginalName()
        )
            ->post('http://localhost:8099/verify', [
                'user_id' => $user_id,
                'stored_embedding' => $storedEmbedding,
            ]);

        return $response->json();
    }

    private function isInsideGeofence($latitude, $longitude)
    {
        //Geofence should be fetch using the institution id from the user
        $geofences = Geofence::where('status', true)
            ->get();

        if ($geofences->isEmpty()) {
            return [
                'status' => false,
                'message' => 'No active geofence configured'
            ];
        }

        foreach ($geofences as $geofence) {

            $distance = $this->calculateDistance(
                $latitude,
                $longitude,
                $geofence->center_lat,
                $geofence->center_lng
            );

            Log::info('Checking geofence ' . $geofence->id . ' distance: ' . $distance);

            if ($distance <= $geofence->radius) {
                return [
                    'status' => true,
                    'geofence' => $geofence
                ];
            }
        }

        return [
            'status' => false,
            'message' => 'Outside allowed geofence area'
        ];
    }
}
