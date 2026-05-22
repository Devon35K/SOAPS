<div class="animate-down">
    <div class="welcome-card" style="margin-bottom: 32px;">
        <h2 style="font-size: 2rem;">Admin <span>Command</span> Center</h2>
        <p>Real-time overview of student athletes, document evaluations, and campus performance.</p>
    </div>

    <!-- Analytics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
        {{-- Total Athletes --}}
        <a href="{{ route('admin.student-athletes') }}" class="action-card" style="border-bottom-color: #3b82f6;">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted); font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Total Athletes</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: #1e40af; line-height: 1;">{{ $totalAthletes }}</p>
            </div>
            <div class="action-icon" style="background: rgba(59,130,246,0.1); color: #3b82f6;">
                <i class='bx bx-group'></i>
            </div>
        </a>

        {{-- Pending Evaluations --}}
        <a href="{{ route('admin.evaluations') }}" class="action-card" style="border-bottom-color: var(--gold);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted); font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Pending Evaluations</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: var(--gold-dark); line-height: 1;">{{ $pendingEvaluations }}</p>
            </div>
            <div class="action-icon" style="background: rgba(240,180,41,0.15); color: var(--gold-dark);">
                <i class='bx bx-file-find'></i>
            </div>
        </a>

        {{-- Pending Accounts --}}
        <a href="{{ route('admin.account-approvals') }}" class="action-card" style="border-bottom-color: var(--maroon);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted); font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Account Approvals</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: var(--maroon); line-height: 1;">{{ $pendingAccounts }}</p>
            </div>
            <div class="action-icon" style="background: rgba(122,20,40,0.1); color: var(--maroon);">
                <i class='bx bx-user-plus'></i>
            </div>
        </a>

        {{-- Total Points --}}
        <a href="{{ route('admin.achievements') }}" class="action-card" style="border-bottom-color: #10b981;">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted); font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Total Points Awarded</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: #065f46; line-height: 1;">{{ number_format($totalPoints) }}</p>
            </div>
            <div class="action-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                <i class='bx bx-star'></i>
            </div>
        </a>
    </div>

    <div class="dashboard-grid">
        {{-- Recent Activity --}}
        <div class="data-table">
            <div class="table-header" style="background: #f8f9fa; color: var(--maroon); border-bottom: 2px solid #eee; display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 18px 24px;">
                <div style="font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1.5px;">Recent Submissions</div>
                <div>
                    <a href="{{ route('admin.evaluations') }}" style="color: var(--maroon); text-decoration: none; font-family: 'Barlow Condensed', sans-serif; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; display: inline-flex; align-items: center; gap: 4px; transition: color 0.2s;" onmouseover="this.style.color='var(--gold-dark)'" onmouseout="this.style.color='var(--maroon)'">
                        View All <i class='bx bx-right-arrow-alt' style="font-size: 1.1rem;"></i>
                    </a>
                </div>
            </div>
            @forelse($recentSubmissions as $sub)
                <div class="table-row" style="grid-template-columns: minmax(0, 5fr) minmax(0, 4fr) minmax(0, 3fr);">
                    <div style="font-weight: 600; white-space: nowrap !important; overflow: hidden; text-overflow: ellipsis; min-width: 0; color: var(--charcoal);">{{ $sub->user->full_name ?? 'Unknown User' }}</div>
                    <div style="font-size: 0.85rem; color: var(--text-muted); text-transform: uppercase; font-weight: 500;">{{ $sub->document_type }}</div>
                    <div style="text-align: right;">
                        <span style="font-size: 0.7rem; padding: 4px 10px; border-radius: 3px; background: {{ $sub->status == 'pending' ? '#fef9c3' : '#dcfce7' }}; color: {{ $sub->status == 'pending' ? '#854d0e' : '#166534' }}; text-transform: uppercase; font-weight: 800; font-family: 'Barlow Condensed', sans-serif; letter-spacing: 0.5px;">
                            {{ $sub->status }}
                        </span>
                    </div>
                </div>
            @empty
                <div style="padding: 40px; text-align: center; color: var(--text-muted);">No recent activity.</div>
            @endforelse
        </div>

        {{-- Quick Links --}}
        <div style="display: flex; flex-direction: column; gap: 16px;">
            <a href="{{ route('admin.account-approvals') }}" class="btn btn-gold" style="width: 100%; justify-content: flex-start; height: 60px;">
                <i class='bx bx-user-check' style="font-size: 1.5rem;"></i> Approve New Accounts
            </a>
            <a href="{{ route('admin.evaluations') }}" class="btn btn-primary" style="width: 100%; justify-content: flex-start; height: 60px;">
                <i class='bx bx-clipboard' style="font-size: 1.5rem;"></i> Start Evaluations
            </a>
            <a href="{{ route('admin.reports') }}" class="btn btn-outline" style="width: 100%; justify-content: flex-start; height: 60px; border-style: dashed;">
                <i class='bx bx-printer' style="font-size: 1.5rem;"></i> Generate Reports
            </a>
        </div>
    </div>
</div>
