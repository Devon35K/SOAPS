<div class="search-form">
    <form id="eval-search-form" class="search-grid" style="grid-template-columns: 1fr auto;" onsubmit="return false;">
        <div class="form-group">
            <label>Search Student</label>
            <input type="text" id="eval-search" name="search" value="{{ $searchTerm }}" placeholder="Search by Student ID or Name..." class="form-control" style="transition: border-color 0.2s, box-shadow 0.2s;">
        </div>
        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-primary" style="height: 100%; position: relative;">
                <span id="eval-btn-text"><i class='bx bx-search'></i> Search</span>
                <span id="eval-btn-spinner" style="display:none; position: absolute; inset: 0; align-items: center; justify-content: center;">
                    <i class='bx bx-loader-alt' style="animation: spin 0.8s linear infinite;"></i>
                </span>
            </button>
        </div>
    </form>
    
    <!-- Live typing indicator -->
    <div id="eval-typing-bar" style="display:none; margin-top: 12px; height: 2px; border-radius: 1px; background: linear-gradient(90deg, var(--maroon), var(--gold), var(--maroon)); background-size: 200% 100%; animation: shimmer 1.2s infinite;"></div>
</div>

<style>
    @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes shimmer { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
    @keyframes eval-fade-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    #eval-results-wrapper { animation: eval-fade-in 0.2s ease; }
</style>

<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Student Evaluations</h2>

<!-- Results Wrapper -->
<div id="eval-results-wrapper">
    @include('admin.partials.evaluations-results', ['users' => $users, 'submissionsByUser' => $submissionsByUser])
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
                    
                    <!-- Rejection Reason Panel (hidden until Reject is clicked) -->
                    <div id="reject-panel-${sub.id}" style="display:none; margin-top: 16px; padding: 16px; background: #fff5f5; border: 1px solid #fecaca; border-radius: 6px;">
                        <label style="display:block; font-size: 0.7rem; text-transform: uppercase; font-weight: 800; color: #991b1b; letter-spacing: 1px; margin-bottom: 8px;"><i class="bx bx-error-circle"></i> Reason for Rejection <span style="color:#64748b;font-weight:500;">(required)</span></label>
                        <textarea id="reject-reason-${sub.id}" rows="3" placeholder="State the reason why this submission is being rejected..." style="width:100%; padding: 10px 12px; border: 1.5px solid #fca5a5; border-radius: 4px; font-family: 'Barlow', sans-serif; font-size: 0.88rem; color: #1e293b; resize: vertical; outline: none;"></textarea>
                        <div style="display:flex; justify-content:flex-end; gap:8px; margin-top:10px;">
                            <button onclick="cancelReject(${sub.id})" class="btn" style="background:#f1f5f9; color:#475569; padding:7px 14px; font-size:0.75rem;">Cancel</button>
                            <button onclick="confirmReject(${sub.id}, event)" class="btn" style="background:#dc2626; color:white; padding:7px 18px; font-size:0.75rem;"><i class="bx bx-x-circle"></i> Confirm Reject</button>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div style="display: flex; justify-content: flex-end; gap: 10px; margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 15px;">
                        <button onclick="showRejectPanel(${sub.id})" id="reject-btn-${sub.id}" class="btn" style="background: #fee2e2; color: #991b1b; padding: 8px 16px; border: none; cursor: pointer;"><i class="bx bx-x"></i> Reject</button>
                        <button onclick="submitEvaluation(${sub.id}, 'approve', event)" id="approve-btn-${sub.id}" class="btn btn-primary" style="padding: 8px 24px;">
                            ${['achievement', 'participation'].includes(sub.document_type) ? 'Approve & Award Points' : 'Approve & Archive'}
                        </button>
                    </div>
                </div>
            `).join('');
        });
}

function showRejectPanel(subId) {
    document.getElementById(`reject-panel-${subId}`).style.display = 'block';
    document.getElementById(`reject-btn-${subId}`).style.display = 'none';
    document.getElementById(`approve-btn-${subId}`).disabled = true;
    document.getElementById(`approve-btn-${subId}`).style.opacity = '0.4';
    document.getElementById(`reject-reason-${subId}`).focus();
}

function cancelReject(subId) {
    document.getElementById(`reject-panel-${subId}`).style.display = 'none';
    document.getElementById(`reject-btn-${subId}`).style.display = '';
    document.getElementById(`approve-btn-${subId}`).disabled = false;
    document.getElementById(`approve-btn-${subId}`).style.opacity = '1';
    document.getElementById(`reject-reason-${subId}`).value = '';
}

function confirmReject(subId, event) {
    const reason = document.getElementById(`reject-reason-${subId}`).value.trim();
    if (!reason) {
        document.getElementById(`reject-reason-${subId}`).style.borderColor = '#dc2626';
        document.getElementById(`reject-reason-${subId}`).focus();
        return;
    }
    submitEvaluation(subId, 'reject', event, reason);
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

function submitEvaluation(subId, action, event, rejectionReason) {
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
        comments: rejectionReason || '',
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
            const isApproval = action === 'approve';
            card.innerHTML = `<div style="color: ${isApproval ? '#059669' : '#991b1b'}; font-weight: 600; text-align: center; padding: 40px; background: ${isApproval ? '#ecfdf5' : '#fff5f5'}; border-radius: 8px; border: 1px solid ${isApproval ? '#bbf7d0' : '#fecaca'};">
                <i class="bx ${isApproval ? 'bx-check-circle' : 'bx-x-circle'}" style="font-size: 3rem; display: block; margin-bottom: 10px;"></i>
                ${result.message}
                ${!isApproval && data.comments ? `<p style="margin-top:10px; font-size:0.85rem; font-weight:400; color:#64748b; font-style:italic;">"${data.comments}"</p>` : ''}
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

(function() {
    const SEARCH_URL = '{{ route('admin.evaluations.search') }}';
    let debounceTimer = null;
    let currentRequest = null;
    let currentPage = 1;

    const form     = document.getElementById('eval-search-form');
    const wrapper  = document.getElementById('eval-results-wrapper');
    const bar      = document.getElementById('eval-typing-bar');
    const btnText  = document.getElementById('eval-btn-text');
    const spinner  = document.getElementById('eval-btn-spinner');
    const searchInput = document.getElementById('eval-search');

    function fetchResults(page, instant) {
        if (currentRequest) currentRequest.abort();

        clearTimeout(debounceTimer);
        currentPage = page || 1;

        function doFetch() {
            const params = new URLSearchParams({
                search: searchInput.value,
                page: currentPage
            });

            bar.style.display = 'block';
            btnText.style.opacity = '0.5';
            spinner.style.display = 'flex';
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            const controller = new AbortController();
            currentRequest = controller;

            fetch(`${SEARCH_URL}?${params}`, { signal: controller.signal, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    wrapper.innerHTML = html;
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                    bar.style.display = 'none';
                    btnText.style.opacity = '1';
                    spinner.style.display = 'none';

                    bindPageButtons();
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        wrapper.style.opacity = '1';
                        wrapper.style.pointerEvents = 'auto';
                        bar.style.display = 'none';
                        btnText.style.opacity = '1';
                        spinner.style.display = 'none';
                    }
                });
        }

        if (instant) doFetch();
        else debounceTimer = setTimeout(doFetch, 320);
    }

    function bindPageButtons() {
        document.querySelectorAll('.eval-page-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                fetchResults(parseInt(this.dataset.page), true);
            });
        });
    }

    searchInput.addEventListener('input', function () {
        fetchResults(1, false);
    });

    form.addEventListener('submit', function () {
        fetchResults(1, true);
    });

    bindPageButtons();
})();
</script>
