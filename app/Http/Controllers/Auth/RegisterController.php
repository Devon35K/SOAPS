<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AccountApproval;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        return view('register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'student_id' => [
                'required', 'string', 'max:50',
                'unique:users,student_id',
                'unique:account_approvals,student_id'
            ],
            'full_name' => 'required|string|max:255',
            'email' => [
                'required', 'email', 'max:255',
                'unique:users,email',
                'unique:account_approvals,email'
            ],
            'status' => 'required|in:undergraduate,alumni',
            'sport' => 'required|string|max:50',
            'campus' => 'required|in:Tagum,Mabini',
            'password' => 'required|string|min:8|confirmed',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120', // Increased to 5MB
        ], [
            'student_id.unique' => 'This Student ID is already registered or has a pending approval request.',
            'email.unique' => 'This email address is already registered or has a pending approval request.'
        ]);

        try {
            // Handle file upload - store as Base64 for AccountApproval and also keep on disk
            $file = $request->file('document');
            $fileData = base64_encode(file_get_contents($file->getRealPath()));
            $documentPath = $file->store('documents', 'public');

            // Create Account Approval request
            $approval = AccountApproval::create([
                'student_id' => $validated['student_id'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'status' => $validated['status'],
                'sport' => $validated['sport'],
                'campus' => $validated['campus'],
                'password' => Hash::make($validated['password']),
                'file_name' => $file->getClientOriginalName(),
                'file_data' => $fileData,
                'file_type' => $file->getMimeType(),
                'file_size' => $file->getSize(),
                'approval_status' => 'pending',
                'request_date' => now(),
            ]);

            Log::info('New account approval request', [
                'approval_id' => $approval->id,
                'email' => $approval->email,
                'student_id' => $approval->student_id
            ]);

            return redirect()->route('register', ['status' => 'success'])
                ->with('message', 'Your account has been submitted for approval. You will be notified once approved.');

        } catch (\Exception $e) {
            Log::error('Registration error', [
                'error' => $e->getMessage(),
                'request_data' => $request->except(['document'])
            ]);

            return redirect()->route('register')
                ->with('error', 'Registration failed. Please try again.')
                ->withInput();
        }
    }
}
