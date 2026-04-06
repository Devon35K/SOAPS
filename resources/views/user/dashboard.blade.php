<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/SportOffice.png" sizes="any" />
    <style>
        :root {
            --maroon: #7A1428;
            --maroon-dark: #500D1A;
            --maroon-mid: #9C1E35;
            --gold: #F0B429;
            --gold-dark: #C48F10;
            --offwhite: #F5F3EE;
            --charcoal: #1C1410;
            --text-body: #3D2A2F;
            --text-muted: #7A5C64;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            font-family: 'Barlow', sans-serif;
            background: var(--offwhite);
            height: 100vh;
            overflow: hidden;
        }
        .container {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
        }
        .sidebar {
            background: var(--maroon-dark);
            color: white;
            display: flex;
            flex-direction: column;
            border-right: 4px solid var(--gold);
        }
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .logo-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-badge {
            width: 42px; height: 42px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(240,180,41,0.3);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-badge img { width: 28px; height: 28px; }
        .sidebar-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold);
        }
        .nav-menu {
            flex: 1;
            padding: 20px 16px;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 8px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.2s;
            margin-bottom: 4px;
        }
        .nav-item:hover, .nav-item.active {
            background: var(--maroon);
            color: white;
        }
        .nav-item i { font-size: 1.2rem; }
        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .logout-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            border-radius: 8px;
            color: rgba(255,255,255,0.85);
            text-decoration: none;
            font-size: 0.9rem;
            background: transparent;
            border: 1px solid rgba(255,255,255,0.2);
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
        }
        .logout-btn:hover {
            background: rgba(255,255,255,0.1);
            border-color: var(--gold);
        }
        .main-content {
            background: var(--offwhite);
            overflow-y: auto;
        }
        .main-header {
            background: white;
            border-bottom: 4px solid var(--gold);
            padding: 20px 28px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .page-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--charcoal);
            letter-spacing: -1px;
        }
        .content-area {
            padding: 28px;
        }
        .welcome-card {
            background: white;
            padding: 32px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 24px;
        }
        .welcome-card h2 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.5rem;
            color: var(--maroon);
            margin-bottom: 8px;
        }
        .welcome-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .action-card {
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            border-top: 4px solid var(--maroon);
        }
        .action-card h3 {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1.1rem;
            color: var(--charcoal);
            margin-bottom: 12px;
        }
        .action-card p {
            color: var(--text-muted);
            font-size: 0.9rem;
            margin-bottom: 16px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 16px;
            border-radius: 6px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
            text-decoration: none;
        }
        .btn-primary {
            background: var(--maroon);
            color: white;
        }
        .btn-primary:hover {
            background: var(--maroon-mid);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="logo-row">
                    <div class="logo-badge">
                        <img src="/image/SportOffice.png" alt="Logo">
                    </div>
                    <div class="logo-badge">
                        <img src="/image/Usep.png" alt="USeP">
                    </div>
                    <div class="sidebar-title">Student<br>Portal</div>
                </div>
            </div>

            <nav class="nav-menu">
                <a href="{{ route('user.dashboard') }}" class="nav-item active">
                    <i class='bx bx-dashboard'></i>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="nav-item">
                    <i class='bx bx-file'></i>
                    <span>My Submissions</span>
                </a>
                <a href="#" class="nav-item">
                    <i class='bx bx-trophy'></i>
                    <span>Achievements</span>
                </a>
                <a href="#" class="nav-item">
                    <i class='bx bx-user'></i>
                    <span>Profile</span>
                </a>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class='bx bx-log-out'></i>
                        <span>Log-out</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="main-content">
            <div class="main-header">
                <h1 class="page-title">Dashboard</h1>
                <div style="display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 0.9rem; color: var(--text-body); font-weight: 500;">
                        {{ Auth::user()->full_name ?? 'Student' }}
                    </span>
                </div>
            </div>

            <div class="content-area">
                <div class="welcome-card">
                    <h2>Welcome, {{ Auth::user()->full_name ?? 'Student' }}!</h2>
                    <p>This is your student dashboard. Here you can manage your submissions, track your achievements, and update your profile.</p>
                </div>

                <div class="quick-actions">
                    <div class="action-card">
                        <h3><i class='bx bx-upload'></i> Submit Documents</h3>
                        <p>Upload your sports and cultural documents for review.</p>
                        <a href="#" class="btn btn-primary">Submit Now</a>
                    </div>
                    <div class="action-card">
                        <h3><i class='bx bx-chart'></i> View Achievements</h3>
                        <p>Track your points and leaderboard ranking.</p>
                        <a href="#" class="btn btn-primary">View Progress</a>
                    </div>
                    <div class="action-card">
                        <h3><i class='bx bx-user'></i> Update Profile</h3>
                        <p>Keep your personal information up to date.</p>
                        <a href="#" class="btn btn-primary">Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
