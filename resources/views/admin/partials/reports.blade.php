@php
$stats = $stats ?? [];
@endphp

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div style="background: white; padding: 24px; border-bottom: 4px solid var(--maroon); box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Total Students</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: var(--maroon);">
                    {{ $stats['totalStudents'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(122,20,40,0.08); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-user' style="font-size: 1.8rem; color: var(--maroon);"></i>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-bottom: 4px solid var(--gold); box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Total Admins</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: var(--gold-dark);">
                    {{ $stats['totalAdmins'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(240,180,41,0.15); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-user-check' style="font-size: 1.8rem; color: var(--gold-dark);"></i>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-bottom: 4px solid #10B981; box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Pending Approvals</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: #059669;">
                    {{ $stats['pendingApprovals'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(16,185,129,0.08); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-time' style="font-size: 1.8rem; color: #10B981;"></i>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-bottom: 4px solid #3B82F6; box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Total Submissions</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: #2563EB;">
                    {{ $stats['totalSubmissions'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(59,130,246,0.08); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-file' style="font-size: 1.8rem; color: #3B82F6;"></i>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-bottom: 4px solid #10B981; box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Approved Sub.</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: #059669;">
                    {{ $stats['approvedSubmissions'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(16,185,129,0.08); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-check-circle' style="font-size: 1.8rem; color: #10B981;"></i>
            </div>
        </div>
    </div>

    <div style="background: white; padding: 24px; border-bottom: 4px solid #F59E0B; box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="display: flex; items-center; justify-content: space-between;">
            <div>
                <p style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 700; color: var(--text-muted); margin-bottom: 8px;">Pending Sub.</p>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: 1; color: #D97706;">
                    {{ $stats['pendingSubmissions'] ?? 0 }}
                </p>
            </div>
            <div style="width: 56px; height: 56px; border-radius: 4px; background: rgba(245,158,11,0.08); display: flex; align-items: center; justify-content: center;">
                <i class='bx bx-hourglass' style="font-size: 1.8rem; color: #F59E0B;"></i>
            </div>
        </div>
    </div>
</div>

<div style="background: white; padding: 32px; box-shadow: 0 8px 25px rgba(0,0,0,0.04); border-top: 4px solid var(--maroon); clip-path: polygon(0 0, calc(100% - 24px) 0, 100% 24px, 100% 100%, 0 100%);">
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800; text-transform: uppercase; color: var(--charcoal); margin-bottom: 24px;">
        Quick Actions
    </h3>
    <div style="display: flex; flex-wrap: wrap; gap: 16px;">
        <a href="{{ route('admin.student-athletes') }}" class="btn btn-primary" style="text-decoration: none;">
            <i class='bx bx-user'></i> Manage Students
        </a>
        <a href="{{ route('admin.account-approvals') }}" class="btn btn-primary" style="text-decoration: none;">
            <i class='bx bx-user-check'></i> Review Approvals
        </a>
        <a href="{{ route('admin.evaluations') }}" class="btn btn-primary" style="text-decoration: none;">
            <i class='bx bx-folder'></i> Evaluate Submissions
        </a>
        <a href="{{ route('admin.achievements') }}" class="btn btn-primary" style="text-decoration: none;">
            <i class='bx bx-trophy'></i> View Achievements
        </a>
    </div>
</div>
