<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
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
            'student_id' => 'required|string|max:50|unique:users,student_id',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'status' => 'required|in:undergraduate,alumni',
            'sport' => 'required|string|max:50',
            'campus' => 'required|in:Tagum,Mabini',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // 2MB max
        ]);

        try {
            // Handle file upload
            $documentPath = null;
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $documentPath = $file->store('documents', 'public');
            }

            // Create user
            $user = User::create([
                'student_id' => $validated['student_id'],
                'full_name' => $validated['full_name'],
                'address' => 'Not provided',
                'email' => $validated['email'],
                'status' => $validated['status'],
                'sport' => $validated['sport'],
                'campus' => $validated['campus'],
                'document_path' => $documentPath,
                'password' => Hash::make('password123'), // Default password, will be changed on approval
                'role' => 'user',
                'approved' => false, // Requires admin approval
            ]);

            Log::info('New user registration', [
                'user_id' => $user->id,
                'email' => $user->email,
                'student_id' => $user->student_id
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
