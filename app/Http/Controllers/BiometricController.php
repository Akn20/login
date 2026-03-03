<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Geofence;
use App\Models\UserBiometrics;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Log;

class BiometricController extends Controller
{
    public function checkIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);

        $user = auth()->user();

        $already = Attendance::where('user_id', $user->id)
            ->where('date', Carbon::today())
            ->first();

        if ($already) {
            return response()->json([
                'message' => 'Already checked in today'
            ], 400);
        }

        $geofence = Geofence::where('status', true)->first();

        if (!$geofence) {
            return response()->json([
                'message' => 'Geofence not configured'
            ], 500);
        }

        $distance = $this->calculateDistance(
            $request->latitude,
            $request->longitude,
            $geofence->center_lat,
            $geofence->center_lng
        );

        if ($distance > $geofence->radius) {

            return response()->json([
                'message' => 'Outside hospital geofence'
            ], 403);
        }

        Attendance::create([
            'user_id' => $user->id,
            'date' => Carbon::today(),
            'checkin_time' => now(),
            'checkin_lat' => $request->latitude,
            'checkin_lng' => $request->longitude,
            'status' => 'present'
        ]);

        return response()->json([
            'message' => 'Check-in successful'
        ]);
    }

    public function checkOut(Request $request)
    {
        $user = auth()->user();

        $attendance = Attendance::where('user_id', $user->id)
            ->where('date', now()->toDateString())
            ->first();

        if (!$attendance) {
            return response()->json([
                'message' => 'No check-in found for today'
            ], 400);
        }

        if ($attendance->checkout_time) {
            return response()->json([
                'message' => 'Already checked out'
            ], 400);
        }

        $attendance->update([
            'checkout_time' => now()
        ]);

        return response()->json([
            'message' => 'Check-out successful'
        ]);
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000;

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

    public function enroll(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|image'
        ]);

        $response = Http::attach(
            'file',
            fopen($request->file('file')->getRealPath(), 'r'),
            $request->file('file')->getClientOriginalName()
        )->post('http://127.0.0.1:8099/enroll', [
                    'user_id' => $request->user_id
                ]);
        print ($response);
     

        $result = $response->json();

        if (!isset($result['status']) || $result['status'] !== 'success') {
            return response()->json([
                'message' => $result['message'] ?? 'Enrollment failed'
            ], 400);
        }

        $encryptedEmbedding = Crypt::encryptString(
            json_encode($result['embedding'])
        );

        UserBiometrics::updateOrCreate(
            ['user_id' => $request->user_id],
            [
                'face_embeddings' => $encryptedEmbedding,
            ]
        );

        return response()->json([
            'message' => 'Biometric enrolled successfully'
        ]);
    }

    public function match(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'file' => 'required|image'
        ]);

        $stored_embedding=UserBiometrics::where('user_id', $request->user_id)->first();
        $stored_embedding=$stored_embedding->face_embeddings;
        $stored_embedding=Crypt::decryptString($stored_embedding);

        $response = Http::attach(
            'file',
            fopen($request->file('file')->getRealPath(), 'r'),
            $request->file('file')->getClientOriginalName()
        )->post('http://127.0.0.1:8099/verify', [
                    'user_id' => $request->user_id,
                    'stored_embedding'=>$stored_embedding
                ]);

        $result = $response->json();

        if (!isset($result['status']) || $result['status'] !== 'success') {
            return response()->json([
                'message' => $result['message'] ?? 'Matching failed'
            ], 400);
        }

        return response()->json([
            'message' => 'Biometric matched successfully'
        ]);
    }
}
