@php
$sports = $sports ?? [];
@endphp

<style>
    @keyframes ach-spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
    @keyframes ach-shimmer { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
    @keyframes ach-fade-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    #ach-results-wrapper { animation: ach-fade-in 0.2s ease; }
</style>

<div class="search-form">
    <form id="ach-search-form" class="search-grid" onsubmit="return false;">

        <div class="form-group">
            <label>Search Athlete</label>
            <input type="text" id="ach-search" name="search" value="{{ $search }}" placeholder="Enter athlete name" class="form-control">
        </div>

        <div class="form-group">
            <label>Status</label>
            <select id="ach-status" name="status" class="form-control">
                <option value="">All</option>
                <option value="undergraduate" {{ $status === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                <option value="alumni" {{ $status === 'alumni' ? 'selected' : '' }}>Alumni</option>
            </select>
        </div>

        <div class="form-group">
            <label>Sport</label>
            <select id="ach-sport" name="sport" class="form-control">
                <option value="">All</option>
                @foreach($sports as $sportOption)
                    <option value="{{ $sportOption }}" {{ $sport === $sportOption ? 'selected' : '' }}>{{ $sportOption }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group" style="display: flex; align-items: flex-end;">
            <button type="submit" id="ach-submit-btn" class="btn btn-primary" style="width: 100%; position: relative;">
                <span id="ach-btn-text"><i class='bx bx-filter'></i> Apply Filters</span>
                <span id="ach-btn-spinner" style="display:none; position: absolute; inset: 0; align-items: center; justify-content: center;">
                    <i class='bx bx-loader-alt' style="animation: ach-spin 0.8s linear infinite;"></i>
                </span>
            </button>
        </div>
    </form>

    <div id="ach-typing-bar" style="display:none; margin-top: 12px; height: 2px; border-radius: 1px; background: linear-gradient(90deg, var(--maroon), var(--gold), var(--maroon)); background-size: 200% 100%; animation: ach-shimmer 1.2s infinite;"></div>
</div>

<!-- Results Wrapper -->
<div id="ach-results-wrapper">
    @include('admin.partials.achievements-results', ['achievements' => $achievements, 'leaderboard' => $leaderboard])
</div>

<!-- Achievement Document Preview Modal (moved to body via JS) -->
<div id="achievementDocModal" style="position: fixed; inset: 0; background: rgba(15,12,12,0.85); backdrop-filter: blur(5px); display: none; align-items: center; justify-content: center; z-index: 999999;">
    <div style="background: white; width: 95%; max-width: 1200px; height: 90vh; position: relative; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%);">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 28px; background: #fff; border-bottom: 2px solid #f1f5f9;">
            <div style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 8px; height: 24px; background: var(--maroon);"></div>
                <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.4rem; color: var(--charcoal); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Achievement Evidence</h3>
            </div>
            <button onclick="closeAchievementDoc()" style="background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 4px; font-size: 1.5rem; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#f1f5f9'">
                <i class='bx bx-x'></i>
            </button>
        </div>
        <div id="achievementDocContent" style="flex: 1; overflow: hidden; background: #333; display: flex; align-items: center; justify-content: center;"></div>
    </div>
</div>

<script>
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
        img.style.cssText = 'width:100%;max-width:800px;height:auto;flex-shrink:0;display:block;box-shadow:0 20px 25px -5px rgba(0,0,0,.5);border:1px solid rgba(255,255,255,.1);border-radius:4px;margin-bottom:40px;';
        container.style.background = '#1a1a1a';
        container.style.cssText += 'padding:40px 20px;overflow-y:auto;display:flex;flex-direction:column;align-items:center;justify-content:flex-start;';
        container.innerHTML = '';
        container.appendChild(img);
    } else {
        const iframe = document.createElement('iframe');
        iframe.src = url;
        iframe.style.cssText = 'width:100%;height:100%;border:none;';
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

(function() {
    const SEARCH_URL = '{{ route('admin.achievements.search') }}';
    let debounceTimer = null;
    let currentRequest = null;

    const form    = document.getElementById('ach-search-form');
    const wrapper = document.getElementById('ach-results-wrapper');
    const bar     = document.getElementById('ach-typing-bar');
    const btnText = document.getElementById('ach-btn-text');
    const spinner = document.getElementById('ach-btn-spinner');
    const searchInput = document.getElementById('ach-search');
    const statusSel   = document.getElementById('ach-status');
    const sportSel    = document.getElementById('ach-sport');

    function fetchResults(instant) {
        if (currentRequest) currentRequest.abort();
        clearTimeout(debounceTimer);

        function doFetch() {
            const params = new URLSearchParams({
                search: searchInput.value,
                status: statusSel.value,
                sport:  sportSel.value,
            });

            bar.style.display = 'block';
            btnText.style.opacity = '0.5';
            spinner.style.display = 'flex';
            wrapper.style.opacity = '0.5';
            wrapper.style.pointerEvents = 'none';

            const controller = new AbortController();
            currentRequest = controller;

            fetch(`${SEARCH_URL}?${params}`, { signal: controller.signal, headers: { 'X-Requested-With': 'XMLHttpRequest' } })
                .then(res => res.text())
                .then(html => {
                    wrapper.innerHTML = html;
                    wrapper.style.opacity = '1';
                    wrapper.style.pointerEvents = 'auto';
                    bar.style.display = 'none';
                    btnText.style.opacity = '1';
                    spinner.style.display = 'none';
                })
                .catch(err => {
                    if (err.name !== 'AbortError') {
                        wrapper.style.opacity = '1';
                        wrapper.style.pointerEvents = 'auto';
                        bar.style.display = 'none';
                        btnText.style.opacity = '1';
                        spinner.style.display = 'none';
                    }
                });
        }

        if (instant) doFetch();
        else debounceTimer = setTimeout(doFetch, 320);
    }

    searchInput.addEventListener('input', () => fetchResults(false));
    statusSel.addEventListener('change', () => fetchResults(true));
    sportSel.addEventListener('change', () => fetchResults(true));
    form.addEventListener('submit', () => fetchResults(true));
})();
</script>
