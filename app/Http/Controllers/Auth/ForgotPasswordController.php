<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
            // Send OTP via PHPMailer
            $emailSent = $this->sendOTPEmail($email, $otp);

            if ($emailSent) {
                Log::info('Password reset OTP sent', ['email' => $email]);
                return response()->json([
                    'status' => 'success',
                    'message' => 'OTP sent successfully. Please check your email.'
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to send OTP email. Please try again.'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send password reset OTP', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send verification code. Please try again.'
            ]);
        }
    }

    /**
     * Send OTP email using PHPMailer.
     */
    private function sendOTPEmail($email, $otp)
    {
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tagummabinisportoffice@gmail.com';
            $mail->Password = 'wecx ezju zcin ymmn';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->Timeout = 60;

            // Recipients
            $mail->setFrom('tagummabinisportoffice@gmail.com', 'USeP OSAS Sports Unit');
            $mail->addAddress($email);
            $mail->addReplyTo('tagummabinisportoffice@gmail.com', 'USeP OSAS Sports Unit');

            // Content with maroon/gold design matching login page
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset OTP - USeP OSAS Sports Unit';
            $mail->Body = "
                <!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <link href='https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap' rel='stylesheet'>
                    <style>
                        * { margin: 0; padding: 0; box-sizing: border-box; }
                        body {
                            font-family: 'Barlow', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
                            background: #F5F3EE;
                            color: #3D2A2F;
                            line-height: 1.6;
                        }
                        .container {
                            max-width: 600px;
                            margin: 40px auto;
                            background: #FFFFFF;
                            overflow: hidden;
                            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
                            clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%);
                        }
                        .header {
                            background: #7A1428;
                            padding: 32px 40px;
                            position: relative;
                            overflow: hidden;
                        }
                        .header::before {
                            content: '';
                            position: absolute;
                            top: 0;
                            left: 0;
                            right: 0;
                            height: 5px;
                            background: linear-gradient(90deg, #F0B429 0%, #C48F10 60%, transparent 100%);
                        }
                        .header h2 {
                            font-family: 'Barlow Condensed', sans-serif;
                            font-size: 24px;
                            font-weight: 800;
                            color: #FFFFFF;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                            margin: 0;
                            text-align: center;
                        }
                        .content {
                            padding: 40px;
                        }
                        .content h3 {
                            font-family: 'Barlow Condensed', sans-serif;
                            font-size: 18px;
                            font-weight: 700;
                            color: #7A1428;
                            margin-bottom: 16px;
                            text-transform: uppercase;
                        }
                        .content p {
                            font-size: 15px;
                            color: #3D2A2F;
                            margin-bottom: 16px;
                            line-height: 1.7;
                        }
                        .otp-box {
                            background: #F5F3EE;
                            border-left: 4px solid #F0B429;
                            padding: 24px;
                            margin: 24px 0;
                            text-align: center;
                        }
                        .otp-code {
                            font-family: 'Barlow Condensed', sans-serif;
                            font-size: 32px;
                            font-weight: 800;
                            color: #7A1428;
                            letter-spacing: 8px;
                            margin: 0;
                        }
                        .footer {
                            background: #F5F3EE;
                            padding: 24px 40px;
                            text-align: center;
                        }
                        .footer p {
                            font-size: 13px;
                            color: #7A5C64;
                            margin: 0;
                        }
                        @media (max-width: 600px) {
                            .container { margin: 20px; }
                            .content { padding: 24px; }
                            .header { padding: 24px; }
                            .header h2 { font-size: 18px; }
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>USeP OSAS-Sports Unit</h2>
                        </div>
                        <div class='content'>
                            <h3>Password Reset Request</h3>
                            <p>You have requested to reset your password. Please use the following OTP code to verify your identity:</p>
                            <div class='otp-box'>
                                <p class='otp-code'>{$otp}</p>
                            </div>
                            <p>This code will expire in 15 minutes. If you did not request this password reset, please ignore this email.</p>
                        </div>
                        <div class='footer'>
                            <p>&copy; " . date('Y') . " USeP OSAS-Sports Unit. All rights reserved.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";
            $mail->AltBody = "Your password reset OTP is: {$otp}. This code will expire in 15 minutes.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            Log::error('PHPMailer Error: ' . $mail->ErrorInfo);
            return false;
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
