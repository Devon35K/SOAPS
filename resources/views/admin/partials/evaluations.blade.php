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
<div id="evaluationModal" style="position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 1000;">
    <div style="background: white; border-top: 4px solid var(--gold); width: 95%; max-width: 900px; max-height: 90vh; display: flex; flex-direction: column; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); position: relative; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <!-- Fixed Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 24px 32px; border-bottom: 1px solid #f1f5f9;">
            <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 2rem; font-weight: 800; text-transform: uppercase; color: var(--maroon); margin: 0;">Evaluate Submissions</h2>
            <button onclick="closeModal()" style="background: #f1f5f9; border: none; width: 40px; height: 40px; border-radius: 50%; font-size: 1.5rem; color: var(--text-muted); cursor: pointer; display: flex; align-items: center; justify-content: center;"><i class='bx bx-x'></i></button>
        </div>
        <!-- Scrollable Content Area -->
        <div id="submissionsContent" style="flex: 1; overflow-y: auto; overflow-x: hidden; padding: 32px; background: #fff;">
            <!-- Content loaded via JS -->
        </div>
    </div>
</div>

<script>
const pointSystem = {
    'Local': { '1st': 15, '2nd': 10, '3rd': 5, 'Participant': 2 },
    'Regional': { '1st': 30, '2nd': 20, '3rd': 10, 'Participant': 5 },
    'National': { '1st': 60, '2nd': 40, '3rd': 20, 'Participant': 10 },
    'International': { '1st': 100, '2nd': 80, '3rd': 60, 'Participant': 20 }
};

function openEvaluationModal(userId) {
    const modal = document.getElementById('evaluationModal');
    const content = document.getElementById('submissionsContent');
    modal.style.display = 'flex';
    content.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="bx bx-loader-alt bx-spin" style="font-size: 3rem; color: var(--maroon);"></i><p>Loading student submissions...</p></div>';

    fetch(`/admin/user-submissions/${userId}`)
        .then(response => response.json())
        .then(submissions => {
            if (submissions.length === 0) {
                content.innerHTML = '<p style="text-align: center; padding: 20px;">No pending submissions found for this student.</p>';
                return;
            }

            content.innerHTML = submissions.map(sub => `
                <div id="sub-card-${sub.id}" style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                    <div style="display: flex; gap: 20px;">
                        <!-- File Preview Info -->
                        <div style="flex: 1;">
                            <h4 style="margin: 0 0 10px 0; color: var(--maroon); font-family: 'Barlow Condensed'; font-size: 1.2rem;">${sub.file_name}</h4>
                            <p style="font-size: 0.85rem; color: #64748b; margin-bottom: 15px;">${sub.description || 'No description provided'}</p>
                            <a href="/admin/submission-view/${sub.id}" target="_blank" class="btn btn-outline" style="padding: 6px 12px; font-size: 0.75rem;">
                                <i class="bx bx-show"></i> Preview Document
                            </a>
                        </div>
                        
                        <!-- Evaluation Form -->
                        <div style="flex: 1; background: white; padding: 15px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
                            <div id="eval-form-${sub.id}" style="${['achievement', 'participation'].includes(sub.document_type) ? '' : 'display: none;'}">
                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700; color: #64748b;">Competition Level</label>
                                    <select onchange="updatePoints(${sub.id})" id="level-${sub.id}" class="form-control" style="font-size: 0.85rem; padding: 8px;">
                                        <option value="Local">Local / University</option>
                                        <option value="Regional">Regional</option>
                                        <option value="National">National</option>
                                        <option value="International">International</option>
                                    </select>
                                </div>
                                <div class="form-group" style="margin-bottom: 12px;">
                                    <label style="font-size: 0.7rem; text-transform: uppercase; font-weight: 700; color: #64748b;">Performance/Rank</label>
                                    <select onchange="updatePoints(${sub.id})" id="rank-${sub.id}" class="form-control" style="font-size: 0.85rem; padding: 8px;">
                                        <option value="1st">1st Place / Gold</option>
                                        <option value="2nd">2nd Place / Silver</option>
                                        <option value="3rd">3rd Place / Bronze</option>
                                        <option value="Participant">Participation / Finalist</option>
                                    </select>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 15px; padding-top: 10px; border-top: 1px dashed #e2e8f0;">
                                    <span style="font-family: 'Barlow Condensed'; font-weight: 800; color: var(--charcoal);">AWARD POINTS:</span>
                                    <span id="points-display-${sub.id}" style="font-size: 1.5rem; font-weight: 900; color: var(--maroon);">15</span>
                                </div>
                            </div>
                            <div id="clearance-msg-${sub.id}" style="${['achievement', 'participation'].includes(sub.document_type) ? 'display: none;' : ''}">
                                <p style="color: #64748b; font-size: 0.85rem; text-align: center; margin: 10px 0;">This is a <strong>${sub.document_type.replace('_', ' ')}</strong>. You can approve it directly for archiving without awarding points.</p>
                                <button onclick="toggleEvalForm(${sub.id})" style="width: 100%; background: none; border: 1px dashed var(--maroon); color: var(--maroon); padding: 5px; font-size: 0.7rem; cursor: pointer; text-transform: uppercase; font-weight: 700;">Award points instead?</button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                        <button onclick="submitEvaluation(${sub.id}, 'reject')" class="btn" style="background: #fee2e2; color: #991b1b; padding: 8px 16px; border: none; cursor: pointer;">Reject</button>
                        <button onclick="submitEvaluation(${sub.id}, 'approve')" id="approve-btn-${sub.id}" class="btn btn-primary" style="padding: 8px 24px;">
                            ${['achievement', 'participation'].includes(sub.document_type) ? 'Approve & Award Points' : 'Approve & Archive'}
                        </button>
                    </div>
                </div>
            `).join('');
        });
}

function toggleEvalForm(subId) {
    document.getElementById(`eval-form-${subId}`).style.display = 'block';
    document.getElementById(`clearance-msg-${subId}`).style.display = 'none';
    document.getElementById(`approve-btn-${subId}`).innerText = 'Approve & Award Points';
}

function updatePoints(subId) {
    const level = document.getElementById(`level-${subId}`).value;
    const rank = document.getElementById(`rank-${subId}`).value;
    const points = pointSystem[level][rank];
    document.getElementById(`points-display-${subId}`).innerText = points;
}

function submitEvaluation(subId, action) {
    const evalForm = document.getElementById(`eval-form-${subId}`);
    const isEvalVisible = evalForm && evalForm.style.display !== 'none';
    
    const levelSelect = document.getElementById(`level-${subId}`);
    const rankSelect = document.getElementById(`rank-${subId}`);
    const pointsDisplay = document.getElementById(`points-display-${subId}`);

    const level = isEvalVisible && levelSelect ? levelSelect.value : 'Local';
    const rank = isEvalVisible && rankSelect ? rankSelect.value : 'Participant';
    const points = (action === 'approve' && isEvalVisible && pointsDisplay) ? pointsDisplay.innerText : 0;

    const data = {
        submission_id: subId,
        action: action,
        level: level,
        rank: rank,
        points: parseInt(points) || 0,
    };

    // Show loading state on button
    const btn = event.target.closest('button');
    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Processing...';

    fetch('{{ route("admin.evaluate-submission") }}', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(async response => {
        const result = await response.json();
        if (!response.ok) throw new Error(result.message || 'Server error occurred');
        return result;
    })
    .then(result => {
        if (result.success) {
            const card = document.getElementById(`sub-card-${subId}`);
            card.innerHTML = `<div style="color: #059669; font-weight: 600; text-align: center; padding: 40px; background: #ecfdf5; border-radius: 8px;">
                <i class="bx bx-check-circle" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i> 
                ${result.message}
            </div>`;
            setTimeout(() => {
                card.style.opacity = '0';
                card.style.transition = 'opacity 0.5s';
                setTimeout(() => {
                    card.style.display = 'none';
                    if (document.querySelectorAll('[id^="sub-card-"]:not([style*="display: none"])').length === 0) {
                        location.reload();
                    }
                }, 500);
            }, 1500);
        } else {
            throw new Error(result.message || 'Action failed');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Evaluation failed: ' + error.message);
        btn.disabled = false;
        btn.innerHTML = originalText;
    });
}

function closeModal() {
    const modal = document.getElementById('evaluationModal');
    modal.style.display = 'none';
}
</script>
