<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - {{ $currentPage }}</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/SportOffice.png" sizes="any" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @csrf
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
        .admin-container {
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
            overflow-y: auto;
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
        .nav-item:hover {
            background: rgba(255,255,255,0.1);
            color: white;
        }
        .nav-item.active {
            background: var(--maroon);
            border-left: 3px solid var(--gold);
            color: white;
        }
        .nav-item i { font-size: 1.2rem; }
        .role-badge {
            background: var(--gold);
            color: var(--maroon-dark);
            font-size: 0.65rem;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 16px 16px;
        }
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
            position: sticky;
            top: 0;
            z-index: 10;
        }
        .page-title {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            text-transform: uppercase;
            color: var(--charcoal);
            letter-spacing: -1px;
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
            font-size: 0.9rem;
            color: var(--text-body);
            font-weight: 500;
        }
        .content-area {
            padding: 28px;
        }
        /* Table Styles */
        .data-table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }
        .table-header {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 16px;
            background: var(--maroon);
            color: white;
            padding: 16px 20px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 1px;
        }
        .table-row {
            display: grid;
            grid-template-columns: repeat(12, 1fr);
            gap: 16px;
            padding: 16px 20px;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            align-items: center;
            color: var(--text-body);
        }
        .table-row:hover {
            background: rgba(122,20,40,0.03);
        }
        /* Search Form */
        .search-form {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .search-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            align-items: end;
        }
        .form-group label {
            display: block;
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 0.7rem;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 14px;
            border: 2px solid rgba(61,42,47,0.12);
            border-radius: 6px;
            font-family: 'Barlow', sans-serif;
            font-size: 0.9rem;
            color: var(--charcoal);
            outline: none;
            transition: border-color 0.2s;
        }
        .form-control:focus {
            border-color: var(--maroon);
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 20px;
            border-radius: 6px;
            font-family: 'Barlow Condensed', sans-serif;
            font-weight: 700;
            font-size: 0.85rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }
        .btn-primary {
            background: var(--maroon);
            color: white;
        }
        .btn-primary:hover {
            background: var(--maroon-mid);
        }
        .btn-success {
            background: #10B981;
            color: white;
        }
        .btn-danger {
            background: #EF4444;
            color: white;
        }
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        .alert-success {
            background: rgba(16,185,129,0.1);
            border-left: 4px solid #10B981;
            color: #065F46;
        }
        .alert-error {
            background: rgba(239,68,68,0.1);
            border-left: 4px solid #EF4444;
            color: #991B1B;
        }
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--maroon);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
        }
        .mobile-close-btn {
            display: none;
            background: none;
            border: none;
            color: var(--gold);
            font-size: 1.5rem;
            cursor: pointer;
            padding: 8px;
        }
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 40;
        }
        .sidebar-overlay.active {
            display: block;
        }
        /* Mobile Responsive Styles */
        @media (max-width: 768px) {
            .admin-container {
                grid-template-columns: 1fr;
            }
            .sidebar {
                position: fixed;
                left: -280px;
                top: 0;
                bottom: 0;
                width: 280px;
                z-index: 50;
                transition: left 0.3s ease;
            }
            .sidebar.active {
                left: 0;
            }
            .menu-toggle {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .mobile-close-btn {
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .sidebar-header {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .main-header {
                padding: 16px 20px;
            }
            .page-title {
                font-size: 1.25rem;
            }
            .content-area {
                padding: 16px;
            }
            .search-grid {
                grid-template-columns: 1fr;
            }
            .table-header,
            .table-row {
                grid-template-columns: 1fr !important;
                gap: 8px;
            }
            .table-header {
                display: none;
            }
            .table-row {
                padding: 12px;
                border-bottom: 2px solid rgba(0,0,0,0.1);
            }
            .table-row > div {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 4px 0;
            }
            .table-row > div::before {
                content: attr(data-label);
                font-weight: 600;
                color: var(--maroon);
            }
            .user-info .user-name {
                display: none;
            }
        }
        @media (max-width: 480px) {
            .page-title {
                font-size: 1rem;
            }
            .quick-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="admin-container">
        @include('admin.partials.sidebar')

        <div class="main-content">
            @include('admin.partials.header')

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
    @stack('scripts')
</body>
</html>
