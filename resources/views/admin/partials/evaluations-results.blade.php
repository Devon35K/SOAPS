{{-- AJAX partial: evaluations table rows + pagination --}}
<div class="data-table mb-6">
    <div class="table-header" style="grid-template-columns: 2fr 2fr 1fr 1.5fr;">
        <div>Student Name</div>
        <div>Student ID</div>
        <div>Pending Submissions</div>
        <div>Actions</div>
    </div>

    @forelse($users as $user)
        @php
            $userId = $user->id;
            $submissions = $submissionsByUser[$userId] ?? collect();
            $pendingCount = $submissions->where('status', 'pending')->count();
        @endphp
        <div class="table-row" style="grid-template-columns: 2fr 2fr 1fr 1.5fr;">
            <div data-label="Student Name" style="display: flex; align-items: center; gap: 12px; font-weight: 600;">
                @if($user->images && $user->images->first())
                    <img src="data:{{ $user->images->first()->image_type }};base64,{{ base64_encode($user->images->first()->image) }}"
                         alt="Profile" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.08); color: var(--maroon); display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-user' style="font-size: 1.2rem;"></i>
                    </div>
                @endif
                {{ $user->full_name }}
            </div>
            <div data-label="Student ID">{{ $user->student_id }}</div>
            <div data-label="Pending Submissions">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; 
                    {{ $pendingCount > 0 ? 'background: #fef08a; color: #854d0e;' : 'background: #f1f5f9; color: #475569;' }}">
                    {{ $pendingCount }} Document{{ $pendingCount !== 1 ? 's' : '' }}
                </span>
            </div>
            <div data-label="Actions" style="display: flex; gap: 8px;">
                <button class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem;" onclick="openEvaluationModal({{ $user->id }})">
                    <i class='bx bx-search-alt'></i> Review Submissions
                </button>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center;">
            <div style="text-align: center; padding: 40px 20px; color: var(--text-muted); font-weight: 500;">
                No students found.
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
@if($users->hasPages())
    @php
        $paged       = $users->appends(request()->except('page'));
        $currentPage = $users->currentPage();
        $lastPage    = $users->lastPage();
        $window      = 2;
        $start       = max(1, $currentPage - $window);
        $end         = min($lastPage, $currentPage + $window);
        $btnBase     = "display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:0.9rem;text-decoration:none;border:2px solid rgba(122,20,40,0.18);background:white;color:var(--maroon);transition:all 0.18s;";
        $btnActive   = "display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:36px;padding:0 10px;font-family:'Barlow Condensed',sans-serif;font-weight:800;font-size:0.9rem;background:var(--maroon);color:var(--gold);border:2px solid var(--maroon);clip-path:polygon(0 0,calc(100% - 6px) 0,100% 6px,100% 100%,0 100%);";
        $btnDisabled = "display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;font-size:1rem;background:white;border:2px solid rgba(0,0,0,0.07);color:rgba(0,0,0,0.25);cursor:not-allowed;clip-path:polygon(0 0,calc(100% - 6px) 0,100% 6px,100% 100%,0 100%);";
        $btnNav      = "display:inline-flex;align-items:center;justify-content:center;width:36px;height:36px;font-size:1rem;background:white;border:2px solid rgba(122,20,40,0.2);color:var(--maroon);text-decoration:none;transition:all 0.2s;clip-path:polygon(0 0,calc(100% - 6px) 0,100% 6px,100% 100%,0 100%);";
        $ellipsis    = "display:inline-flex;align-items:center;justify-content:center;width:32px;height:36px;color:var(--text-muted);font-family:'Barlow Condensed',sans-serif;font-weight:700;font-size:1rem;";
    @endphp

    <div id="eval-pagination" style="margin-top: 24px; margin-bottom: 32px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin: 0;">
            Showing <strong style="color: var(--maroon);">{{ $users->firstItem() }}</strong>
            &ndash;
            <strong style="color: var(--maroon);">{{ $users->lastItem() }}</strong>
            of <strong style="color: var(--maroon);">{{ $users->total() }}</strong> students
        </p>

        <div style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
            @if($users->onFirstPage())
                <span style="{{ $btnDisabled }}"><i class='bx bx-chevron-left'></i></span>
            @else
                <button data-page="{{ $currentPage - 1 }}" class="eval-page-btn" style="{{ $btnNav }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';"><i class='bx bx-chevron-left'></i></button>
            @endif

            @if($start > 1)
                <button data-page="1" class="eval-page-btn" style="{{ $btnBase }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';">1</button>
                @if($start > 2)<span style="{{ $ellipsis }}">…</span>@endif
            @endif

            @for($p = $start; $p <= $end; $p++)
                @if($p === $currentPage)
                    <span style="{{ $btnActive }}">{{ $p }}</span>
                @else
                    <button data-page="{{ $p }}" class="eval-page-btn" style="{{ $btnBase }}"
                            onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                            onmouseout="this.style.background='white';this.style.color='var(--maroon)';">{{ $p }}</button>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)<span style="{{ $ellipsis }}">…</span>@endif
                <button data-page="{{ $lastPage }}" class="eval-page-btn" style="{{ $btnBase }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';">{{ $lastPage }}</button>
            @endif

            @if($users->hasMorePages())
                <button data-page="{{ $currentPage + 1 }}" class="eval-page-btn" style="{{ $btnNav }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';"><i class='bx bx-chevron-right'></i></button>
            @else
                <span style="{{ $btnDisabled }}"><i class='bx bx-chevron-right'></i></span>
            @endif
        </div>
    </div>
@endif
