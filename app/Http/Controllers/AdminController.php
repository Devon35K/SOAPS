<?php

namespace App\Http\Controllers;

use App\Services\SessionManager;
use App\Services\DatabaseService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->get('page', 'Dashboard');

        return view('admin.index', [
            'currentPage' => $currentPage,
        ]);
    }

    public function studentAthletes(Request $request)
    {
        $searchTerm = $request->get('search', '');
        $sport = $request->get('sport', '');
        $campus = $request->get('campus', '');
        $status = $request->get('status', '');
        $page = max(1, (int) $request->get('page_num', 1));
        $perPage = 10;

        $users = User::query()
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('student_id', 'like', "%{$searchTerm}%")
                      ->orWhere('full_name', 'like', "%{$searchTerm}%");
                });
            })
            ->when($sport, fn($q) => $q->where('sport', $sport))
            ->when($campus, fn($q) => $q->where('campus', $campus))
            ->when($status, fn($q) => $q->where('status', $status))
            ->with('images')
            ->paginate($perPage, ['*'], 'page', $page);

        return view('admin.partials.student-athletes', [
            'users' => $users,
            'searchTerm' => $searchTerm,
            'sport' => $sport,
            'campus' => $campus,
            'status' => $status,
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

        $leaderboard = \App\Models\Leaderboard::where('status', $leaderboardStatus)
            ->orderBy('total_points', 'desc')
            ->get();

        return view('admin.partials.achievements', [
            'achievements' => $achievements,
            'leaderboard' => $leaderboard,
            'search' => $search,
            'status' => $status,
            'sport' => $sport,
            'leaderboardStatus' => $leaderboardStatus,
            'sports' => ['Basketball', 'Volleyball', 'Football', 'Swimming', 'Track and Field', 'Tennis', 'Table Tennis', 'Badminton'],
        ]);
    }

    public function evaluations(Request $request)
    {

        $searchTerm = $request->get('search', '');

        $users = User::query()
            ->when($searchTerm, function ($q) use ($searchTerm) {
                $q->where('student_id', 'like', "%{$searchTerm}%")
                  ->orWhere('full_name', 'like', "%{$searchTerm}%");
            })
            ->with(['submissions' => function ($q) {
                $q->where('status', 'pending');
            }])
            ->get();

        $submissionsByUser = [];
        foreach ($users as $user) {
            $submissionsByUser[$user->id] = $user->submissions;
        }

        return view('admin.partials.evaluations', [
            'users' => $users,
            'submissionsByUser' => $submissionsByUser,
            'searchTerm' => $searchTerm,
        ]);
    }

    public function approvedDocs(Request $request)
    {

        $submissions = \App\Models\Submission::where('status', 'approved')
            ->with('user')
            ->get();

        return view('admin.partials.approved-docs', [
            'submissions' => $submissions,
        ]);
    }

    public function reports(Request $request)
    {

        $stats = [
            'totalStudents' => User::where('role', 'user')->count(),
            'totalAdmins' => User::whereIn('role', ['admin', 'super_admin'])->count(),
            'pendingApprovals' => \App\Models\AccountApproval::where('approval_status', 'pending')->count(),
            'totalSubmissions' => \App\Models\Submission::count(),
            'approvedSubmissions' => \App\Models\Submission::where('status', 'approved')->count(),
            'pendingSubmissions' => \App\Models\Submission::where('status', 'pending')->count(),
        ];

        return view('admin.partials.reports', [
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
            $approval->save();

            // Create user account
            User::create([
                'student_id' => $approval->student_id,
                'full_name' => $approval->full_name,
                'email' => $approval->email,
                'password' => $approval->password,
                'status' => $approval->status,
                'approved' => true,
                'role' => 'user',
            ]);

            return redirect()->route('admin.account-approvals', ['status' => 'success', 'action' => 'approve']);
        }

        return redirect()->route('admin.account-approvals', ['status' => 'error', 'action' => 'approve']);
    }

    public function rejectRequest(Request $request)
    {

        $approvalId = $request->input('approval_id');
        $approval = \App\Models\AccountApproval::find($approvalId);

        if ($approval) {
            $approval->approval_status = 'rejected';
            $approval->save();

            return redirect()->route('admin.account-approvals', ['status' => 'success', 'action' => 'reject']);
        }

        return redirect()->route('admin.account-approvals', ['status' => 'error', 'action' => 'reject']);
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
            'role' => 'required|in:admin,super_admin,user',
        ]);

        User::create([
            ...$validated,
            'password' => Hash::make($validated['password']),
            'approved' => true,
        ]);

        return redirect()->route('admin.users')->with('message', 'User created successfully');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.index', ['currentPage' => 'Edit User', 'editUser' => $user]);
    }

    public function updateUser(Request $request, $id)
    {

        $user = User::findOrFail($id);
        $validated = $request->validate([
            'full_name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,super_admin,user',
        ]);

        $user->update($validated);

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
