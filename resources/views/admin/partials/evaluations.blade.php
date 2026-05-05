<div class="search-form">
    <form method="GET" action="{{ route('admin.evaluations') }}" class="search-grid" style="grid-template-columns: 1fr auto;">
        <div class="form-group">
            <label>Search Student</label>
            <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Search by Student ID or Name..." class="form-control">
        </div>
        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-primary" style="height: 100%;">
                <i class='bx bx-search'></i> Search
            </button>
        </div>
    </form>
</div>

<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Student Evaluations</h2>
<div class="data-table">
    <div class="table-header" style="grid-template-columns: 2fr 2fr 1fr 1.5fr;">
        <div>Student Name</div>
        <div>Student ID</div>
        <div>Pending Submissions</div>
        <div>Actions</div>
    </div>

    @forelse($users as $user)
        @php
            $userId = $user->id;
            $submissions = $submissionsByUser[$userId] ?? collect();
            $pendingCount = $submissions->where('status', 'pending')->count();
        @endphp
        <div class="table-row" style="grid-template-columns: 2fr 2fr 1fr 1.5fr;">
            <div data-label="Student Name" style="display: flex; align-items: center; gap: 12px; font-weight: 600;">
                <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.08); color: var(--maroon); display: flex; align-items: center; justify-content: center;">
                    <i class='bx bx-user' style="font-size: 1.2rem;"></i>
                </div>
                {{ $user->full_name }}
            </div>
            <div data-label="Student ID">{{ $user->student_id }}</div>
            <div data-label="Pending Submissions">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; 
                    {{ $pendingCount > 0 ? 'background: #fef08a; color: #854d0e;' : 'background: #f1f5f9; color: #475569;' }}">
                    {{ $pendingCount }} Document{{ $pendingCount !== 1 ? 's' : '' }}
                </span>
            </div>
            <div data-label="Actions" style="display: flex; gap: 8px;">
                <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem;" onclick="openEvaluationModal({{ $user->id }})">
                    <i class='bx bx-folder-open'></i> View
                </button>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center;">
            <div style="color: var(--text-muted); font-weight: 500;">No students found</div>
        </div>
    @endforelse
</div>

<!-- Evaluation Modal -->
<div id="evaluationModal" style="position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 100;">
    <div style="background: white; border-top: 4px solid var(--gold); padding: 32px; width: 90%; max-width: 800px; max-height: 80vh; overflow-y: auto; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); position: relative;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.8rem; font-weight: 800; text-transform: uppercase; color: var(--maroon);">Evaluate Submissions</h2>
            <button onclick="closeModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i class='bx bx-x'></i></button>
        </div>
        <div id="submissionsContent">
            <!-- Content loaded via JS -->
        </div>
    </div>
</div>

<script>
function openEvaluationModal(userId) {
    const modal = document.getElementById('evaluationModal');
    modal.style.display = 'flex';
    // Load submissions via AJAX
}

function closeModal() {
    const modal = document.getElementById('evaluationModal');
    modal.style.display = 'none';
}
</script>
