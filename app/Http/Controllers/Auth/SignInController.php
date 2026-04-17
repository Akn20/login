<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\Roles;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;

class SignInController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'mpin' => 'required|digits_between:4,6',
        ], [
            'mobile.required' => 'Mobile number is required.',
            'mobile.digits' => 'Mobile number must be exactly 10 digits.',
            'mpin.required' => 'MPIN is required.',
            'mpin.digits_between' => 'MPIN must be 4 to 6 digits.',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            return back()->with('error', 'Invalid credentials. Please try again.');
        }

        if ($user->status !== 'active') {
            return back()->with('error', 'User is inactive.');
        }

        if ($user->locked_until && now()->lt($user->locked_until)) {
            return back()->with('error', 'Account temporarily locked. Please try again later.');
        }

        if (! Hash::check($request->mpin, $user->mpin)) {
            $user->increment('failed_attempts');

            if ($user->failed_attempts >= 5) {
                $user->update([
                    'locked_until' => now()->addMinutes(1),
                    'failed_attempts' => 0,
                ]);
            }

            return back()->with('error', 'Invalid Credentials. Please try again.');
        }

        $user->update(['failed_attempts' => 0]);

        Auth::login($user);
        $request->session()->regenerate();

        $roleName = $user->role?->name ? strtolower($user->role->name) : null;

        if ($roleName === 'admin') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login successful');
        }

        if ($roleName === 'hr' || $roleName === 'manager' || $roleName === 'hod') {
            return redirect()->route('hr.dashboard')
                ->with('success', 'Login successful');
        }

        if ($roleName === 'doctor') {
            return redirect()->route('admin.dashboard')
                ->with('success', 'Login successful');
        }

        return redirect()->route('login')
            ->with('error', 'No dashboard configured for this role');
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
        ]);

        $mobile = $request->mobile;

        Otp::where('mobile', $mobile)
            ->where(function ($query) {
                $query->where('used', 1)
                    ->orWhere('expires_at', '<', now());
            })
            ->forceDelete();

        $key = 'otp-send:'.$mobile;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->with('error', "Try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key, 60);

        $otpCode = rand(100000, 999999);
        $hashedOtp = Hash::make($otpCode);

        Otp::create([
            'mobile' => $mobile,
            'otp' => $hashedOtp,
            'expires_at' => now()->addMinutes(5),
            'attempts' => 0,
            'resends' => 0,
            'used' => 0,
            'last_sent_at' => now(),
        ]);

        session(['otp_mobile' => $mobile]);

        return redirect()->route('otp')
            ->with(['success' => 'OTP sent successfully', 'otp' => $otpCode]);
    }

    public function resendOtp()
    {
        $mobile = session('otp_mobile');

        if (! $mobile) {
            return redirect()->route('login')
                ->with('error', 'Session expired.');
        }

        $key = 'otp-resend:'.$mobile;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);

            return back()->with(
                'error',
                "Resend limit reached. Try again in {$seconds} seconds."
            );
        }

        RateLimiter::hit($key, 60);

        $otp = Otp::where('mobile', $mobile)
            ->where('used', 0)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        $otpCode = rand(100000, 999999);
        $hashedOtp = Hash::make($otpCode);

        if ($otp) {
            $otp->update([
                'otp' => $hashedOtp,
                'expires_at' => now()->addMinutes(5),
                'resends' => $otp->resends + 1,
                'last_sent_at' => now(),
            ]);
        }

        return back()->with(['success' => 'OTP resent successfully', 'otp' => $otpCode]);
    }

    public function verifyOtp(Request $request)
    {
        $mobile = session('otp_mobile');

        if (! $mobile) {
            return redirect()->route('login')
                ->with('error', 'Session expired.');
        }

        $verifyKey = 'otp-verify:'.$mobile;

        if (RateLimiter::tooManyAttempts($verifyKey, 3)) {
            $seconds = RateLimiter::availableIn($verifyKey);

            return back()->with('error',
                "Too many invalid attempts. Try again in {$seconds} seconds."
            );
        }

        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $otp = Otp::where('mobile', $mobile)
            ->where('used', 0)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (! $otp || ! Hash::check($request->otp, $otp->otp)) {
            RateLimiter::hit($verifyKey, 60);

            return back()->with('error',
                'Invalid OTP. Please try again.'
            );
        }

        $otp->update(['used' => 1]);

        RateLimiter::clear($verifyKey);

        return redirect()->route('set.mpin')
            ->with('success', 'OTP verified successfully');
    }

    public function setMpin(Request $request)
    {
        $mobile = session('otp_mobile');

        if (! $mobile) {
            return redirect()->route('login')->with('error', 'Session expired.');
        }

        $request->validate([
            'mpin' => 'required|digits_between:4,6',
        ]);

        $user = User::where('mobile', $mobile)->first();

        if (! $user) {
            return back()->with('error', 'User not found.');
        }

        $user->update([
            'mpin' => Hash::make($request->mpin),
        ]);

        session()->forget('otp_mobile');

        return redirect()->route('login')->with('success', 'MPIN set successfully. Please login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logged out successfully');
    }

    public function createDefaultAdmin()
    {
        if (User::where('mobile', '9999999999')->exists()) {
            return redirect()
                ->route('login', ['mobile' => '9999999999'])
                ->with('error', 'Admin already exists. You can login with 9999999999.');
        }

        try {
            $adminRole = Roles::firstOrCreate(
                ['name' => 'admin'],
                ['status' => 'active', 'description' => 'Super Administrator']
            );

            User::create([
                'name' => 'Super Admin',
                'mobile' => '9999999999',
                'mpin' => Hash::make('1234'),
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]);

            return redirect()
                ->route('login', ['mobile' => '9999999999'])
                ->with(
                    'success',
                    'Default admin created! Mobile: 9999999999 | MPIN: 1234'
                );
        } catch (\Exception $e) {
            return redirect()->route('login')->with(
                'error',
                'Failed to create admin. Please check database.'
            );
        }
    }


    /*.......................................................
                                APIs
    .......................................................*/
    
    public function apiLogin(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10',
            'mpin' => 'required|digits_between:4,6',
        ]);

        $user = User::where('mobile', $request->mobile)->first();

        if (! $user) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'message' => 'User is inactive',
            ], 403);
        }

        if ($user->locked_until && now()->lt($user->locked_until)) {
            return response()->json([
                'message' => 'Account temporarily locked. Please try again later.',
            ], 423);
        }

        if (! Hash::check($request->mpin, $user->mpin)) {
            $user->increment('failed_attempts');

            if ($user->failed_attempts >= 5) {
                $user->update([
                    'locked_until' => now()->addMinutes(1),
                    'failed_attempts' => 0,
                ]);
            }

            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        // reset failed attempts
        $user->update(['failed_attempts' => 0]);

        // create API token (Laravel Sanctum)
        $token = $user->createToken('mobile')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
                'role' => $user->role?->name,
                'is_enrolled' => $user->is_enrolled,
            ],
        ]);
    }


    
     public function apiSendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        $mobile = $request->mobile;
        Otp::where('mobile', $mobile)
        ->where(function ($query) {
            $query->where('used', 1)
                  ->orWhere('expires_at', '<', now());
        })
        ->forceDelete();
        $key = 'otp-send:' . $mobile;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json(['message' => "OTP send limit reached. Try again in {$seconds} seconds."], 429);
        }

        RateLimiter::hit($key, 60);

        $otpCode = rand(100000, 999999);
        $hashedOtp = Hash::make($otpCode);

            Otp::create([
                'mobile' => $mobile,
                'otp' => $hashedOtp,
                'expires_at' => now()->addMinutes(5),
                'attempts' => 0,
                'resends' => 0,
                'used' => 0,
                'last_sent_at' => now()
            ]);

        // session(['otp_mobile' => $mobile]);

        return response()->json([
            'message' => 'OTP sent successfully',
            'mobile' => $mobile,  // For testing, remove in production
            'otp' => $otpCode  // For testing, remove in production
        ]);
    }
    // Resend OTP with rate limiting
    public function apiResendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);
        $mobile = $request->mobile;
        // $mobile = session('otp_mobile');
        

        if (!$mobile) {
            return response()->json(['message' => 'No OTP session found'], 400);
        }

        $key = 'otp-resend:' . $mobile;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return response()->json(['message' => "Resend limit reached. Try again in {$seconds} seconds."], 429);
        }

        RateLimiter::hit($key, 60);
        $otp = Otp::where('mobile', $mobile)
            ->where('used', 0)
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        $otpCode = rand(100000, 999999);
        $hashedOtp = Hash::make($otpCode);
        if ($otp) {
            // Update existing
            $otp->update([
                'otp' => $hashedOtp,
                'expires_at' => now()->addMinutes(5),
                'resends' => $otp->resends + 1,
                'last_sent_at' => now()
            ]);
        }

        return response()->json([
            'message' => 'OTP resent successfully',
            'otp' => $otpCode  // For testing, remove in production
        ]);
    }

    // Verify OTP and mark as used
    public function apiVerifyOtp(Request $request)
{
    // $mobile = session('otp_mobile');
        $request->validate([
                'mobile' => 'required|digits:10',
                'otp' => 'required|digits:6'
            ]);
        $mobile = $request->mobile;

    if (!$mobile) {
        return response()->json(['message' => 'No OTP session found'], 400);
    }

    $verifyKey = 'otp-verify:' . $mobile;

    // 🔒 Check if already locked
    if (RateLimiter::tooManyAttempts($verifyKey, 3)) {
        $seconds = RateLimiter::availableIn($verifyKey);

        return response()->json(['message' => "Too many invalid attempts. Try again in {$seconds} seconds."], 429);
    }


    $otp = Otp::where('mobile', $mobile)
        ->where('used', 0)
        ->where('expires_at', '>', now())
        ->latest()
        ->first();

    if (!$otp || !Hash::check($request->otp, $otp->otp)) {

        // ❗ Count failed attempt
        RateLimiter::hit($verifyKey, 60);

        return response()->json(['message' => 'Invalid OTP'], 401);
    }

    $otp->update(['used' => 1]);

    RateLimiter::clear($verifyKey);

    return response()->json(['message' => 'OTP verified successfully', 'mobile' => $mobile]);
}

    // Set MPIN after OTP verification
    public function apiSetMpin(Request $request)
    {
        // $mobile = session('otp_mobile');
        $request->validate([
            'mobile' => 'required|digits:10',
            'mpin' => 'required|digits_between:4,6'
        ]);
        $mobile = $request->mobile;

        if (!$mobile) {
            return response()->json(['message' => 'No OTP session found'], 400);
        }

        $user = User::where('mobile', $request->mobile)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update([
            'mpin' => Hash::make($request->mpin)
        ]);

        // session()->forget('otp_mobile');

        return response()->json([
            'message' => 'MPIN set successfully'
        ]);
    }

    // Logout and revoke token
    public function apiLogout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
