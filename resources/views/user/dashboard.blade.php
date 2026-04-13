@extends('user.layout', ['pageTitle' => 'Dash', 'pageTitleSpan' => 'board'])

@section('content')
    <div class="welcome-card">
        <h2>Welcome back, <span>{{ explode(' ', Auth::user()->full_name ?? 'Student')[0] }}</span>!</h2>
        <p>This is your central hub for sports tracking, document submissions, and achievement logging. Access your options below.</p>
    </div>

    <div class="quick-actions">
        <div class="action-card">
            <div class="action-card-left">
                <h3>Document Submissions</h3>
                <p>Submit Forms & Clearances</p>
            </div>
            <div class="action-icon" style="background: rgba(240,180,41,0.15);">
                <i class='bx bx-file-export' style="color: var(--gold-dark);"></i>
            </div>
        </div>
        
        <div class="action-card">
            <div class="action-card-left">
                <h3>Track Records</h3>
                <p>View Submission History</p>
            </div>
            <div class="action-icon" style="background: rgba(16,185,129,0.08);">
                <i class='bx bx-history' style="color: #10B981;"></i>
            </div>
        </div>

        <div class="action-card" style="border-bottom-color: var(--maroon);">
            <div class="action-card-left">
                <h3>Achievements</h3>
                <p>Check Campus Leaderboard</p>
            </div>
            <div class="action-icon">
                <i class='bx bx-trophy'></i>
            </div>
        </div>
    </div>

    <div class="actions-row">
        <a href="{{ route('user.submissions') }}" class="btn btn-primary"><i class='bx bx-plus'></i> New Submission</a>
        <a href="{{ route('user.achievements') }}" class="btn btn-gold"><i class='bx bx-medal'></i> Log Achievement</a>
        <a href="{{ route('user.profile') }}" class="btn btn-outline"><i class='bx bx-user-circle'></i> Edit Profile</a>
    </div>
@endsection
