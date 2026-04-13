<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - AcadPortal</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/SportOffice.png" sizes="any" />
    <style>
        :root {
            --maroon:      #7A1428;
            --maroon-dark: #500D1A;
            --maroon-mid:  #9C1E35;
            --gold:        #F0B429;
            --gold-dark:   #C48F10;
            --offwhite:    #F5F3EE;
            --charcoal:    #1C1410;
            --text-body:   #3D2A2F;
            --text-muted:  #7A5C64;
            --white:       #FFFFFF;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body {
            font-family: 'Barlow', sans-serif;
            background: var(--offwhite);
            height: 100vh;
            overflow: hidden;
        }
        .user-container {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
        }

        /* Sidebar Styling */
        .sidebar {
            background: var(--maroon-dark);
            color: white;
            display: flex;
            flex-direction: column;
            border-right: 4px solid var(--gold);
            position: relative;
            overflow: hidden;
        }
        
        .sidebar-header {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 2;
        }
        .logo-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .logo-badge {
            width: 38px; height: 38px;
            background: rgba(255,255,255,.09);
            border: 1px solid rgba(240,180,41,.22);
            border-radius: 4px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-badge img { width: 24px; height: 24px; object-fit: contain; }
        .sidebar-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: rgba(240,180,41,.75);
            line-height: 1.35;
        }

        .nav-menu {
            flex: 1;
            padding: 20px 16px;
            overflow-y: auto;
            position: relative;
            z-index: 2;
        }
        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 0;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.2s;
            margin-bottom: 6px;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .nav-item:hover {
            background: rgba(255,255,255,0.05);
            color: var(--white);
        }
        .nav-item.active {
            background: rgba(240,180,41,.1);
            border-left: 4px solid var(--gold);
            color: var(--gold);
        }
        .nav-item i { font-size: 1.3rem; }

        .role-badge {
            background: rgba(240,180,41,.1);
            border: 1px solid rgba(240,180,41,.28);
            color: var(--gold);
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 3px;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 20px 16px;
            display: inline-block;
            align-self: flex-start;
            position: relative;
            z-index: 2;
        }

        .sidebar-footer {
            padding: 16px;
            border-top: 1px solid rgba(255,255,255,0.06);
            position: relative;
            z-index: 2;
        }
        .logout-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 14px;
            border-radius: 0;
            color: rgba(255,255,255,0.6);
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: rgba(122,20,40,.2);
            border: 1px solid rgba(255,255,255,.08);
            cursor: pointer;
            width: 100%;
            transition: all 0.2s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .logout-btn:hover {
            background: var(--maroon);
            color: var(--white);
            border-color: var(--maroon);
        }

        /* Main Content */
        .main-content {
            background: var(--offwhite);
            overflow-y: auto;
            position: relative;
        }
        .main-content::before {
            content: '';
            position: absolute; inset: 0;
            background-image: url('/image/background.png');
            background-size: cover;
            background-position: center;
            opacity: 0.05;
            pointer-events: none;
            z-index: 0;
        }

        .main-header {
            background: rgba(255,255,255,.8);
            backdrop-filter: blur(10px);
            border-bottom: 4px solid var(--gold);
            padding: 20px 32px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .page-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2.2rem;
            font-weight: 900;
            text-transform: uppercase;
            color: var(--charcoal);
            letter-spacing: -1px;
            line-height: 1;
        }
        .page-title span {
            color: var(--maroon);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-name {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--text-body);
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .user-name::before { content: ''; display: inline-block; width: 12px; height: 3px; background: var(--maroon); border-radius: 1px; }

        .content-area {
            padding: 32px;
            position: relative;
            z-index: 1;
        }

        /* Generic UI Shared Details */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 13px 22px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 800;
            font-size: 0.95rem;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s, transform 0.1s;
            border: none;
            position: relative;
            clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
            text-decoration: none;
        }
        .btn::after {
            content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%;
            background: rgba(255,255,255,.15); transform: skewX(-20deg); transition: left .4s;
        }
        .btn:hover::after { left: 150%; }
        .btn:active { transform: scale(0.98); }

        .btn-primary { background: var(--maroon); color: var(--white); }
        .btn-primary:hover { background: var(--maroon-mid); }
        .btn-gold { background: var(--gold); color: var(--charcoal); }
        .btn-gold:hover { background: var(--gold-dark); }
        .btn-outline { background: transparent; color: var(--maroon); border: 2px solid var(--maroon); padding: 11px 20px; }
        .btn-outline:hover { background: rgba(122,20,40,0.05); }

        /* Tables */
        .data-table {
            background: white;
            border-radius: 0;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0,0,0,0.04);
            border-bottom: 4px solid var(--gold);
            clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);
        }
        .table-header {
            display: flex;
            background: var(--maroon-dark);
            color: var(--gold);
            padding: 18px 24px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            border-bottom: 2px solid var(--maroon-mid);
        }
        .table-row {
            display: flex;
            padding: 16px 24px;
            border-bottom: 1px solid rgba(0,0,0,0.04);
            align-items: center;
            color: var(--text-body);
            transition: background 0.2s;
        }
        .table-row:hover {
            background: rgba(122,20,40,0.02);
        }

        /* Mobile Menu */
        .menu-toggle { display: none; background: none; border: none; color: var(--maroon); font-size: 1.8rem; cursor: pointer; padding: 4px; }
        .mobile-close-btn { display: none; background: none; border: none; color: var(--gold); font-size: 1.8rem; cursor: pointer; padding: 8px; position: relative; z-index: 2; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); z-index: 40; }
        .sidebar-overlay.active { display: block; }

        @media (max-width: 840px) {
            .user-container { grid-template-columns: 1fr; }
            .sidebar { position: fixed; left: -300px; top: 0; bottom: 0; width: 300px; z-index: 50; transition: left 0.3s cubic-bezier(.22,.9,.42,1); }
            .sidebar.active { left: 0; }
            .menu-toggle, .mobile-close-btn { display: flex; align-items: center; justify-content: center; }
            .sidebar-header { display: flex; justify-content: space-between; align-items: center; }
            .main-header { padding: 16px 24px; }
            .page-title { font-size: 1.6rem; }
            .content-area { padding: 20px; }
            .user-info .user-name { display: none; }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="user-container">
        <!-- Sidebar -->
        @include('user.partials.sidebar')

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            @include('user.partials.header')

            <!-- Content Area -->
            <div class="content-area">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('sidebarOverlay').classList.toggle('active');
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('active');
            document.getElementById('sidebarOverlay').classList.remove('active');
        }
    </script>
</body>
</html>
