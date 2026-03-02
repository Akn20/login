<?php

namespace App\Http\Controllers;

use App\Models\UserBiometrics;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Log;

class BiometricController extends Controller
{

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
