<div>
    <!-- Search Form -->
    <form id="sa-search-form" class="search-form" onsubmit="return false;">
        <div class="search-grid">
            <div class="form-group">
                <label>Search</label>
                <input type="text" id="sa-search" name="search" placeholder="ID or Name..."
                       value="{{ $searchTerm }}" class="form-control"
                       style="transition: border-color 0.2s, box-shadow 0.2s;">
            </div>

            <div class="form-group">
                <label>Sport</label>
                <select id="sa-sport" name="sport" class="form-control">
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
                <select id="sa-campus" name="campus" class="form-control">
                    <option value="">All Campuses</option>
                    @foreach($campuses as $campusOption)
                        <option value="{{ $campusOption }}" {{ $campus === $campusOption ? 'selected' : '' }}>
                            {{ $campusOption }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Status</label>
                <select id="sa-status" name="status" class="form-control">
                    <option value="">All Status</option>
                    <option value="undergraduate" {{ $status === 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                    <option value="alumni" {{ $status === 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; align-items: flex-end; gap: 8px;">
                <button type="submit" id="sa-search-btn" class="btn btn-primary" style="width: 100%; position: relative;">
                    <span id="sa-btn-text"><i class='bx bx-search'></i> Search</span>
                    <span id="sa-btn-spinner" style="display:none; position: absolute; inset: 0; display: none; align-items: center; justify-content: center;">
                        <i class='bx bx-loader-alt' style="animation: spin 0.8s linear infinite;"></i>
                    </span>
                </button>
            </div>
        </div>

        <!-- Live typing indicator -->
        <div id="sa-typing-bar" style="display:none; margin-top: 12px; height: 2px; border-radius: 1px; background: linear-gradient(90deg, var(--maroon), var(--gold), var(--maroon)); background-size: 200% 100%; animation: shimmer 1.2s infinite;"></div>
    </form>

    <style>
        @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
        @keyframes shimmer { 0% { background-position: 100% 0; } 100% { background-position: -100% 0; } }
        @keyframes sa-fade-in { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
        #sa-results-wrapper { animation: sa-fade-in 0.2s ease; }
    </style>

    <!-- Results Table -->
    <div id="sa-results-wrapper">
        @include('admin.partials.student-athletes-results', ['users' => $users])
    </div>
</div>

<script>
(function () {
    const SEARCH_URL = '{{ route('admin.student-athletes.search') }}';
    let debounceTimer = null;
    let currentRequest = null;
    let currentPage = 1;

    const form     = document.getElementById('sa-search-form');
    const wrapper  = document.getElementById('sa-results-wrapper');
    const bar      = document.getElementById('sa-typing-bar');
    const btnText  = document.getElementById('sa-btn-text');
    const spinner  = document.getElementById('sa-btn-spinner');
    const searchInput = document.getElementById('sa-search');

    function getParams(page) {
        return {
            search: document.getElementById('sa-search').value,
            sport:  document.getElementById('sa-sport').value,
            campus: document.getElementById('sa-campus').value,
            status: document.getElementById('sa-status').value,
            page:   page || 1,
        };
    }

    function fetchResults(page, instant) {
        if (currentRequest) currentRequest.abort();

        clearTimeout(debounceTimer);
        currentPage = page || 1;

        function doFetch() {
            const params = new URLSearchParams(getParams(currentPage));

            // Loading state
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

                    // Re-bind pagination buttons rendered inside the AJAX response
                    bindPageButtons();
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

        if (instant) {
            doFetch();
        } else {
            debounceTimer = setTimeout(doFetch, 320);
        }
    }

    function bindPageButtons() {
        document.querySelectorAll('.sa-page-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                fetchResults(parseInt(this.dataset.page), true);
            });
        });
    }

    // Live search as user types (debounced)
    searchInput.addEventListener('input', function () {
        currentPage = 1;
        fetchResults(1, false);
    });

    // Dropdowns trigger instant search
    ['sa-sport', 'sa-campus', 'sa-status'].forEach(id => {
        document.getElementById(id).addEventListener('change', function () {
            currentPage = 1;
            fetchResults(1, true);
        });
    });

    // Submit button
    form.addEventListener('submit', function () {
        fetchResults(1, true);
    });

    // Bind initial pagination buttons (server-rendered)
    bindPageButtons();
})();
</script>
