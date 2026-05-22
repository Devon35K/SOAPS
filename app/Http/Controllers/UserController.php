<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function dashboard()
    {
        return view('user.dashboard');
    }

    public function submissions()
    {
        $submissions = \App\Models\Submission::where('user_id', Auth::id())
            ->orderBy('submission_date', 'desc')
            ->get();

        return view('user.submissions', compact('submissions'));
    }

    /**
     * Store a new document submission.
     */
    public function storeSubmission(Request $request)
    {
        $request->validate([
            'document_type' => 'required|string',
            'notes' => 'nullable|string|max:500',
            'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ], [
            'document.required' => 'Please select a document to upload.',
            'document.file' => 'The uploaded item must be a valid file.',
            'document.mimes' => 'Invalid file format. Only PDF, JPG, JPEG, and PNG files are supported.',
            'document.max' => 'The uploaded file exceeds the 5 MB limit. Please select a smaller file.',
            'document_type.required' => 'Please select a document type.',
        ]);

        try {
            $user = Auth::user();
            $file = $request->file('document');
            $fileData = base64_encode(file_get_contents($file->getRealPath()));

            \App\Models\Submission::create([
                'user_id' => $user->id,
                'full_name' => $user->full_name,
                'year_section' => $user->year_section ?? 'N/A',
                'contact_email' => $user->email,
                'document_type' => $request->document_type,
                'description' => $request->notes ?? 'No description provided',
                'file_name' => $file->getClientOriginalName(),
                'file_data' => $fileData,
                'file_size' => $file->getSize(),
                'status' => 'pending',
                'submission_date' => now(),
            ]);

            return redirect()->route('user.submissions')->with('success', 'Document submitted successfully!');
        } catch (\Exception $e) {
            // Log raw system exception for developer diagnostics
            \Illuminate\Support\Facades\Log::error('Submission storage failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'exception' => $e
            ]);

            return redirect()->route('user.submissions')->with('error', 'Failed to submit document: An unexpected error occurred while saving your file to the database. Please ensure it is less than 5 MB and try again.');
        }
    }

    /**
     * Display the student achievements page.
     */
    public function achievements()
    {
        $userId = auth()->id();
        
        // Fetch real points from leaderboard
        $totalPoints = \App\Models\Leaderboard::where('user_id', $userId)->value('total_points') ?? 0;
        
        // Calculate Campus Rank
        $allRankings = \App\Models\Leaderboard::orderBy('total_points', 'desc')->pluck('user_id')->toArray();
        $rank = array_search($userId, $allRankings);
        $rank = ($rank !== false) ? $rank + 1 : 'N/A';
        
        // Fetch approved achievements
        $achievements = \App\Models\Achievement::where('user_id', $userId)
            ->where('status', 'Approved')
            ->orderBy('submission_date', 'desc')
            ->get();

        return view('user.achievements', compact('totalPoints', 'rank', 'achievements'));
    }

    /**
     * Display the student leaderboard page.
     */
    public function leaderboard()
    {
        $userId = auth()->id();
        
        // Fetch real points from leaderboard
        $totalPoints = \App\Models\Leaderboard::where('user_id', $userId)->value('total_points') ?? 0;
        
        // Calculate all rankings once to compute ranks efficiently
        $allRankings = \App\Models\Leaderboard::orderBy('total_points', 'desc')->pluck('user_id')->toArray();
        $rank = array_search($userId, $allRankings);
        $rank = ($rank !== false) ? $rank + 1 : 'N/A';
        
        // Fetch top 100 for leaderboard
        $leaderboardEntries = \App\Models\Leaderboard::with('user')
            ->orderBy('total_points', 'desc')
            ->take(100)
            ->get();

        // Check if the current user is in the top 100
        $userInTop100 = $leaderboardEntries->contains('user_id', $userId);
        
        $currentUserEntry = null;
        if (!$userInTop100) {
            $currentUserEntry = \App\Models\Leaderboard::with('user')->where('user_id', $userId)->first();
        }

        return view('user.leaderboard', compact(
            'totalPoints', 
            'rank', 
            'leaderboardEntries', 
            'userInTop100', 
            'currentUserEntry',
            'allRankings'
        ));
    }

    /**
     * Display the student track records page.
     */
    public function trackRecords()
    {
        $submissions = \App\Models\Submission::where('user_id', Auth::id())
            ->orderBy('submission_date', 'desc')
            ->get();

        return view('user.track-records', compact('submissions'));
    }

    /**
     * View a submission document.
     */
    public function viewDocument($id)
    {
        $submission = \App\Models\Submission::where('user_id', Auth::id())->findOrFail($id);

        if (!$submission->file_data) {
            abort(404);
        }

        $decodedData = base64_decode($submission->file_data);
        $extension = strtolower(pathinfo($submission->file_name, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif'
        ];

        $contentType = $mimeTypes[$extension] ?? 'application/octet-stream';

        return response($decodedData)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'inline; filename="' . $submission->file_name . '"');
    }

    /**
     * Display the student profile update page.
     */
    public function profile()
    {
        return view('user.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the student's profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'full_name' => 'required|string|max:255',
            'sport' => 'required|string|max:255',
            'campus' => 'required|string|max:255',
        ]);

        $user->update([
            'full_name' => $request->full_name,
            'sport' => $request->sport,
            'campus' => $request->campus,
        ]);

        return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
    }
}
