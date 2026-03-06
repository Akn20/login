<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BiometricImage;
use App\Models\User;
use App\Models\UserBiometrics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminBiometricEnrollController extends Controller
{
    public function biometrics(Request $request)
    {
        $query = User::with(['biometricImages'])
            ->withCount(['biometricImages as biometric_images_count'])
            ->select('users.*');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        if ($status = $request->get('status')) {
            if ($status === 'not_enrolled') {
                $query->having('biometric_images_count', 0);
            } elseif ($status === 'partial') {
                $query->havingBetween('biometric_images_count', [1, 2]);
            } elseif ($status === 'completed') {
                $query->having('biometric_images_count', '>=', 3);
            }
        }

        // this will now work because biometric_images_count is in the select
        $users = $query
            // ->orderBy('biometric_images_count', 'asc')
            ->orderBy('name', 'asc')
            ->paginate(20);

        return view('admin.users.biometrics', compact('users'));
    }

    public function upload(Request $request, $userId)
    {
        $user = User::where('id', $userId)->firstOrFail();

        // Basic file validation per slot
        $validated = $request->validate([
            'slot_1' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slot_2' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'slot_3' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'slot_1.image' => 'Slot 1 must be an image file.',
            'slot_1.mimes' => 'Slot 1 must be a JPEG or PNG image.',
            'slot_1.max' => 'Slot 1 image may not be greater than 2MB.',

            'slot_2.image' => 'Slot 2 must be an image file.',
            'slot_2.mimes' => 'Slot 2 must be a JPEG or PNG image.',
            'slot_2.max' => 'Slot 2 image may not be greater than 2MB.',

            'slot_3.image' => 'Slot 3 must be an image file.',
            'slot_3.mimes' => 'Slot 3 must be a JPEG or PNG image.',
            'slot_3.max' => 'Slot 3 image may not be greater than 2MB.',
        ]);

        $imagesUploaded = false;

        foreach ([1, 2, 3] as $slot) {
            if ($request->hasFile("slot_{$slot}")) {
                $this->handleImageUpload($user, $slot, $request->file("slot_{$slot}"));
                $imagesUploaded = true;
            }
        }

        $user->touch('biometric_updated_at');

        if (! $imagesUploaded) {
            return back()
                ->withInput()
                ->withErrors(['biometrics' => 'Please upload at least one image before saving.']);
        }

        $freshUser = $user->fresh();

        if ($freshUser->biometricImages()->count() === 3 && ! $freshUser->is_enrolled) {
            $ok = $this->generateFaceEmbeddingsFromAdminImages($freshUser);

            if ($ok) {
                return back()->with('success', 'Biometric images uploaded and face embeddings generated successfully.');
            }

            return back()
                ->withInput()
                ->withErrors(['biometrics' => session('biometrics_error') ?? 'Image Uploaded, but Face Not Detected. Please try with clearer face images']);
        }

        return back()->with('success', 'Biometric images uploaded.');
    }

    private function generateFaceEmbeddingsFromAdminImages(User $user): bool
    {
        try {
            $images = $user->biometricImages()->orderBy('slot')->get();

            if ($images->count() < 1) {
                return false;
            }

            $embeddings = [];
            $errors = [];

            foreach ($images as $image) {
                $filePath = storage_path('app/public/'.$image->path);

                if (! file_exists($filePath)) {
                    Log::warning("Biometric image file not found for user {$user->id}: {$filePath}");
                    $errors[] = "Image for slot {$image->slot} is missing.";
                    continue;
                }

                // Reuse your existing enroll pattern: send file to Python
                $response = Http::attach(
                    'file',
                    fopen($filePath, 'r'),
                    basename($filePath)
                )->post('http://localhost:8099/enroll', [
                    'user_id' => $user->id,
                ]);

                $result = $response->json();

                if ($response->successful() && ($result['status'] ?? '') === 'success') {
                    $embeddings[] = $result['embedding']; // 128D array
                } else {
                    $msg = $result['message'] ?? 'Unknown error';
                    Log::warning("Admin enroll failed for user {$user->id} slot {$image->slot}: {$msg}", $result);
                    $errors[] = "Enrollment failed for image slot {$image->slot}: {$msg}";
                    Log::warning("Admin enroll failed for one image of user {$user->id}", $result ?? []);
                }
            }

            if (count($embeddings) === 0) {
                session()->flash('biometrics_error', implode(' | ', $errors) ?: 'No valid embeddings generated from uploaded images.');
                return false;
            }

            // Average embeddings for higher confidence
            $finalEmbedding = $embeddings[0];
            if (count($embeddings) > 1) {
                $dim = count($embeddings[0]);
                $sum = array_fill(0, $dim, 0.0);

                foreach ($embeddings as $vec) {
                    for ($i = 0; $i < $dim; $i++) {
                        $sum[$i] += $vec[$i];
                    }
                }

                for ($i = 0; $i < $dim; $i++) {
                    $sum[$i] /= count($embeddings);
                }

                $finalEmbedding = $sum;
            }

            $encryptedEmbedding = Crypt::encryptString(json_encode($finalEmbedding));

            UserBiometrics::updateOrCreate(
                ['user_id' => $user->id],
                ['face_embeddings' => $encryptedEmbedding]
            );

            $user->is_enrolled = true;
            $user->save();

            Log::info("Admin embeddings stored for user {$user->id}");

            return true;
        } catch (\Exception $e) {
            Log::error('Admin embedding generation error: '.$e->getMessage());

            return false;
        }
    }

    public function delete(Request $request, $imageId)
    {
        $image = BiometricImage::findOrFail($imageId);
        $user = $image->user;

        if ($image->path && Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
        }

        $image->delete();

        if ($user) {
            $user->touch('biometric_updated_at');

            // Less than 3 images → mark as not enrolled (forces admin to regenerate embeddings)
            if ($user->biometricImages()->count() < 3 && $user->is_enrolled) {
                $user->update(['is_enrolled' => false]);
                UserBiometrics::where('user_id', $user->id)->delete();
            }
        }

        return response()->json(['message' => 'Image removed successfully']);
    }

    private function handleImageUpload(User $user, int $slot, $file): void
    {
        $existing = BiometricImage::where('user_id', $user->id)
            ->where('slot', $slot)
            ->first();

        if ($existing && $existing->path) {
            Storage::disk('public')->delete($existing->path);
            $existing->delete();
        }

        $path = $file->store("biometrics/{$user->id}", 'public');

        BiometricImage::create([
            'user_id' => $user->id,
            'slot' => $slot,
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
