<div class="animate-down">
    <div class="welcome-card" style="margin-bottom: 32px;">
        <h2 style="font-size: 2rem;">Admin <span>Command</span> Center</h2>
        <p>Real-time overview of student athletes, document evaluations, and campus performance.</p>
    </div>

    <!-- Analytics Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
        {{-- Total Athletes --}}
        <div class="action-card" style="border-bottom-color: #3b82f6;">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted);">Total Athletes</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: #1e40af;">{{ $totalAthletes }}</p>
            </div>
            <div class="action-icon" style="background: rgba(59,130,246,0.1); color: #3b82f6;">
                <i class='bx bx-group'></i>
            </div>
        </div>

        {{-- Pending Evaluations --}}
        <div class="action-card" style="border-bottom-color: var(--gold);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted);">Pending Evaluations</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: var(--gold-dark);">{{ $pendingEvaluations }}</p>
            </div>
            <div class="action-icon" style="background: rgba(240,180,41,0.15); color: var(--gold-dark);">
                <i class='bx bx-file-find'></i>
            </div>
        </div>

        {{-- Pending Accounts --}}
        <div class="action-card" style="border-bottom-color: var(--maroon);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted);">Account Approvals</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: var(--maroon);">{{ $pendingAccounts }}</p>
            </div>
            <div class="action-icon" style="background: rgba(122,20,40,0.1); color: var(--maroon);">
                <i class='bx bx-user-plus'></i>
            </div>
        </div>

        {{-- Total Points --}}
        <div class="action-card" style="border-bottom-color: #10b981;">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; color: var(--text-muted);">Total Points Awarded</h3>
                <p style="font-size: 2.5rem; font-weight: 900; color: #065f46;">{{ number_format($totalPoints) }}</p>
            </div>
            <div class="action-icon" style="background: rgba(16,185,129,0.1); color: #10b981;">
                <i class='bx bx-star'></i>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
        {{-- Recent Activity --}}
        <div class="data-table">
            <div class="table-header" style="background: #f8f9fa; color: var(--maroon); border-bottom: 2px solid #eee;">
                <div style="flex: 1;">Recent Submissions</div>
                <div style="text-align: right;"><a href="?page=Evaluation" style="color: var(--maroon); text-decoration: none; font-size: 0.75rem;">View All <i class='bx bx-right-arrow-alt'></i></a></div>
            </div>
            @forelse($recentSubmissions as $sub)
                <div class="table-row">
                    <div style="flex: 2; font-weight: 600;">{{ $sub->user->full_name ?? 'Unknown User' }}</div>
                    <div style="flex: 2; font-size: 0.85rem; color: var(--text-muted);">{{ $sub->document_type }}</div>
                    <div style="flex: 1; text-align: right;">
                        <span style="font-size: 0.7rem; padding: 2px 8px; border-radius: 4px; background: {{ $sub->status == 'pending' ? '#fef9c3' : '#dcfce7' }}; color: {{ $sub->status == 'pending' ? '#854d0e' : '#166534' }}; text-transform: uppercase; font-weight: 800;">
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
            <a href="?page=Account Approvals" class="btn btn-gold" style="width: 100%; justify-content: flex-start; height: 60px;">
                <i class='bx bx-user-check' style="font-size: 1.5rem;"></i> Approve New Accounts
            </a>
            <a href="?page=Evaluation" class="btn btn-primary" style="width: 100%; justify-content: flex-start; height: 60px;">
                <i class='bx bx-clipboard' style="font-size: 1.5rem;"></i> Start Evaluations
            </a>
            <a href="?page=Reports" class="btn btn-outline" style="width: 100%; justify-content: flex-start; height: 60px; border-style: dashed;">
                <i class='bx bx-printer' style="font-size: 1.5rem;"></i> Generate Reports
            </a>
        </div>
    </div>
</div>
