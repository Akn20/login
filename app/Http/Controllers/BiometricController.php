<?php

namespace App\Http\Controllers;

use App\Models\UserBiometrics;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class BiometricController extends Controller
{

public function enroll(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'file' => 'required|image'
    ]);

    $response = Http::timeout(10)->attach(
        'file',
        file_get_contents($request->file('file')->getRealPath()),
        'face.jpg'
    )->post('http://127.0.0.1:6000/enroll', [
        'user_id' => $request->user_id
    ]);

    if (!$response->successful()) {
        return response()->json([
            'message' => 'Face service not reachable'
        ], 500);
    }

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
            'face_embedding' => $encryptedEmbedding,
        ]
    );

    return response()->json([
        'message' => 'Biometric enrolled successfully'
    ]);
}
}
