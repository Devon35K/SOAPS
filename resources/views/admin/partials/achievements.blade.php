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

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class='bx bx-filter'></i> Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Leaderboard Section -->
<div class="data-table mb-6">
    <div class="table-header" style="grid-template-columns: 1fr 1fr 1fr;">
        <div>Athlete Name</div>
        <div>Total Points</div>
        <div>Rank</div>
    </div>
    @forelse($leaderboard as $index => $athlete)
        <div class="table-row" style="grid-template-columns: 1fr 1fr 1fr;">
            <div>{{ $athlete->athlete_name ?? 'N/A' }}</div>
            <div>{{ $athlete->total_points ?? 0 }}</div>
            <div>{{ $index + 1 }}</div>
        </div>
    @empty
        <div class="table-row text-center" style="grid-template-columns: 1fr;">
            <div>No leaderboard data available</div>
        </div>
    @endforelse
</div>

<!-- Achievements Section -->
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
            <div>{{ $achievement->athlete_name ?? 'N/A' }}</div>
            <div>{{ $achievement->level_of_competition ?? 'N/A' }}</div>
            <div>{{ $achievement->performance ?? 'N/A' }}</div>
            <div>{{ $achievement->total_points ?? 0 }}</div>
            <div>{{ $achievement->submission_date ?? 'N/A' }}</div>
            <div>
                <span class="px-2 py-1 rounded text-xs {{ $achievement->status === 'Approved' ? 'bg-green-100 text-green-800' : ($achievement->status === 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                    {{ $achievement->status ?? 'Pending' }}
                </span>
            </div>
            <div class="flex gap-2">
                <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.7rem;">
                    <i class='bx bx-show'></i> View
                </button>
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
        <div class="table-row text-center" style="grid-template-columns: 1fr;">
            <div>No achievements found</div>
        </div>
    @endforelse
</div>
