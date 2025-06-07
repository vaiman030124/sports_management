<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Services\MailService;

class AuthController extends Controller
{
    protected $mailService;

    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'sport_played' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $name = $request->first_name . ' ' . $request->last_name;

        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'sport_played' => $request->sport_played,
            'level' => $request->level,
            'location' => $request->location,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Check for resend cooldown (1 minute)
        $lastOtp = \App\Models\PasswordOtp::where('email', $request->email)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(\Illuminate\Support\Carbon::now()) < 60) {
            return response()->json(['message' => 'Please wait before requesting a new OTP.'], 429);
        }

        // Expire previous pending OTPs
        \App\Models\PasswordOtp::where('email', $request->email)
            ->where('status', 'pending')
            ->update(['status' => 'expired']);

        $otp = random_int(100000, 999999);
        $now = \Illuminate\Support\Carbon::now();
        $expiresAt = $now->copy()->addMinutes(10);

        // Create new OTP record
        \App\Models\PasswordOtp::create([
            'email' => $request->email,
            'otp' => $otp,
            'created_at' => $now,
            'expires_at' => $expiresAt,
            'status' => 'pending',
        ]);

        // Send OTP email
        $this->mailService->sendEmailUsingTemplate(
            $request->email,
            'user-password-reset-otp',
            ['otp' => $otp]
        );

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = \App\Models\PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        if ($otpRecord->isExpired()) {
            $otpRecord->markExpired();
            return response()->json(['message' => 'OTP has expired. Please request a new one.'], 400);
        }

        $otpRecord->markVerified();

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|digits:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $otpRecord = \App\Models\PasswordOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('status', 'verified')
            ->orderBy('verified_at', 'desc')
            ->first();

        if (!$otpRecord) {
            return response()->json(['message' => 'Invalid or unverified OTP.'], 400);
        }

        if ($otpRecord->isExpired()) {
            $otpRecord->markExpired();
            return response()->json(['message' => 'OTP has expired. Please request a new one.'], 400);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $otpRecord->markExpired();

        return response()->json(['message' => 'Password has been reset successfully.']);
    }
}