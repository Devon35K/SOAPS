@extends('user.layout', ['pageTitle' => 'Track ', 'pageTitleSpan' => 'Records'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>My <span>Transmission</span> History</h2>
        <p>Review the approval status of your past document submissions and evaluation forms.</p>
    </div>

    <div class="data-table">
        <div class="table-header">
            <div style="flex: 2;">Document Name</div>
            <div style="flex: 1;">Date Submitted</div>
            <div style="flex: 1;">Status</div>
            <div style="flex: 1;">Action</div>
        </div>
        
        <div class="table-row">
            <div style="flex: 2; display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-body);">
                <div style="width: 32px; height: 32px; background: rgba(16,185,129,0.1); color: #10B981; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><i class='bx bxs-file-pdf'></i></div>
                Medical_Certificate_2025.pdf
            </div>
            <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">Jan 15, 2026</div>
            <div style="flex: 1;">
                <span style="background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2); padding: 4px 10px; border-radius: 3px; font-family: 'Barlow Condensed'; font-weight: 700; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Approved</span>
            </div>
            <div style="flex: 1;">
                <button class="btn btn-outline" style="padding: 6px 14px; font-size: 0.75rem;"><i class='bx bx-show'></i> View</button>
            </div>
        </div>
        
        <div class="table-row">
            <div style="flex: 2; display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-body);">
                <div style="width: 32px; height: 32px; background: rgba(240,180,41,0.1); color: var(--gold-dark); border-radius: 4px; display: flex; align-items: center; justify-content: center;"><i class='bx bxs-file-png'></i></div>
                Parent_Consent_Signed.png
            </div>
            <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">Feb 02, 2026</div>
            <div style="flex: 1;">
                <span style="background: rgba(240,180,41,0.1); color: var(--gold-dark); border: 1px solid rgba(240,180,41,0.2); padding: 4px 10px; border-radius: 3px; font-family: 'Barlow Condensed'; font-weight: 700; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Pending</span>
            </div>
            <div style="flex: 1;">
                <button class="btn btn-outline" style="padding: 6px 14px; font-size: 0.75rem;"><i class='bx bx-show'></i> View</button>
            </div>
        </div>

        <div class="table-row">
            <div style="flex: 2; display: flex; align-items: center; gap: 12px; font-weight: 600; color: var(--text-body);">
                <div style="width: 32px; height: 32px; background: rgba(239,68,68,0.1); color: #EF4444; border-radius: 4px; display: flex; align-items: center; justify-content: center;"><i class='bx bxs-file-pdf'></i></div>
                Waiver_Form_Old.pdf
            </div>
            <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">Dec 10, 2025</div>
            <div style="flex: 1;">
                <span style="background: rgba(239,68,68,0.1); color: #B91C1C; border: 1px solid rgba(239,68,68,0.2); padding: 4px 10px; border-radius: 3px; font-family: 'Barlow Condensed'; font-weight: 700; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">Rejected</span>
            </div>
            <div style="flex: 1;">
                <button class="btn btn-outline" style="padding: 6px 14px; font-size: 0.75rem;"><i class='bx bx-show'></i> View</button>
            </div>
        </div>
    </div>
@endsection
