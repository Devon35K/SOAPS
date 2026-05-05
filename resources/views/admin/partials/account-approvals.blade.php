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
        <div class="table-row" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 2fr;">
            <div data-label="Name">
                <div style="font-weight: 600;">{{ $request->full_name }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $request->email }}</div>
            </div>
            <div data-label="Student ID">{{ $request->student_id }}</div>
            <div data-label="Status">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; background: #fef08a; color: #854d0e;">
                    {{ ucfirst($request->status) }}
                </span>
            </div>
            <div data-label="Request Date" style="font-size: 0.85rem;">{{ $request->request_date }}</div>
            <div data-label="Actions" style="display: flex; gap: 8px; flex-wrap: wrap;">
                <button class="btn btn-primary" style="padding: 8px 14px; font-size: 0.75rem;" onclick="viewDocument({{ $request->id }})">
                    <i class='bx bx-file'></i> View
                </button>
                <form method="POST" action="{{ route('admin.approve-request') }}" style="margin: 0; display: inline;">
                    @csrf
                    <input type="hidden" name="approval_id" value="{{ $request->id }}">
                    <button type="submit" class="btn btn-success" style="padding: 8px 14px; font-size: 0.75rem;" onclick="return confirm('Approve {{ $request->full_name }}?')">
                        <i class='bx bx-check'></i> Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reject-request') }}" style="margin: 0; display: inline;">
                    @csrf
                    <input type="hidden" name="approval_id" value="{{ $request->id }}">
                    <button type="submit" class="btn btn-danger" style="padding: 8px 14px; font-size: 0.75rem;" onclick="return confirm('Reject {{ $request->full_name }}?')">
                        <i class='bx bx-x'></i> Reject
                    </button>
                </form>
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

<!-- Document Viewer Modal -->
<div id="documentModal" style="position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 100;">
    <div style="background: white; border-top: 4px solid var(--gold); width: 90%; max-width: 900px; max-height: 90vh; display: flex; flex-direction: column; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);">
        <div style="padding: 20px 24px; border-bottom: 1px solid rgba(0,0,0,0.06); display: flex; justify-content: space-between; align-items: center;">
            <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; font-weight: 800; text-transform: uppercase; color: var(--charcoal);">Document Preview</h3>
            <button onclick="closeDocumentModal()" style="background: none; border: none; font-size: 1.5rem; color: var(--text-muted); cursor: pointer;"><i class='bx bx-x'></i></button>
        </div>
        <div id="documentPreview" style="padding: 24px; flex: 1; overflow-y: auto; background: var(--offwhite); display: flex; align-items: center; justify-content: center; min-height: 400px;">
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
function viewDocument(requestId) {
    const modal = document.getElementById('documentModal');
    const preview = document.getElementById('documentPreview');
    const downloadLink = document.getElementById('downloadLink');
    
    modal.style.display = 'flex';
    preview.innerHTML = '<p style="color: var(--text-muted); font-family: Barlow Condensed; font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">Loading Preview...</p>';
    
    const url = `/admin/approval-document/${requestId}`;
    
    // Set download link
    downloadLink.href = url;
    
    // Attempt to preview based on common types
    preview.innerHTML = `
        <iframe src="${url}" style="width: 100%; height: 600px; border: none; background: white; border-radius: 4px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);"></iframe>
    `;
}

function closeDocumentModal() {
    const modal = document.getElementById('documentModal');
    const preview = document.getElementById('documentPreview');
    modal.style.display = 'none';
    preview.innerHTML = ''; // Clear iframe to stop loading
}
</script>
