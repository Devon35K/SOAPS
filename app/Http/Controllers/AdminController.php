<?php

namespace App\Http\Controllers;

use App\Services\SessionManager;
use App\Services\DatabaseService;
use App\Models\User;
use App\Models\AccountApproval;
use App\Mail\ApprovalMail;
use App\Mail\RejectionMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    /** Canonical sports list — single source of truth for all admin views */
    const SPORTS = [
        'Athletics', 'Badminton', 'Basketball', 'Cheerleading', 'Chess',
        'Dance Sports', 'Esports', 'Football', 'Sepak Takraw', 'Softball',
        'Swimming', 'Table Tennis', 'Taekwondo', 'Tennis', 'Volleyball', 'Wrestling',
    ];

    /** Canonical campus list */
    const CAMPUSES = [
        'Tagum-Mabini', 'Obrero', 'Mintal', 'Guianga', 'Bislig',
    ];

    public function index(Request $request)
    {
        $currentPage = $request->get('page', 'Dashboard');

        // Fetch Analytics Data
        $stats = [
            'totalAthletes' => \App\Models\User::where('role', 'user')->count(),
            'pendingEvaluations' => \App\Models\Submission::where('status', 'pending')->count(),
            'pendingAccounts' => \App\Models\AccountApproval::where('status', 'pending')->count(),
            'totalPoints' => \App\Models\Leaderboard::sum('total_points'),
            'recentSubmissions' => \App\Models\Submission::with('user')->orderBy('created_at', 'desc')->take(5)->get(),
        ];

        return view('admin.index', array_merge([
            'currentPage' => $currentPage,
        ], $stats));
    }

    public function studentAthletes(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $sport      = $request->get('sport', '');
        $campus     = $request->get('campus', '');
        $status     = $request->get('status', '');
        $perPage    = 15;

        $users = User::query()
            ->where('role', 'user')
            ->where('approved', true)
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('student_id', 'like', "%{$searchTerm}%")
                      ->orWhere('full_name', 'like', "%{$searchTerm}%");
                });
            })
            ->when($sport,   fn($q) => $q->where('sport', $sport))
            ->when($campus,  fn($q) => $q->where('campus', $campus))
            ->when($status,  fn($q) => $q->where('status', $status))
            ->with(['images', 'achievements'])
            ->paginate($perPage);

        return view('admin.index', [
            'currentPage' => 'Student Athletes',
            'users'       => $users,
            'searchTerm'  => $searchTerm,
            'sport'       => $sport,
            'campus'      => $campus,
            'status'      => $status,
            'sports'      => self::SPORTS,
            'campuses'    => self::CAMPUSES,
        ]);
    }

    /**
     * AJAX endpoint — returns only the athlete rows + pagination HTML.
     */
    public function studentAthletesSearch(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $sport      = $request->get('sport', '');
        $campus     = $request->get('campus', '');
        $status     = $request->get('status', '');
        $perPage    = 15;

        $users = User::query()
            ->where('role', 'user')
            ->where('approved', true)
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('student_id', 'like', "%{$searchTerm}%")
                      ->orWhere('full_name', 'like', "%{$searchTerm}%");
                });
            })
            ->when($sport,   fn($q) => $q->where('sport', $sport))
            ->when($campus,  fn($q) => $q->where('campus', $campus))
            ->when($status,  fn($q) => $q->where('status', $status))
            ->with(['images'])
            ->paginate($perPage);

        return view('admin.partials.student-athletes-results', [
            'users'  => $users,
        ]);
    }

    public function achievements(Request $request)
    {

        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $sport = $request->get('sport', '');
        $leaderboardStatus = $request->get('leaderboard_status', 'undergraduate');

        $achievements = \App\Models\Achievement::query()
            ->when($search, fn($q) => $q->where('athlete_name', 'like', "%{$search}%"))
            ->when($status, function ($q) use ($status) {
                $q->whereHas('user', fn($uq) => $uq->where('status', $status));
            })
            ->when($sport, function ($q) use ($sport) {
                $q->whereHas('user', fn($uq) => $uq->where('sport', $sport));
            })
            ->with('user')
            ->get();

        $leaderboard = \App\Models\Leaderboard::with('user.images')
            ->join('users', 'leaderboard.user_id', '=', 'users.id')
            ->when($search, function ($q) use ($search) {
                $q->where('users.full_name', 'like', "%{$search}%")
                  ->orWhere('users.student_id', 'like', "%{$search}%");
            })
            ->when($status, fn($q) => $q->where('users.status', $status))
            ->when($sport, fn($q) => $q->where('users.sport', $sport))
            ->select('leaderboard.*', 'users.full_name as athlete_name')
            ->orderBy('leaderboard.total_points', 'desc')
            ->get();

        return view('admin.index', [
            'currentPage' => 'Achievement',
            'achievements' => $achievements,
            'leaderboard'  => $leaderboard,
            'search'       => $search,
            'status'       => $status,
            'sport'        => $sport,
            'leaderboardStatus' => $leaderboardStatus,
            'sports'       => self::SPORTS,
        ]);
    }

    /**
     * AJAX endpoint — returns only the achievements + leaderboard rows HTML.
     */
    public function achievementsSearch(Request $request)
    {
        $search = $request->get('search', '');
        $status = $request->get('status', '');
        $sport  = $request->get('sport', '');

        $achievements = \App\Models\Achievement::query()
            ->when($search, fn($q) => $q->where('athlete_name', 'like', "%{$search}%"))
            ->when($status, function ($q) use ($status) {
                $q->whereHas('user', fn($uq) => $uq->where('status', $status));
            })
            ->when($sport, function ($q) use ($sport) {
                $q->whereHas('user', fn($uq) => $uq->where('sport', $sport));
            })
            ->with('user')
            ->get();

        $leaderboard = \App\Models\Leaderboard::with('user.images')
            ->join('users', 'leaderboard.user_id', '=', 'users.id')
            ->when($search, function ($q) use ($search) {
                $q->where('users.full_name', 'like', "%{$search}%")
                  ->orWhere('users.student_id', 'like', "%{$search}%");
            })
            ->when($status, fn($q) => $q->where('users.status', $status))
            ->when($sport, fn($q) => $q->where('users.sport', $sport))
            ->select('leaderboard.*', 'users.full_name as athlete_name')
            ->orderBy('leaderboard.total_points', 'desc')
            ->get();

        return view('admin.partials.achievements-results', [
            'achievements' => $achievements,
            'leaderboard'  => $leaderboard,
        ]);
    }

    public function evaluations(Request $request)
    {

        $searchTerm = $request->get('search', '');

        $users = User::query()
            ->where('role', 'user')
            ->where('approved', true)
            ->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where(function ($subQ) use ($searchTerm) {
                    $subQ->where('student_id', 'like', "%{$searchTerm}%")
                         ->orWhere('full_name', 'like', "%{$searchTerm}%");
                });
            })
            ->with(['images', 'submissions' => function ($q) {
                $q->where('status', 'pending');
            }])
            ->paginate(15);


        $submissionsByUser = [];
        foreach ($users as $user) {
            $submissionsByUser[$user->id] = $user->submissions;
        }

        return view('admin.index', [
            'currentPage' => 'Evaluation',
            'users' => $users,
            'submissionsByUser' => $submissionsByUser,
            'searchTerm' => $searchTerm,
        ]);
    }

    /**
     * AJAX endpoint — returns only the evaluations rows + pagination HTML.
     */
    public function evaluationsSearch(Request $request)
    {
        $searchTerm = $request->get('search', '');

        $users = User::query()
            ->where('role', 'user')
            ->where('approved', true)
            ->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where(function ($subQ) use ($searchTerm) {
                    $subQ->where('student_id', 'like', "%{$searchTerm}%")
                         ->orWhere('full_name', 'like', "%{$searchTerm}%");
                });
            })
            ->with(['images', 'submissions' => function ($q) {
                $q->where('status', 'pending');
            }])
            ->paginate(15);

        $submissionsByUser = [];
        foreach ($users as $user) {
            $submissionsByUser[$user->id] = $user->submissions;
        }

        return view('admin.partials.evaluations-results', [
            'users' => $users,
            'submissionsByUser' => $submissionsByUser,
        ]);
    }


    public function approvedDocs(Request $request)
    {
        $searchTerm = $request->get('search', '');

        $query = \App\Models\Submission::where('status', 'approved')->with('user');

        if (!empty($searchTerm)) {
            $query->whereHas('user', function ($q) use ($searchTerm) {
                $q->where('full_name', 'like', "%{$searchTerm}%")
                  ->orWhere('student_id', 'like', "%{$searchTerm}%");
            });
        }

        $submissions = $query->latest('updated_at')->get();

        return view('admin.index', [
            'currentPage' => 'Approved Docs',
            'submissions' => $submissions,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function reports(Request $request)
    {

        $stats = [
            'totalStudents' => User::where('role', 'user')->where('approved', true)->count(),
            'totalAdmins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'pendingApprovals' => AccountApproval::where('approval_status', 'pending')->count(),
            'totalSubmissions' => \App\Models\Submission::count(),
            'approvedSubmissions' => \App\Models\Submission::where('status', 'approved')->count(),
            'pendingSubmissions' => \App\Models\Submission::where('status', 'pending')->count(),
        ];

        return view('admin.index', [
            'currentPage' => 'Reports',
            'stats' => $stats,
        ]);
    }

    public function accountApprovals(Request $request)
    {

        $status = $request->get('status');
        $action = $request->get('action');

        $requests = \App\Models\AccountApproval::where('approval_status', 'pending')
            ->orderBy('request_date', 'desc')
            ->get();

        return view('admin.index', [
            'currentPage' => 'Account Approvals',
            'requests' => $requests,
            'status' => $status,
            'action' => $action,
        ]);
    }

    public function approveRequest(Request $request)
    {

        $approvalId = $request->input('approval_id');
        $approval = \App\Models\AccountApproval::find($approvalId);

        if ($approval) {
            $approval->approval_status = 'approved';
            $approval->approved_by = auth()->id();
            $approval->approval_date = now();
            $approval->save();

            // Create user account with all fields from approval request
            User::create([
                'student_id' => $approval->student_id,
                'full_name' => $approval->full_name,
                'email' => $approval->email,
                'password' => $approval->password,
                'status' => $approval->status,
                'sport' => $approval->sport,
                'campus' => $approval->campus,
                'year_section' => $approval->year_section,
                'approved' => true,
                'role' => 'user',
            ]);

            // Send approval email
            try {
                Mail::to($approval->email)->send(new ApprovalMail($approval->full_name, $approval->student_id, $approval->email));
            } catch (\Exception $e) {
                Log::error('Failed to send approval email: ' . $e->getMessage());
            }

            return $request->ajax() 
                ? response()->json(['success' => true, 'message' => 'Request approved successfully! User has been notified.'])
                : redirect()->route('admin.account-approvals', ['status' => 'success', 'action' => 'approve']);
        }

        return $request->ajax()
            ? response()->json(['success' => false, 'message' => 'Failed to find approval request.'])
            : redirect()->route('admin.account-approvals', ['status' => 'error', 'action' => 'approve']);
    }

    public function rejectRequest(Request $request)
    {

        $approvalId = $request->input('approval_id');
        $approval = \App\Models\AccountApproval::find($approvalId);

        if ($approval) {
            // Store email and name for the rejection mail before deleting
            $email = $approval->email;
            $name = $approval->full_name;
            $rejectionReason = $request->input('rejection_reason', '');

            // Delete the record as requested by the user ("when rejected it won't register to the database")
            $approval->delete();

            // Send rejection email
            try {
                Mail::to($email)->send(new RejectionMail($name, $rejectionReason));
            } catch (\Exception $e) {
                Log::error('Failed to send rejection email: ' . $e->getMessage());
            }

            return $request->ajax() 
                ? response()->json(['success' => true, 'message' => 'Request rejected successfully!'])
                : redirect()->route('admin.account-approvals', ['status' => 'success', 'action' => 'reject']);
        }


        return $request->ajax()
            ? response()->json(['success' => false, 'message' => 'Failed to reject request.'])
            : redirect()->route('admin.account-approvals', ['status' => 'error', 'action' => 'reject']);
    }

    public function viewApprovalDocument($id)
    {
        $approval = AccountApproval::findOrFail($id);

        if (!$approval->file_data) {
            abort(404);
        }

        // Decode base64 data
        $decodedData = base64_decode($approval->file_data);

        return response($decodedData)
            ->header('Content-Type', $approval->file_type)
            ->header('Content-Disposition', 'inline; filename="' . $approval->file_name . '"');
    }

    /**
     * Get pending submissions for a specific user (for AJAX modal)
     */
    public function getUserSubmissions($userId)
    {
        $submissions = \App\Models\Submission::where('user_id', $userId)
            ->where('status', 'pending')
            ->get();

        return response()->json($submissions);
    }

    /**
     * Process evaluation: Approve/Reject and assign points
     */
    public function evaluateSubmission(Request $request)
    {
        $request->validate([
            'submission_id' => 'required|exists:submissions,id',
            'action' => 'required|in:approve,reject',
            'level' => 'required_if:action,approve|in:Local,Regional,National,International',
            'rank' => 'required_if:action,approve|in:1st,2nd,3rd,Participant',
            'points' => 'required_if:action,approve|integer',
            'comments' => 'nullable|string'
        ]);

        $submission = \App\Models\Submission::findOrFail($request->submission_id);
        $user = $submission->user;

        if ($request->action === 'approve') {
            $submission->status = 'approved';
            $submission->comments = $request->comments;
            $submission->save();

            // Create Achievement record only if points are awarded
            if ($request->points > 0) {
                \App\Models\Achievement::create([
                    'user_id' => $user->id,
                    'athlete_name' => $user->full_name,
                    'level_of_competition' => $request->level,
                    'performance' => $request->rank,
                    'total_points' => $request->points,
                    'status' => 'Approved',
                    'approved_by' => auth()->id(),
                    'submission_date' => now(),
                    'documents' => ['submission_id' => $submission->id]
                ]);

                // Update Leaderboard
                $leaderboard = \App\Models\Leaderboard::firstOrCreate(
                    ['user_id' => $user->id],
                    ['total_points' => 0]
                );
                $leaderboard->total_points += $request->points;
                $leaderboard->save();
            }

            return response()->json(['success' => true, 'message' => $request->points > 0 ? 'Submission approved and points awarded!' : 'Document approved and archived.']);
        } else {
            $submission->status = 'rejected';
            $submission->comments = $request->comments;
            $submission->save();

            // Create a Rejected Achievement record so the user sees rejection reason in their Achievements page
            \App\Models\Achievement::create([
                'user_id' => $user->id,
                'athlete_name' => $user->full_name,
                'level_of_competition' => $request->level ?? 'N/A',
                'performance' => $request->rank ?? 'N/A',
                'total_points' => 0,
                'status' => 'Rejected',
                'approved_by' => auth()->id(),
                'rejection_reason' => $request->comments,
                'submission_date' => now(),
                'documents' => ['submission_id' => $submission->id]
            ]);

            return response()->json(['success' => true, 'message' => 'Submission rejected.']);
        }
    }

    /**
     * View a specific submission file
     */
    public function viewSubmissionFile($id)
    {
        $submission = \App\Models\Submission::findOrFail($id);
        
        if (!$submission->file_data) abort(404);

        $decodedData = base64_decode($submission->file_data);
        $extension = strtolower(pathinfo($submission->file_name, PATHINFO_EXTENSION));
        
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg', 'jpeg' => 'image/jpeg', 'png' => 'image/png'
        ];

        return response($decodedData)
            ->header('Content-Type', $mimeTypes[$extension] ?? 'application/octet-stream')
            ->header('Content-Disposition', 'inline; filename="' . $submission->file_name . '"');
    }

    public function users(Request $request)
    {

        $users = User::all();

        return view('admin.index', [
            'currentPage' => 'Users',
            'users' => $users,
        ]);
    }

    public function createUser()
    {
        return view('admin.index', ['currentPage' => 'Create User']);
    }

    public function storeUser(Request $request)
    {

        $validated = $request->validate([
            'student_id' => 'required|unique:users',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'user_type' => 'required|in:student,alumni,admin,super_admin',
        ]);

        $role = in_array($validated['user_type'], ['admin', 'super_admin']) ? $validated['user_type'] : 'user';
        $status = $validated['user_type'] === 'alumni' ? 'alumni' : 'undergraduate';

        User::create([
            'student_id' => $validated['student_id'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $role,
            'status' => $status,
            'approved' => true,
        ]);

        return redirect()->route('admin.users')->with('message', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        
        // Determine user_type for the form
        $userType = $user->role;
        if ($user->role === 'user') {
            $userType = $user->status === 'alumni' ? 'alumni' : 'student';
        }
        $user->user_type = $userType;

        return view('admin.index', ['currentPage' => 'Edit User', 'editUser' => $user]);
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'user_type' => 'required|in:student,alumni,admin,super_admin',
        ]);

        $role = in_array($validated['user_type'], ['admin', 'super_admin']) ? $validated['user_type'] : 'user';
        $status = $validated['user_type'] === 'alumni' ? 'alumni' : 'undergraduate';

        $user->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'role' => $role,
            'status' => $status,
        ]);

        return redirect()->route('admin.users')->with('message', 'User updated successfully');
    }

    public function deleteUser($id)
    {

        $user = User::findOrFail($id);
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.users')->with('error', 'Cannot delete Super Admin');
        }

        $user->delete();
        return redirect()->route('admin.users')->with('message', 'User deleted successfully');
    }
}
