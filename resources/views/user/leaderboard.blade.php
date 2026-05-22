@extends('user.layout', ['pageTitle' => 'Campus', 'pageTitleSpan' => ' Leaderboard'])

@section('content')
    <style>
        /* Leaderboard Standing Container */
        .leaderboard-container {
            display: grid;
            grid-template-columns: 1fr;
            gap: 32px;
            align-items: start;
        }

        /* Leaderboard Full Card */
        .leaderboard-full-card {
            background: white;
            border-bottom: 4px solid var(--gold);
            clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .leaderboard-full-header {
            background: var(--maroon-dark);
            color: var(--gold);
            padding: 24px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            text-transform: uppercase;
            font-size: 1.3rem;
            letter-spacing: 1.5px;
            border-bottom: 2px solid var(--maroon-mid);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .leaderboard-full-body {
            padding: 16px 0;
        }

        .leaderboard-item {
            display: flex;
            align-items: center;
            padding: 16px 32px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            transition: all 0.2s ease;
            position: relative;
        }

        .leaderboard-item:last-child {
            border-bottom: none;
        }

        .leaderboard-item:hover {
            background: rgba(122,20,40,0.01);
        }

        .leaderboard-item.highlighted {
            background: linear-gradient(135deg, rgba(122,20,40,0.08) 0%, rgba(240,180,41,0.04) 100%);
            border-left: 4px solid var(--gold);
            border-right: 4px solid var(--gold);
            box-shadow: inset 0 0 12px rgba(122, 20, 40, 0.03);
        }

        .leaderboard-rank {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 1.2rem;
            margin-right: 24px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .rank-1 {
            background: rgba(240, 180, 41, 0.15);
            color: var(--gold-dark);
            border: 1px solid rgba(240, 180, 41, 0.3);
            font-size: 1.3rem;
        }

        .rank-2 {
            background: rgba(192, 192, 192, 0.15);
            color: #7f8c8d;
            border: 1px solid rgba(192, 192, 192, 0.3);
            font-size: 1.3rem;
        }

        .rank-3 {
            background: rgba(205, 127, 50, 0.15);
            color: #a0522d;
            border: 1px solid rgba(205, 127, 50, 0.3);
            font-size: 1.3rem;
        }

        .rank-other {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .leaderboard-avatar {
            width: 42px;
            height: 42px;
            border-radius: 4px;
            background: rgba(122,20,40,0.05);
            border: 1px solid rgba(122,20,40,0.1);
            color: var(--maroon);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.1rem;
            margin-right: 24px;
            flex-shrink: 0;
            text-transform: uppercase;
        }

        .leaderboard-item.highlighted .leaderboard-avatar {
            background: var(--maroon);
            color: var(--white);
            border-color: var(--maroon);
        }

        .leaderboard-info {
            flex-grow: 1;
            min-width: 0;
        }

        .leaderboard-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--charcoal);
            text-transform: uppercase;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
        }

        .leaderboard-item.highlighted .leaderboard-name {
            color: var(--maroon);
        }

        .leaderboard-sport {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .leaderboard-points {
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 900;
            font-size: 1.4rem;
            color: var(--maroon-mid);
            text-align: right;
            margin-left: 16px;
            flex-shrink: 0;
        }

        .leaderboard-item.highlighted .leaderboard-points {
            color: var(--maroon);
        }

        .badge-you {
            background: var(--gold);
            color: var(--charcoal);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 2px 6px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-left: 8px;
            vertical-align: middle;
            display: inline-block;
        }
    </style>

    <div class="leaderboard-container animate-up">
        <!-- Welcome Banner -->
        <div class="welcome-card" style="margin-bottom: 0;">
            <h2>Campus <span>Standings</span></h2>
            <p>Compare your points and rank against our elite campus athletes. Top 10 rankings are updated in real-time.</p>
        </div>

        <!-- Stats row -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 24px;">
            <div class="action-card" style="border-bottom-color: var(--maroon);">
                <div class="action-card-left">
                    <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">My Total Points</h3>
                    <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--maroon);">{{ $totalPoints }}</p>
                </div>
                <div class="action-icon" style="background: rgba(122,20,40,0.1);">
                    <i class='bx bx-star'></i>
                </div>
            </div>

            <div class="action-card" style="border-bottom-color: var(--gold);">
                <div class="action-card-left">
                    <h3 style="font-size: 0.8rem; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; color: var(--text-muted); font-weight: 700; letter-spacing: 1px;">My Campus Rank</h3>
                    <p style="font-family: 'Barlow Condensed', sans-serif; font-size: 2.5rem; font-weight: 900; color: var(--gold-dark);">#{{ $rank }}</p>
                </div>
                <div class="action-icon" style="background: rgba(240,180,41,0.15);">
                    <i class='bx bx-medal' style="color: var(--gold-dark);"></i>
                </div>
            </div>
        </div>

        <!-- Standings Card -->
        <div class="leaderboard-full-card">
            <div class="leaderboard-full-header">
                <span><i class='bx bx-trophy' style="color: var(--gold); margin-right: 8px;"></i> Athlete Leaderboard Standings</span>
                <span style="font-size: 0.75rem; color: rgba(255,255,255,0.6); font-weight: 400; letter-spacing: 0.5px; text-transform: none;">Top 10 Rankings</span>
            </div>
            <div class="leaderboard-full-body">
                @php
                    // Mapping of sports to cool boxicons
                    $sportIcons = [
                        'athletics' => 'bx-run',
                        'badminton' => 'bx-tennis-ball',
                        'basketball' => 'bx-basketball',
                        'chess' => 'bx-hash',
                        'esports' => 'bx-game',
                        'football' => 'bx-football',
                        'sepak takraw' => 'bx-football',
                        'softball' => 'bx-baseball',
                        'swimming' => 'bx-swim',
                        'table tennis' => 'bx-tennis-ball',
                        'taekwondo' => 'bx-body',
                        'tennis' => 'bx-tennis-ball',
                        'volleyball' => 'bx-volleyball',
                    ];
                @endphp

                @forelse($leaderboardEntries as $index => $entry)
                    @php
                        $entryRank = $index + 1;
                        $isCurrentUser = $entry->user_id === auth()->id();
                        $displayName = $entry->user ? $entry->user->full_name : 'Unknown Athlete';
                        $displaySport = $entry->user ? $entry->user->sport : 'General';
                        
                        $words = explode(' ', $displayName);
                        $initials = '';
                        foreach ($words as $w) {
                            $initials .= isset($w[0]) ? $w[0] : '';
                        }
                        $initials = strtoupper(substr($initials, 0, 2));
                        
                        $sportLower = strtolower($displaySport);
                        $iconClass = 'bx-award';
                        foreach ($sportIcons as $key => $icon) {
                            if (strpos($sportLower, $key) !== false) {
                                $iconClass = $icon;
                                break;
                            }
                        }
                    @endphp

                    <div class="leaderboard-item {{ $isCurrentUser ? 'highlighted' : '' }}">
                        <div class="leaderboard-rank {{ $entryRank == 1 ? 'rank-1' : ($entryRank == 2 ? 'rank-2' : ($entryRank == 3 ? 'rank-3' : 'rank-other')) }}">
                            @if($entryRank == 1)
                                🏆
                            @elseif($entryRank == 2)
                                🥈
                            @elseif($entryRank == 3)
                                🥉
                            @else
                                #{{ $entryRank }}
                            @endif
                        </div>
                        
                        <div class="leaderboard-avatar">
                            {{ $initials }}
                        </div>

                        <div class="leaderboard-info">
                            <div class="leaderboard-name">
                                {{ $displayName }}
                                @if($isCurrentUser)
                                    <span class="badge-you">You</span>
                                @endif
                            </div>
                            <div class="leaderboard-sport">
                                <i class='bx {{ $iconClass }}' style="color: var(--gold-dark);"></i> {{ $displaySport }}
                            </div>
                        </div>

                        <div class="leaderboard-points">
                            {{ number_format($entry->total_points) }} <span style="font-size: 0.85rem; font-weight: 500; text-transform: uppercase;">pts</span>
                        </div>
                    </div>
                @empty
                    <div style="text-align: center; padding: 60px; color: var(--text-muted); font-size: 1.1rem;">
                        <i class='bx bx-trophy' style="font-size: 3rem; color: rgba(0,0,0,0.05); display: block; margin-bottom: 12px;"></i>
                        No leaderboard standings recorded yet.
                    </div>
                @endforelse

                @if(!$userInTop10 && $currentUserEntry)
                    @php
                        $displayName = $currentUserEntry->user ? $currentUserEntry->user->full_name : 'Unknown Athlete';
                        $displaySport = $currentUserEntry->user ? $currentUserEntry->user->sport : 'General';
                        
                        $words = explode(' ', $displayName);
                        $initials = '';
                        foreach ($words as $w) {
                            $initials .= isset($w[0]) ? $w[0] : '';
                        }
                        $initials = strtoupper(substr($initials, 0, 2));
                        
                        $sportLower = strtolower($displaySport);
                        $iconClass = 'bx-award';
                        foreach ($sportIcons as $key => $icon) {
                            if (strpos($sportLower, $key) !== false) {
                                $iconClass = $icon;
                                break;
                            }
                        }
                    @endphp

                    <!-- Gap Separator -->
                    <div style="text-align: center; color: var(--text-muted); font-size: 1.5rem; letter-spacing: 4px; padding: 20px 0; font-weight: 800;">
                        •••
                    </div>

                    <div class="leaderboard-item highlighted" style="border-top: 1px solid rgba(0,0,0,0.04);">
                        <div class="leaderboard-rank rank-other" style="color: var(--maroon);">
                            #{{ $rank }}
                        </div>
                        
                        <div class="leaderboard-avatar">
                            {{ $initials }}
                        </div>

                        <div class="leaderboard-info">
                            <div class="leaderboard-name">
                                {{ $displayName }}
                                <span class="badge-you">You</span>
                            </div>
                            <div class="leaderboard-sport">
                                <i class='bx {{ $iconClass }}' style="color: var(--gold-dark);"></i> {{ $displaySport }}
                            </div>
                        </div>

                        <div class="leaderboard-points">
                            {{ number_format($currentUserEntry->total_points) }} <span style="font-size: 0.85rem; font-weight: 500; text-transform: uppercase;">pts</span>
                        </div>
                    </div>
                @elseif(!$userInTop10 && !$currentUserEntry)
                    @php
                        $displayName = auth()->user()->full_name;
                        $displaySport = auth()->user()->sport ?? 'General';
                        
                        $words = explode(' ', $displayName);
                        $initials = '';
                        foreach ($words as $w) {
                            $initials .= isset($w[0]) ? $w[0] : '';
                        }
                        $initials = strtoupper(substr($initials, 0, 2));
                        
                        $sportLower = strtolower($displaySport);
                        $iconClass = 'bx-award';
                        foreach ($sportIcons as $key => $icon) {
                            if (strpos($sportLower, $key) !== false) {
                                $iconClass = $icon;
                                break;
                            }
                        }
                    @endphp

                    <!-- Gap Separator -->
                    <div style="text-align: center; color: var(--text-muted); font-size: 1.5rem; letter-spacing: 4px; padding: 20px 0; font-weight: 800;">
                        •••
                    </div>

                    <div class="leaderboard-item highlighted" style="border-top: 1px solid rgba(0,0,0,0.04);">
                        <div class="leaderboard-rank rank-other" style="color: var(--maroon);">
                            #N/A
                        </div>
                        
                        <div class="leaderboard-avatar">
                            {{ $initials }}
                        </div>

                        <div class="leaderboard-info">
                            <div class="leaderboard-name">
                                {{ $displayName }}
                                <span class="badge-you">You</span>
                            </div>
                            <div class="leaderboard-sport">
                                <i class='bx {{ $iconClass }}' style="color: var(--gold-dark);"></i> {{ $displaySport }}
                            </div>
                        </div>

                        <div class="leaderboard-points">
                            0 <span style="font-size: 0.85rem; font-weight: 500; text-transform: uppercase;">pts</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
