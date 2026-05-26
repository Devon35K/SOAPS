{{-- AJAX partial: leaderboard + achievements tables --}}

<!-- Leaderboard Section -->
<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Leaderboard</h2>
<div class="data-table mb-6" style="margin-bottom: 32px;">
    <div class="table-header" style="grid-template-columns: 1fr 2fr 1fr 1fr;">
        <div>Profile</div>
        <div>Athlete Name</div>
        <div>Total Points</div>
        <div>Rank</div>
    </div>
    @forelse($leaderboard as $index => $athlete)
        <div class="table-row" style="grid-template-columns: 1fr 2fr 1fr 1fr;">
            <div data-label="Profile">
                @if($athlete->user && $athlete->user->images && $athlete->user->images->first())
                    <img src="data:{{ $athlete->user->images->first()->image_type }};base64,{{ base64_encode($athlete->user->images->first()->image) }}"
                         alt="Profile" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover; border: 1px solid var(--gold);">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.08); color: var(--maroon); display: flex; align-items: center; justify-content: center; border: 1px solid rgba(122,20,40,.2);">
                        <i class='bx bx-user' style="font-size: 1.2rem;"></i>
                    </div>
                @endif
            </div>
            <div data-label="Athlete Name" style="font-weight: 600;">{{ $athlete->athlete_name ?? 'N/A' }}</div>
            <div data-label="Total Points" style="font-family: 'Barlow Condensed'; font-weight: 700; font-size: 1.1rem; color: var(--maroon);">{{ $athlete->total_points ?? 0 }}</div>
            <div data-label="Rank">
                <span style="background: var(--gold); color: var(--maroon-dark); padding: 2px 8px; font-weight: 800; border-radius: 2px; font-family: 'Barlow Condensed'; font-size: 0.85rem;">#{{ $index + 1 }}</span>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center; padding: 32px;">
            <div style="color: var(--text-muted); font-weight: 500;">No leaderboard data available</div>
        </div>
    @endforelse
</div>

<!-- Achievements Section -->
<h2 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); margin-bottom: 16px; text-transform: uppercase;">Achievements List</h2>
<div class="data-table">
    <div class="table-header" style="grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1.5fr;">
        <div>Athlete</div>
        <div>Level</div>
        <div>Performance</div>
        <div>Points</div>
        <div>Date</div>
        <div>Status</div>
        <div>Actions</div>
    </div>
    @forelse($achievements as $achievement)
        <div class="table-row" style="grid-template-columns: 2fr 1fr 1fr 1fr 1fr 1fr 1.5fr;">
            <div data-label="Athlete" style="font-weight: 600;">{{ $achievement->athlete_name ?? 'N/A' }}</div>
            <div data-label="Level">{{ $achievement->level_of_competition ?? 'N/A' }}</div>
            <div data-label="Performance">{{ $achievement->performance ?? 'N/A' }}</div>
            <div data-label="Points">{{ $achievement->total_points ?? 0 }}</div>
            <div data-label="Date">{{ $achievement->submission_date ?? 'N/A' }}</div>
            <div data-label="Status">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; 
                    {{ $achievement->status === 'Approved' ? 'background: #dcfce7; color: #166534;' : ($achievement->status === 'Rejected' ? 'background: #fee2e2; color: #991b1b;' : 'background: #fef08a; color: #854d0e;') }}">
                    {{ $achievement->status ?? 'Pending' }}
                </span>
            </div>
            <div data-label="Actions" style="display: flex; gap: 8px;">
                @php
                    $subId = $achievement->documents['submission_id'] ?? null;
                    $ext = 'pdf';
                    if ($subId) {
                        $sub = \App\Models\Submission::find($subId);
                        if ($sub) {
                            $ext = pathinfo($sub->file_name, PATHINFO_EXTENSION);
                        }
                    }
                @endphp
                @if($subId)
                    <button onclick="openAchievementDoc({{ $subId }}, '{{ $ext }}')" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.7rem;">
                        <i class='bx bx-show'></i>
                    </button>
                @else
                    <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.7rem; opacity: 0.5; cursor: not-allowed;" title="No document linked">
                        <i class='bx bx-show'></i>
                    </button>
                @endif
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center;">
            <div style="color: var(--text-muted); font-weight: 500;">No achievements found</div>
        </div>
    @endforelse
</div>
