@php
$sports = ['Athletics', 'Badminton', 'Basketball', 'Chess', 'Football', 'Sepak Takraw', 'Swimming', 'Table Tennis', 'Taekwondo', 'Tennis', 'Volleyball'];
$statuses = ['undergraduate', 'alumni'];
@endphp

<div>
    <!-- Search Form -->
    <form method="GET" action="{{ route('admin.student-athletes') }}" class="search-form">
        <input type="hidden" name="page" value="Student Athletes">
        
        <div class="search-grid">
            <div class="form-group">
                <label>Search</label>
                <input type="text" name="search" placeholder="ID or Name..."
                       value="{{ $searchTerm }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label>Sport</label>
                <select name="sport" class="form-control">
                    <option value="">All Sports</option>
                    @foreach($sports as $sportOption)
                        <option value="{{ $sportOption }}" {{ $sport === $sportOption ? 'selected' : '' }}>
                            {{ $sportOption }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Campus</label>
                <select name="campus" class="form-control">
                    <option value="">All Campuses</option>
                    <option value="Tagum" {{ $campus === 'Tagum' ? 'selected' : '' }}>Tagum</option>
                    <option value="Mabini" {{ $campus === 'Mabini' ? 'selected' : '' }}>Mabini</option>
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="">All Status</option>
                    @foreach($statuses as $statusOption)
                        <option value="{{ $statusOption }}" {{ $status === $statusOption ? 'selected' : '' }}>
                            {{ ucfirst($statusOption) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end;">
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class='bx bx-search'></i> Search
                </button>
            </div>
        </div>
    </form>

    <!-- Results Table -->
    <div class="data-table">
        <div class="table-header">
            <div style="grid-column: span 2">Profile</div>
            <div style="grid-column: span 2">Student ID</div>
            <div style="grid-column: span 3">Name</div>
            <div style="grid-column: span 2">Sport</div>
            <div style="grid-column: span 2">Campus</div>
            <div style="grid-column: span 1">Status</div>
        </div>

        <div>
            @forelse($users as $user)
                <div class="table-row">
                    <div style="grid-column: span 2" data-label="Profile">
                        @if($user->images->first())
                            <img src="data:{{ $user->images->first()->image_type }};base64,{{ base64_encode($user->images->first()->image) }}"
                                 alt="Profile" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                        @else
                            <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.08); color: var(--maroon); display: flex; align-items: center; justify-content: center;">
                                <i class='bx bx-user' style="font-size: 1.2rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div style="grid-column: span 2; font-weight: 500;" data-label="Student ID">{{ $user->student_id }}</div>
                    <div style="grid-column: span 3" data-label="Name">{{ $user->full_name }}</div>
                    <div style="grid-column: span 2" data-label="Sport">{{ $user->sport ?? 'N/A' }}</div>
                    <div style="grid-column: span 2" data-label="Campus">{{ $user->campus ?? 'N/A' }}</div>
                    <div style="grid-column: span 1" data-label="Status">
                        <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1.5px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; {{ $user->status === 'undergraduate' ? 'background: #e0f2fe; color: #0284c7;' : 'background: #dcfce7; color: #166534;' }}">
                            {{ ucfirst($user->status) }}
                        </span>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 40px 20px; color: var(--text-muted); font-weight: 500;">
                    No students found matching your search.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
        <div style="margin-top: 24px; display: flex; justify-content: center;">
            {{ $users->links() }}
        </div>
    @endif
</div>
