@php
$sports = ['Basketball', 'Volleyball', 'Football', 'Swimming', 'Track and Field', 'Tennis', 'Table Tennis', 'Badminton'];
@endphp

<div class="search-form">
    <form method="GET" action="{{ route('admin.achievements') }}" class="search-grid">
        <input type="hidden" name="page" value="Achievement">

        <div class="form-group">
            <label>Search Athlete</label>
            <input type="text" name="search" value="{{ $search }}" placeholder="Enter athlete name" class="form-control">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="">All</option>
                <option value="undergraduate" {{ $status === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                <option value="alumni" {{ $status === 'alumni' ? 'selected' : '' }}>Alumni</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sport</label>
            <select name="sport" class="form-control">
                <option value="">All</option>
                @foreach($sports as $sportOption)
                    <option value="{{ $sportOption }}" {{ $sport === $sportOption ? 'selected' : '' }}>{{ $sportOption }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" class="btn btn-primary" style="width: 100%;">
                <i class='bx bx-filter'></i> Apply Filters
            </button>
        </div>
    </form>
</div>

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
                    // We need to get the extension from the submission if possible, 
                    // or just pass a generic view if we can't.
                    // For now, let's try to pass the extension if available.
                    $ext = 'pdf'; // Default
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
                
                @if($achievement->status === 'Pending')
                    <button class="btn btn-success" style="padding: 6px 12px; font-size: 0.7rem;">
                        <i class='bx bx-check'></i>
                    </button>
                    <button class="btn btn-danger" style="padding: 6px 12px; font-size: 0.7rem;">
                        <i class='bx bx-x'></i>
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

<!-- Achievement Document Preview Modal (Moved to body via JS) -->
<div id="achievementDocModal" style="position: fixed; inset: 0; background: rgba(15, 12, 12, 0.85); backdrop-filter: blur(5px); display: none; align-items: center; justify-content: center; z-index: 999999;">
    <div style="background: white; width: 95%; max-width: 1200px; height: 90vh; position: relative; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%);">
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 28px; background: #fff; border-bottom: 2px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 8px; height: 24px; background: var(--maroon);"></div>
                <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.4rem; color: var(--charcoal); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Achievement Evidence</h3>
            </div>
            <button onclick="closeAchievementDoc()" style="background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 4px; font-size: 1.5rem; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#f1f5f9'">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <!-- Body -->
        <div id="achievementDocContent" style="flex: 1; overflow: hidden; background: #333; display: flex; align-items: center; justify-content: center;">
            <!-- Content will be injected here -->
        </div>
    </div>
</div>

<script>
// Move modal to body to prevent z-index/layout issues with parent containers
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('achievementDocModal');
    if (modal) document.body.appendChild(modal);
});

function openAchievementDoc(subId, extension) {
    const modal = document.getElementById('achievementDocModal');
    const container = document.getElementById('achievementDocContent');
    
    container.innerHTML = '<div style="color: white; font-family: Barlow;">Loading evidence...</div>';
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';

    const url = `/admin/submission-view/${subId}`;
    const ext = extension.toLowerCase();

    if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
        const img = document.createElement('img');
        img.src = url;
        img.style.width = '100%';
        img.style.maxWidth = '800px';
        img.style.height = 'auto';
        img.style.flexShrink = '0';
        img.style.display = 'block';
        img.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.5)';
        img.style.border = '1px solid rgba(255,255,255,0.1)';
        img.style.borderRadius = '4px';
        img.style.marginBottom = '40px';
        
        container.style.background = '#1a1a1a';
        container.style.padding = '40px 20px';
        container.style.overflowY = 'auto';
        container.style.display = 'flex';
        container.style.flexDirection = 'column';
        container.style.alignItems = 'center';
        container.style.justifyContent = 'flex-start';
        container.innerHTML = '';
        container.appendChild(img);
    } else {
        const iframe = document.createElement('iframe');
        iframe.src = url;
        iframe.style.width = '100%';
        iframe.style.height = '100%';
        iframe.style.border = 'none';
        container.style.background = '#333';
        container.innerHTML = '';
        container.appendChild(iframe);
    }
}

function closeAchievementDoc() {
    document.getElementById('achievementDocModal').style.display = 'none';
    document.getElementById('achievementDocContent').innerHTML = '';
    document.body.style.overflow = 'auto';
}
</script>
