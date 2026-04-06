@php
$stats = $stats ?? [];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid var(--maroon);">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Total Students</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: var(--maroon);">
                    {{ $stats['totalStudents'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(122,20,40,0.1);">
                <i class='bx bx-user text-xl' style="color: var(--maroon);"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid var(--gold);">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Total Admins</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: var(--gold-dark);">
                    {{ $stats['totalAdmins'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(240,180,41,0.2);">
                <i class='bx bx-user-check text-xl' style="color: var(--gold-dark);"></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid #10B981;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Pending Approvals</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: #059669;">
                    {{ $stats['pendingApprovals'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(16,185,129,0.1);">
                <i class='bx bx-time text-xl text-green-600'></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid #3B82F6;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Total Submissions</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: #2563EB;">
                    {{ $stats['totalSubmissions'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(59,130,246,0.1);">
                <i class='bx bx-file text-xl text-blue-600'></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid #10B981;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Approved</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: #059669;">
                    {{ $stats['approvedSubmissions'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(16,185,129,0.1);">
                <i class='bx bx-check-circle text-xl text-green-600'></i>
            </div>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow" style="border-top: 4px solid #F59E0B;">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm" style="color: var(--text-muted);">Pending</p>
                <p class="text-3xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: #D97706;">
                    {{ $stats['pendingSubmissions'] ?? 0 }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full flex items-center justify-center" style="background: rgba(245,158,11,0.1);">
                <i class='bx bx-hourglass text-xl text-yellow-600'></i>
            </div>
        </div>
    </div>
</div>

<div class="bg-white p-6 rounded-lg shadow">
    <h3 class="text-xl font-bold mb-4" style="font-family: 'Barlow Condensed', sans-serif; color: var(--charcoal);">
        Quick Actions
    </h3>
    <div class="flex flex-wrap gap-4">
        <a href="{{ route('admin.student-athletes') }}" class="btn btn-primary">
            <i class='bx bx-user'></i> Manage Students
        </a>
        <a href="{{ route('admin.account-approvals') }}" class="btn btn-primary">
            <i class='bx bx-user-check'></i> Review Approvals
        </a>
        <a href="{{ route('admin.evaluations') }}" class="btn btn-primary">
            <i class='bx bx-folder'></i> Evaluate Submissions
        </a>
        <a href="{{ route('admin.achievements') }}" class="btn btn-primary">
            <i class='bx bx-trophy'></i> View Achievements
        </a>
    </div>
</div>
