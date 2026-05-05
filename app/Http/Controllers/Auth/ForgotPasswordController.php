<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\OTPMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /**
     * Show the forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('forgot-password');
    }

    /**
     * Send OTP to user's email.
     */
    public function sendOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
        ]);

        $email = $validated['email'];
        
        // Check if user exists
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No account found with this email address.'
            ]);
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in cache for 15 minutes
        Cache::put('password_reset_otp:' . $email, $otp, 900);
        Cache::put('password_reset_attempts:' . $email, 0, 900);
        Cache::put('password_reset_email:' . $email, $email, 900);

        try {
            // Send OTP via Laravel Mail
            Mail::to($email)->send(new OTPMail($otp));

            Log::info('Password reset OTP sent', ['email' => $email]);
            return response()->json([
                'status' => 'success',
                'message' => 'OTP sent successfully. Please check your email.'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send password reset OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send verification code. Please try again. ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Verify the OTP.
     */
    public function verifyOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $email = $validated['email'];
        $otp = $validated['otp'];

        // Get stored OTP
        $storedOtp = Cache::get('password_reset_otp:' . $email);
        
        if (!$storedOtp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Verification code has expired. Please request a new one.'
            ]);
        }

        // Check attempts
        $attempts = Cache::get('password_reset_attempts:' . $email, 0);
        if ($attempts >= 5) {
            Cache::forget('password_reset_otp:' . $email);
            Cache::forget('password_reset_attempts:' . $email);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Too many failed attempts. Please request a new code.'
            ]);
        }

        // Verify OTP
        if ($storedOtp !== $otp) {
            Cache::increment('password_reset_attempts:' . $email);
            
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification code. Please try again.'
            ]);
        }

        // Mark OTP as verified
        Cache::put('password_reset_verified:' . $email, true, 900);

        return response()->json([
            'status' => 'success',
            'message' => 'OTP verified successfully!'
        ]);
    }

    /**
     * Reset the password.
     */
    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $validated['email'];
        $otp = $validated['otp'];

        // Verify that OTP was verified
        $verified = Cache::get('password_reset_verified:' . $email);
        $storedOtp = Cache::get('password_reset_otp:' . $email);

        if (!$verified || $storedOtp !== $otp) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid or expired verification. Please start again.'
            ]);
        }

        try {
            // Update password
            $user = User::where('email', $email)->first();
            $user->password = Hash::make($validated['password']);
            $user->save();

            // Clear all cache entries
            Cache::forget('password_reset_otp:' . $email);
            Cache::forget('password_reset_attempts:' . $email);
            Cache::forget('password_reset_verified:' . $email);
            Cache::forget('password_reset_email:' . $email);

            Log::info('Password reset successful', ['email' => $email]);

            return response()->json([
                'status' => 'success',
                'message' => 'Password reset successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Password reset failed', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to reset password. Please try again.'
            ]);
        }
    }
}
