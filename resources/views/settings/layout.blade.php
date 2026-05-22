@extends(
    (Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin') ? 'admin.layout' : 'user.layout',
    [
        'currentPage' => 'Settings',
        'pageTitle' => 'Settings',
        'pageTitleSpan' => '',
    ]
)

@section('content')
    <style>
        /* Welcome Card Styling matching Student theme */
        .welcome-card {
            background: var(--maroon-dark) !important;
            color: white !important;
            padding: 30px 40px !important;
            border-left: 5px solid var(--gold) !important;
            margin-bottom: 32px !important;
            position: relative !important;
            overflow: hidden !important;
            clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%) !important;
        }
        .welcome-card::after {
            content: '' !important;
            position: absolute !important;
            top: -50px !important;
            right: -50px !important;
            width: 200px !important;
            height: 200px !important;
            background: rgba(255,255,255,0.03) !important;
            transform: rotate(45deg) !important;
            pointer-events: none !important;
        }
        .welcome-card h2 {
            font-family: 'Barlow Condensed', sans-serif !important;
            font-weight: 700 !important;
            color: white !important;
            font-size: 1.8rem !important;
            margin-bottom: 5px !important;
            margin-top: 0 !important;
            text-transform: none !important;
            letter-spacing: normal !important;
        }
        .welcome-card h2 span {
            color: var(--gold) !important;
        }
        .welcome-card p {
            color: rgba(255, 255, 255, 0.8) !important;
            font-size: 0.95rem !important;
            margin: 0 !important;
        }

        /* Outlined buttons styling in sidebar for Settings Page */
        .settings-sidebar .btn {
            font-family: 'Barlow Condensed', sans-serif !important;
            font-weight: 800 !important;
            text-transform: uppercase !important;
            letter-spacing: 1.5px !important;
            border-radius: 4px !important;
            clip-path: none !important;
            transition: all 0.2s !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            padding: 13px 22px !important;
            width: 100% !important;
            justify-content: flex-start !important;
            text-align: left !important;
            box-shadow: none !important;
            transform: none !important;
        }

        .settings-sidebar .btn-outline {
            background: transparent !important;
            color: var(--maroon) !important;
            border: 2px solid var(--maroon) !important;
        }

        .settings-sidebar .btn-outline:hover {
            background: rgba(122, 20, 40, 0.05) !important;
            color: var(--maroon) !important;
            transform: translateY(-2px) !important;
        }

        .settings-sidebar .btn-primary {
            background: var(--maroon) !important;
            color: var(--white) !important;
            border: 2px solid var(--maroon) !important;
        }

        .settings-sidebar .btn-primary:hover {
            background: var(--maroon-mid) !important;
            border-color: var(--maroon-mid) !important;
            transform: translateY(-2px) !important;
        }
    </style>

    <div class="welcome-card">
        <h2>Account <span>Settings</span></h2>
        <p>Manage your profile information and security settings.</p>
    </div>

    <div style="display: grid; grid-template-columns: 250px 1fr; gap: 32px;">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            <nav style="display: flex; flex-direction: column; gap: 8px;">
                <a href="{{ route('profile.edit') }}" class="btn {{ request()->routeIs('profile.edit') ? 'btn-primary' : 'btn-outline' }}" style="justify-content: flex-start; text-align: left; clip-path: none; border-radius: 4px;">
                    <i class='bx bx-user'></i> Profile Information
                </a>
                <a href="{{ route('user-password.edit') }}" class="btn {{ request()->routeIs('user-password.edit') ? 'btn-primary' : 'btn-outline' }}" style="justify-content: flex-start; text-align: left; clip-path: none; border-radius: 4px;">
                    <i class='bx bx-lock-alt'></i> Password
                </a>
                <a href="{{ route('two-factor.show') }}" class="btn {{ request()->routeIs('two-factor.show') ? 'btn-primary' : 'btn-outline' }}" style="justify-content: flex-start; text-align: left; clip-path: none; border-radius: 4px;">
                    <i class='bx bx-shield-quarter'></i> Two-Factor Auth
                </a>
            </nav>
        </div>

        <!-- Settings Content Area -->
        <div class="settings-content">
            <div class="data-table" style="padding: 32px; border-bottom: 4px solid var(--maroon);">
                @yield('settings-content')
            </div>
        </div>
    </div>
@endsection
