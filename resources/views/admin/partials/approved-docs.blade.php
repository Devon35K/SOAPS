<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Approved Documents</h2>

<div class="search-form">
    <div class="search-grid">
        <div class="form-group">
            <label>Search Documents</label>
            <input type="text" class="form-control" placeholder="Search by student name or ID...">
        </div>
        <div class="form-group" style="display: flex; gap: 12px;">
            <button class="btn btn-primary"><i class='bx bx-search'></i> Search</button>
            <button class="btn" style="background: var(--text-muted); color: white;"><i class='bx bx-refresh'></i> Reset</button>
        </div>
    </div>
</div>

<div class="data-table">
    <div class="table-header" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 1.5fr;">
        <div>Student Athlete</div>
        <div>Document Type</div>
        <div>File Name</div>
        <div>Approval Date</div>
        <div>Actions</div>
    </div>

    @forelse($submissions as $submission)
        <div class="table-row" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 1.5fr;">
            <div data-label="Student Athlete">
                <div style="font-weight: 600;">{{ $submission->user->full_name }}</div>
                <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $submission->user->student_id }}</div>
            </div>
            <div data-label="Document Type">
                <span style="font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--maroon);">
                    {{ ucfirst($submission->document_type ?? 'Document') }}
                </span>
            </div>
            <div data-label="File Name" style="font-size: 0.85rem; color: var(--text-body);">
                <i class='bx bx-file' style="color: var(--maroon); margin-right: 4px;"></i>
                {{ basename($submission->file_path) }}
            </div>
            <div data-label="Approval Date" style="font-size: 0.85rem;">
                {{ $submission->updated_at->format('M d, Y') }}
            </div>
            <div data-label="Actions">
                <a href="{{ asset('storage/' . $submission->file_path) }}" target="_blank" class="btn btn-outline" style="padding: 8px 14px; font-size: 0.75rem; border: 1px solid var(--maroon); color: var(--maroon);">
                    <i class='bx bx-show'></i> View File
                </a>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center; padding: 48px;">
            <div style="color: var(--text-muted);">
                <i class='bx bx-folder-open' style="font-size: 2.5rem; margin-bottom: 12px; color: var(--text-muted); opacity: 0.5;"></i>
                <p style="font-weight: 500;">No approved documents found</p>
            </div>
        </div>
    @endforelse
</div>
