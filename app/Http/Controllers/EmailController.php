<?php

namespace App\Http\Controllers;

use App\Mail\ApprovalMail;
use App\Mail\RejectionMail;
use App\Mail\NotificationMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailController extends Controller
{
    /**
     * Send approval email to user
     */
    public function sendApprovalEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string|max:255',
            'student_id' => 'required|string|max:50',
        ]);

        $email = $validated['email'];
        $fullName = $validated['full_name'];
        $studentId = $validated['student_id'];

        try {
            Mail::to($email)->send(new ApprovalMail($fullName, $studentId, $email));
            
            Log::info('Approval email sent', [
                'email' => $email,
                'full_name' => $fullName,
                'student_id' => $studentId
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Approval email sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send approval email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send approval email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send rejection email to user
     */
    public function sendRejectionEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string|max:255',
        ]);

        $email = $validated['email'];
        $fullName = $validated['full_name'];

        try {
            Mail::to($email)->send(new RejectionMail($fullName));
            
            Log::info('Rejection email sent', [
                'email' => $email,
                'full_name' => $fullName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Rejection email sent successfully'
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send rejection email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send notification email to user
     */
    public function sendNotificationEmail(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'full_name' => 'required|string|max:255',
            'notifications' => 'required|array',
            'notifications.*.message' => 'required|string',
            'notifications.*.timestamp' => 'required|date',
            'notifications.*.is_read' => 'required|boolean',
        ]);

        $email = $validated['email'];
        $fullName = $validated['full_name'];
        $notifications = $validated['notifications'];

        // Check if there are any unread notifications
        $unreadNotifications = array_filter($notifications, function($n) {
            return !$n['is_read'];
        });

        if (empty($unreadNotifications)) {
            return response()->json([
                'success' => false,
                'message' => 'No unread notifications to send'
            ]);
        }

        try {
            Mail::to($email)->send(new NotificationMail($fullName, $notifications));
            
            Log::info('Notification email sent', [
                'email' => $email,
                'full_name' => $fullName,
                'unread_count' => count($unreadNotifications)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification email sent successfully',
                'unread_count' => count($unreadNotifications)
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send notification email', [
                'email' => $email,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send notification email: ' . $e->getMessage()
            ], 500);
        }
    }
}
