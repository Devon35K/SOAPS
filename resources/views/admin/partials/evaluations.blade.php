<div class="search-form">
    <form method="GET" action="{{ route('admin.evaluations') }}" class="search-grid" style="grid-template-columns: 1fr auto;">
        <div class="form-group">
            <label>Search Student</label>
            <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Search by Student ID or Name..." class="form-control">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-search'></i> Search
            </button>
        </div>
    </form>
</div>

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
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <i class='bx bx-user text-gray-600'></i>
                </div>
                {{ $user->full_name }}
            </div>
            <div>{{ $user->student_id }}</div>
            <div>
                <span class="px-3 py-1 rounded-full text-sm {{ $pendingCount > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600' }}">
                    {{ $pendingCount }} Document{{ $pendingCount !== 1 ? 's' : '' }}
                </span>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.7rem;" onclick="openEvaluationModal({{ $user->id }})">
                    <i class='bx bx-folder-open'></i> View Submissions
                </button>
            </div>
        </div>
    @empty
        <div class="table-row text-center" style="grid-template-columns: 1fr;">
            <div>No students found</div>
        </div>
    @endforelse
</div>

<!-- Evaluation Modal -->
<div id="evaluationModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl mx-4" style="max-height: 80vh; overflow-y: auto;">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-bold" style="font-family: 'Barlow Condensed', sans-serif; color: var(--maroon);">Evaluate Submissions</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        <div id="submissionsContent">
            <!-- Content loaded via JS -->
        </div>
    </div>
</div>

<script>
function openEvaluationModal(userId) {
    document.getElementById('evaluationModal').classList.remove('hidden');
    // Load submissions via AJAX
}

function closeModal() {
    document.getElementById('evaluationModal').classList.add('hidden');
}
</script>
