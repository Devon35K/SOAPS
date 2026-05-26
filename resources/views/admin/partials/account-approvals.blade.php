@if(isset($status) && isset($action) && $status && $action)
    @if($status === 'success')
        <div class="alert alert-success">
            <i class='bx bx-check-circle'></i>
            @if($action === 'approve')
                Request approved successfully! An email has been sent to the user.
            @else
                Request rejected successfully! The user has been notified.
            @endif
        </div>
    @elseif($status === 'error')
        <div class="alert alert-error">
            <i class='bx bx-error-circle'></i>
            Failed to {{ $action }} request. Please try again.
        </div>
    @endif
@endif

<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Account Approvals</h2>
<div class="data-table">
    <div class="table-header" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 2fr;">
        <div>Name</div>
        <div>Student ID</div>
        <div>Status</div>
        <div>Request Date</div>
        <div>Actions</div>
    </div>

    @forelse($requests as $request)
        <div class="table-row" id="request-row-{{ $request->id }}" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 2fr;">
            <div data-label="Name">
                <div style="font-weight: 600;">{{ $request->full_name }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->email }}</div>
            </div>
            <div data-label="Student ID">{{ $request->student_id }}</div>
            <div data-label="Status">
                <span id="status-badge-{{ $request->id }}" style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; background: #fef08a; color: #854d0e;">
                    {{ ucfirst($request->status) }}
                </span>
            </div>
            <div data-label="Request Date" style="font-size: 0.85rem;">{{ $request->request_date }}</div>
            <div data-label="Actions" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button class="btn btn-primary" style="padding: 8px 14px; font-size: 0.75rem;" onclick="viewDocument({{ $request->id }}, '{{ $request->file_type }}')">
                    <i class='bx bx-file'></i> View
                </button>
                
                <button onclick="handleApproval({{ $request->id }}, 'approve')" id="btn-approve-{{ $request->id }}" class="btn btn-success" style="padding: 8px 14px; font-size: 0.75rem;">
                    <i class='bx bx-check'></i> Approve
                </button>

                <button onclick="openRejectModal({{ $request->id }}, '{{ addslashes($request->full_name) }}')" id="btn-reject-{{ $request->id }}" class="btn btn-danger" style="padding: 8px 14px; font-size: 0.75rem;">
                    <i class='bx bx-x'></i> Reject
                </button>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center; padding: 48px;">
            <div style="color: var(--text-muted);">
                <i class='bx bx-inbox' style="font-size: 2.5rem; margin-bottom: 12px; color: var(--text-muted); opacity: 0.5;"></i>
                <p style="font-weight: 500;">No pending approval requests</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Rejection Reason Modal -->
<div id="rejectReasonModal" style="position: fixed; inset: 0; background: rgba(28,20,16,.72); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 10000;">
    <div style="background: white; width: 92%; max-width: 480px; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); box-shadow: 0 25px 50px -12px rgba(0,0,0,.5); display: flex; flex-direction: column;">
        <!-- Header -->
        <div style="display: flex; align-items: center; gap: 12px; padding: 20px 24px; border-bottom: 2px solid #fee2e2; background: #fff5f5;">
            <div style="width: 8px; height: 28px; background: #dc2626; flex-shrink: 0;"></div>
            <div style="flex: 1;">
                <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.3rem; color: #991b1b; text-transform: uppercase; letter-spacing: 0.5px; margin: 0;">Reject Account Request</h3>
                <p id="reject-modal-name" style="font-size: 0.82rem; color: #64748b; margin: 2px 0 0;"></p>
            </div>
            <button onclick="closeRejectModal()" style="background: none; border: none; font-size: 1.5rem; color: #94a3b8; cursor: pointer; line-height: 1;"><i class='bx bx-x'></i></button>
        </div>
        <!-- Body -->
        <div style="padding: 24px;">
            <label style="display: block; font-size: 0.7rem; text-transform: uppercase; font-weight: 800; color: #991b1b; letter-spacing: 1.2px; margin-bottom: 10px;">
                <i class='bx bx-error-circle'></i> Reason for Rejection <span style="color: #94a3b8; font-weight: 500; text-transform: none;">(required — sent to applicant by email)</span>
            </label>
            <textarea id="reject-modal-reason" rows="4" placeholder="e.g. Incomplete documentation, invalid student ID, document is unclear..." style="width: 100%; padding: 12px 14px; border: 1.5px solid #fca5a5; border-radius: 4px; font-family: 'Barlow', sans-serif; font-size: 0.9rem; color: #1e293b; resize: vertical; outline: none; transition: border-color 0.2s;"
                onfocus="this.style.borderColor='#dc2626'" onblur="this.style.borderColor='#fca5a5'"></textarea>
            <p id="reject-modal-error" style="display:none; color: #dc2626; font-size: 0.78rem; margin-top: 6px; font-weight: 600;"><i class='bx bx-error-circle'></i> Please enter a reason before rejecting.</p>
        </div>
        <!-- Footer -->
        <div style="display: flex; justify-content: flex-end; gap: 10px; padding: 16px 24px; border-top: 1px solid #f1f5f9;">
            <button onclick="closeRejectModal()" class="btn" style="background: #f1f5f9; color: #475569; padding: 9px 20px;">Cancel</button>
            <button onclick="submitRejectModal()" id="reject-modal-confirm-btn" class="btn" style="background: #dc2626; color: white; padding: 9px 24px; font-weight: 700;">
                <i class='bx bx-x-circle'></i> Confirm Rejection
            </button>
        </div>
    </div>
</div>

<!-- Document Viewer Modal -->
<div id="documentModal" style="position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 9999;">
    <div style="background: white; border-top: 4px solid var(--gold); width: 90%; max-width: 900px; max-height: 90vh; display: flex; flex-direction: column; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; font-weight: 800; text-transform: uppercase; color: var(--charcoal);">Document Preview</h3>
            <button onclick="closeDocumentModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i class='bx bx-x'></i></button>
        </div>
        <div id="documentPreview" style="padding: 24px; flex: 1; overflow-y: auto; background: var(--offwhite); display: flex; flex-direction: column; align-items: center; justify-content: flex-start; min-height: 400px;">
            <p style="color: var(--text-muted);">Loading document...</p>
        </div>
        <div style="padding: 20px 24px; border-top: 1px solid rgba(0,0,0,0.06); display: flex; justify-content: flex-end; gap: 12px;">
            <a id="downloadLink" href="#" class="btn btn-primary" download>
                <i class='bx bx-download'></i> Download
            </a>
            <button onclick="closeDocumentModal()" class="btn" style="background: var(--text-muted); color: white;">
                <i class='bx bx-x'></i> Close
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    ['documentModal', 'rejectReasonModal'].forEach(id => {
        const el = document.getElementById(id);
        if (el) document.body.appendChild(el);
    });
});

let _rejectTargetId = null;

function openRejectModal(requestId, fullName) {
    _rejectTargetId = requestId;
    document.getElementById('reject-modal-name').textContent = 'Applicant: ' + fullName;
    document.getElementById('reject-modal-reason').value = '';
    document.getElementById('reject-modal-reason').style.borderColor = '#fca5a5';
    document.getElementById('reject-modal-error').style.display = 'none';
    document.getElementById('rejectReasonModal').style.display = 'flex';
    setTimeout(() => document.getElementById('reject-modal-reason').focus(), 80);
}

function closeRejectModal() {
    document.getElementById('rejectReasonModal').style.display = 'none';
    _rejectTargetId = null;
}

function submitRejectModal() {
    const reason = document.getElementById('reject-modal-reason').value.trim();
    if (!reason) {
        document.getElementById('reject-modal-reason').style.borderColor = '#dc2626';
        document.getElementById('reject-modal-error').style.display = 'block';
        document.getElementById('reject-modal-reason').focus();
        return;
    }
    const targetId = _rejectTargetId;
    closeRejectModal();
    handleApproval(targetId, 'reject', reason);
}

function viewDocument(requestId, fileType = '') {
    const modal = document.getElementById('documentModal');
    const preview = document.getElementById('documentPreview');
    const downloadLink = document.getElementById('downloadLink');
    
    modal.style.display = 'flex';
    preview.innerHTML = '<p style="color: var(--text-muted); font-family: Barlow Condensed; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Loading Preview...</p>';
    
    const url = `/admin/approval-document/${requestId}`;
    
    // Set download link
    downloadLink.href = url;
    
    // Attempt to preview based on common types
    if (fileType.startsWith('image/')) {
        preview.innerHTML = `
            <img src="${url}" style="max-width: 100%; height: auto; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
        `;
    } else {
        preview.innerHTML = `
            <iframe src="${url}" style="width: 100%; height: 600px; border: none; background: white; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></iframe>
        `;
    }
}

function handleApproval(requestId, action, rejectionReason) {
    if (action === 'approve' && !confirm('Are you sure you want to approve this request?')) return;

    const row    = document.getElementById(`request-row-${requestId}`);
    const badge  = document.getElementById(`status-badge-${requestId}`);
    const approveBtn = document.getElementById(`btn-approve-${requestId}`);
    const rejectBtn  = document.getElementById(`btn-reject-${requestId}`);

    // Disable both action buttons and show spinner on the acting one
    if (approveBtn) { approveBtn.disabled = true; }
    if (rejectBtn)  { rejectBtn.disabled = true; }
    if (action === 'approve' && approveBtn) {
        approveBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
    }
    if (action === 'reject' && rejectBtn) {
        rejectBtn.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i>';
    }

    const url = action === 'approve' ? '{{ route("admin.approve-request") }}' : '{{ route("admin.reject-request") }}';
    const payload = { approval_id: requestId };
    if (rejectionReason) payload.rejection_reason = rejectionReason;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            badge.style.background = action === 'approve' ? '#dcfce7' : '#fee2e2';
            badge.style.color      = action === 'approve' ? '#166534' : '#991b1b';
            badge.innerText        = action === 'approve' ? 'Approved' : 'Rejected';
            setTimeout(() => {
                row.style.opacity    = '0';
                row.style.transform  = 'translateX(20px)';
                row.style.transition = 'all 0.5s ease';
                setTimeout(() => {
                    row.remove();
                    if (!document.querySelector('[id^="request-row-"]')) location.reload();
                }, 500);
            }, 800);
        } else {
            alert('Error: ' + (result.message || 'Action failed'));
            if (approveBtn) { approveBtn.disabled = false; approveBtn.innerHTML = '<i class="bx bx-check"></i> Approve'; }
            if (rejectBtn)  { rejectBtn.disabled  = false; rejectBtn.innerHTML  = '<i class="bx bx-x"></i> Reject'; }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Network/server error: ' + error.message);
        if (approveBtn) { approveBtn.disabled = false; approveBtn.innerHTML = '<i class="bx bx-check"></i> Approve'; }
        if (rejectBtn)  { rejectBtn.disabled  = false; rejectBtn.innerHTML  = '<i class="bx bx-x"></i> Reject'; }
    });
}

function closeDocumentModal() {
    const modal = document.getElementById('documentModal');
    const preview = document.getElementById('documentPreview');
    modal.style.display = 'none';
    preview.innerHTML = ''; // Clear iframe to stop loading
}
</script>
