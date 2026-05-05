@extends('user.layout', ['pageTitle' => 'Achieve', 'pageTitleSpan' => 'ments'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>My <span>Trophies</span> & Records</h2>
        <p>Keep track of your medals, tournament history, and points contributed to your campus leaderboard.</p>
    </div>

    <!-- Leaderboard Stats Card -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div class="action-card" style="border-bottom-color: var(--maroon);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">Total Points</h3>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--maroon);">145</p>
            </div>
            <div class="action-icon" style="background: rgba(122,20,40,0.1);">
                <i class='bx bx-star'></i>
            </div>
        </div>

        <div class="action-card" style="border-bottom-color: var(--gold);">
            <div class="action-card-left">
                <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">Campus Rank</h3>
                <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--gold-dark);">#4</p>
            </div>
            <div class="action-icon" style="background: rgba(240,180,41,0.15);">
                <i class='bx bx-medal' style="color: var(--gold-dark);"></i>
            </div>
        </div>
    </div>

    <div class="data-table">
        <div class="table-header">
            <div style="flex: 2;">Tournament Event</div>
            <div style="flex: 1;">Placement</div>
            <div style="flex: 1;">Points</div>
            <div style="flex: 1;">Date Logged</div>
        </div>
        
        <div class="table-row">
            <div style="flex: 2; font-weight: 600; color: var(--maroon);">Intramurals 2025 - Basketball</div>
            <div style="flex: 1; font-weight: 700; color: var(--gold-dark);"><i class='bx bxs-medal'></i> Champion</div>
            <div style="flex: 1; font-weight: 600;">+50 pts</div>
            <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">Oct 12, 2025</div>
        </div>
        
        <div class="table-row">
            <div style="flex: 2; font-weight: 600; color: var(--maroon);">Regional SCUAA Meet - Athletics</div>
            <div style="flex: 1; font-weight: 700; color: #718096;"><i class='bx bxs-medal'></i> 2nd Place</div>
            <div style="flex: 1; font-weight: 600;">+30 pts</div>
            <div style="flex: 1; font-size: 0.9rem; color: var(--text-muted);">Sep 05, 2025</div>
        </div>

        <div class="table-row" style="padding: 24px; justify-content: center; background: rgba(0,0,0,0.01);">
            <a href="#" class="btn btn-gold"><i class='bx bx-plus'></i> Log New Achievement</a>
        </div>
    </div>

@endsection
