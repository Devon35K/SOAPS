@if($status && $action)
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
            <div>
                <div class="font-medium">{{ $request->full_name }}</div>
                <div class="text-sm" style="color: var(--text-muted);">{{ $request->email }}</div>
            </div>
            <div>{{ $request->student_id }}</div>
            <div>
                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                    {{ ucfirst($request->status) }}
                </span>
            </div>
            <div class="text-sm">{{ $request->request_date }}</div>
            <div class="flex gap-2">
                <button class="btn btn-primary" style="padding: 8px 14px; font-size: 0.75rem;" onclick="viewDocument({{ $request->id }})">
                    <i class='bx bx-file'></i> View
                </button>
                <form method="POST" action="{{ route('admin.approve-request') }}" class="inline">
                    @csrf
                    <input type="hidden" name="approval_id" value="{{ $request->id }}">
                    <button type="submit" class="btn btn-success" style="padding: 8px 14px; font-size: 0.75rem;" onclick="return confirm('Approve {{ $request->full_name }}?')">
                        <i class='bx bx-check'></i> Approve
                    </button>
                </form>
                <form method="POST" action="{{ route('admin.reject-request') }}" class="inline">
                    @csrf
                    <input type="hidden" name="approval_id" value="{{ $request->id }}">
                    <button type="submit" class="btn btn-danger" style="padding: 8px 14px; font-size: 0.75rem;" onclick="return confirm('Reject {{ $request->full_name }}?')">
                        <i class='bx bx-x'></i> Reject
                    </button>
                </form>
            </div>
        </div>
    @empty
        <div class="table-row text-center" style="grid-template-columns: 1fr; padding: 40px;">
            <div>
                <i class='bx bx-inbox text-4xl mb-3' style="color: var(--text-muted);"></i>
                <p>No pending approval requests</p>
            </div>
        </div>
    @endforelse
</div>

<!-- Document Viewer Modal -->
<div id="documentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl mx-4" style="max-height: 90vh;">
        <div class="p-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold" style="font-family: 'Barlow Condensed', sans-serif;">Document Preview</h3>
            <button onclick="closeDocumentModal()" class="text-gray-500 hover:text-gray-700">
                <i class='bx bx-x text-2xl'></i>
            </button>
        </div>
        <div id="documentPreview" class="p-4" style="height: 70vh; overflow: auto;">
            <!-- Document content -->
        </div>
        <div class="p-4 border-t flex justify-center gap-3">
            <a id="downloadLink" href="#" class="btn btn-primary">
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
    document.getElementById('documentModal').classList.remove('hidden');
}

function closeDocumentModal() {
    document.getElementById('documentModal').classList.add('hidden');
}
</script>
