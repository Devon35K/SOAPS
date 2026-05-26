@extends('user.layout', ['pageTitle' => 'Achieve', 'pageTitleSpan' => 'ments'])

@section('content')
    <div class="welcome-card animate-down" style="margin-bottom: 24px;">
        <h2>My <span>Trophies</span> & Records</h2>
        <p>Keep track of your medals, tournament history, and points contributed to your campus leaderboard.</p>
    </div>

    <!-- Leaderboard Stats Card -->
    <div class="animate-up delay-1" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div class="action-card" style="border-bottom-color: var(--maroon);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">Total Points</h3>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--maroon);">{{ $totalPoints }}</p>
            </div>
            <div class="action-icon" style="background: rgba(122,20,40,0.1);">
                <i class='bx bx-star'></i>
            </div>
        </div>

        <div class="action-card" style="border-bottom-color: var(--gold);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">Campus Rank</h3>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--gold-dark);">#{{ $rank }}</p>
            </div>
            <div class="action-icon" style="background: rgba(240,180,41,0.15);">
                <i class='bx bx-medal' style="color: var(--gold-dark);"></i>
            </div>
        </div>
    </div>

    <div class="data-table animate-up delay-2">
        <div class="table-header">
            <div style="flex: 2;">Tournament Event / Achievement</div>
            <div style="flex: 1;">Placement</div>
            <div style="flex: 1;">Points</div>
            <div style="flex: 1;">Status</div>
            <div style="flex: 2;">Reviewed By / Remarks</div>
            <div style="flex: 1;">Date Logged</div>
        </div>
        
        @forelse($achievements as $achievement)
            <div class="table-row" style="{{ $achievement->status === 'Rejected' ? 'background: rgba(239,68,68,0.03); border-left: 3px solid #ef4444;' : '' }}">
                <div style="flex: 2; font-weight: 600; color: var(--maroon);">{{ $achievement->level_of_competition }} Level Achievement</div>
                <div style="flex: 1; font-weight: 700; color: var(--gold-dark);"><i class='bx bxs-medal'></i> {{ $achievement->performance }}</div>
                <div style="flex: 1; font-weight: 600;">
                    @if($achievement->status === 'Approved')
                        <span style="color: #059669;">+{{ $achievement->total_points }} pts</span>
                    @else
                        <span style="color: #B91C1C;">—</span>
                    @endif
                </div>
                <div style="flex: 1;">
                    @if($achievement->status === 'Approved')
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; font-family: 'Barlow Condensed'; background: #dcfce7; color: #166534; border-radius: 2px;">
                            <i class='bx bx-check-circle'></i> Approved
                        </span>
                    @else
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; font-family: 'Barlow Condensed'; background: #fee2e2; color: #991b1b; border-radius: 2px;">
                            <i class='bx bx-x-circle'></i> Rejected
                        </span>
                    @endif
                </div>
                <div style="flex: 2; font-size: 0.85rem;">
                    @if($achievement->approvedBy)
                        <span style="font-weight: 600; color: var(--text-body);">
                            {{ $achievement->status === 'Approved' ? 'Approved by' : 'Reviewed by' }}:
                            <span style="color: var(--maroon);">{{ $achievement->approvedBy->full_name }}</span>
                        </span>
                    @endif
                    @if($achievement->status === 'Rejected' && $achievement->rejection_reason)
                        <div style="margin-top: 4px; font-size: 0.8rem; color: #B91C1C; font-style: italic;">
                            <i class='bx bx-info-circle'></i> {{ $achievement->rejection_reason }}
                        </div>
                    @elseif($achievement->status === 'Rejected')
                        <div style="margin-top: 4px; font-size: 0.8rem; color: var(--text-muted); font-style: italic;">No reason provided.</div>
                    @endif
                </div>
                <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">{{ \Carbon\Carbon::parse($achievement->submission_date)->format('M d, Y') }}</div>
            </div>
        @empty
            <div class="table-row" style="justify-content: center; padding: 40px; color: var(--text-muted);">
                No achievements recorded yet.
            </div>
        @endforelse

        <div class="table-row" style="padding: 24px; justify-content: center; background: rgba(0,0,0,0.01);">
            <a href="{{ route('user.submissions') }}" class="btn btn-gold"><i class='bx bx-plus'></i> Log New Achievement</a>
        </div>
    </div>
@endsection
