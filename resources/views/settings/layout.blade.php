@extends(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin' ? 'admin.layout' : 'user.layout')

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px; padding: 30px;">
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
