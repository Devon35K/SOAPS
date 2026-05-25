{{-- AJAX partial: only the table rows + pagination --}}
<div class="data-table mb-6">
    <div class="table-header" style="grid-template-columns: 56px 1.2fr 2fr 1fr 1fr 1.1fr;">
        <div>Pic</div>
        <div>Student ID</div>
        <div>Name</div>
        <div>Sport</div>
        <div>Campus</div>
        <div>Status</div>
    </div>
    
    @forelse($users as $user)
        <div class="table-row" style="grid-template-columns: 56px 1.2fr 2fr 1fr 1fr 1.1fr;">
            <div data-label="Profile">
                @if($user->images->first())
                    <img src="data:{{ $user->images->first()->image_type }};base64,{{ base64_encode($user->images->first()->image) }}"
                         alt="Profile" style="width: 40px; height: 40px; border-radius: 4px; object-fit: cover;">
                @else
                    <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.08); color: var(--maroon); display: flex; align-items: center; justify-content: center;">
                        <i class='bx bx-user' style="font-size: 1.2rem;"></i>
                    </div>
                @endif
            </div>
            <div style="font-weight: 600; font-family: 'Barlow Condensed', sans-serif; letter-spacing: 0.5px;" data-label="Student ID">{{ $user->student_id }}</div>
            <div style="font-weight: 500; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; min-width: 0;" data-label="Name">{{ $user->full_name }}</div>
            <div data-label="Sport">{{ $user->sport ?? '—' }}</div>
            <div data-label="Campus">{{ $user->campus ?? '—' }}</div>
            <div data-label="Status">
                <span style="font-size: 0.68rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 10px; border-radius: 2px; font-family: 'Barlow Condensed', sans-serif; white-space: nowrap; {{ $user->status === 'undergraduate' ? 'background: #e0f2fe; color: #0284c7;' : 'background: #dcfce7; color: #166534;' }}">
                    {{ ucfirst($user->status) }}
                </span>
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center;">
            <div style="text-align: center; padding: 40px 20px; color: var(--text-muted); font-weight: 500;">
                No students found matching your search.
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

    <div id="sa-pagination" style="margin-top: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
        <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); margin: 0;">
            Showing <strong style="color: var(--maroon);">{{ $users->firstItem() }}</strong>
            &ndash;
            <strong style="color: var(--maroon);">{{ $users->lastItem() }}</strong>
            of <strong style="color: var(--maroon);">{{ $users->total() }}</strong> athletes
        </p>

        <div style="display: flex; align-items: center; gap: 4px; flex-wrap: wrap;">
            {{-- Previous --}}
            @if($users->onFirstPage())
                <span style="{{ $btnDisabled }}"><i class='bx bx-chevron-left'></i></span>
            @else
                <button data-page="{{ $currentPage - 1 }}" class="sa-page-btn" style="{{ $btnNav }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';"><i class='bx bx-chevron-left'></i></button>
            @endif

            @if($start > 1)
                <button data-page="1" class="sa-page-btn" style="{{ $btnBase }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';">1</button>
                @if($start > 2)<span style="{{ $ellipsis }}">…</span>@endif
            @endif

            @for($p = $start; $p <= $end; $p++)
                @if($p === $currentPage)
                    <span style="{{ $btnActive }}">{{ $p }}</span>
                @else
                    <button data-page="{{ $p }}" class="sa-page-btn" style="{{ $btnBase }}"
                            onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                            onmouseout="this.style.background='white';this.style.color='var(--maroon)';">{{ $p }}</button>
                @endif
            @endfor

            @if($end < $lastPage)
                @if($end < $lastPage - 1)<span style="{{ $ellipsis }}">…</span>@endif
                <button data-page="{{ $lastPage }}" class="sa-page-btn" style="{{ $btnBase }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';">{{ $lastPage }}</button>
            @endif

            {{-- Next --}}
            @if($users->hasMorePages())
                <button data-page="{{ $currentPage + 1 }}" class="sa-page-btn" style="{{ $btnNav }}"
                        onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                        onmouseout="this.style.background='white';this.style.color='var(--maroon)';"><i class='bx bx-chevron-right'></i></button>
            @else
                <span style="{{ $btnDisabled }}"><i class='bx bx-chevron-right'></i></span>
            @endif
        </div>
    </div>
@endif
