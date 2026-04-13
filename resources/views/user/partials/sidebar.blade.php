<div class="sidebar" id="sidebar">
    <button class="mobile-close-btn" onclick="closeSidebar()"><i class='bx bx-x'></i></button>
    <div class="sidebar-header">
        <div class="logo-row">
            <div class="logo-badge">
                <img src="/image/SportOffice.png" alt="Logo">
            </div>
            <div class="sidebar-title">Student<br>Portal</div>
        </div>
    </div>

    <div class="role-badge">Student</div>

    <nav class="nav-menu">
        <a href="{{ route('user.dashboard') }}" class="nav-item {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class='bx bx-dashboard'></i> <span>Dashboard</span>
        </a>
        <a href="{{ route('user.submissions') }}" class="nav-item {{ request()->routeIs('user.submissions') ? 'active' : '' }}">
            <i class='bx bx-file-export'></i> <span>Submissions</span>
        </a>
        <a href="{{ route('user.achievements') }}" class="nav-item {{ request()->routeIs('user.achievements') ? 'active' : '' }}">
            <i class='bx bx-trophy'></i> <span>Achievements</span>
        </a>
        <a href="{{ route('user.track-records') }}" class="nav-item {{ request()->routeIs('user.track-records') ? 'active' : '' }}">
            <i class='bx bx-file'></i> <span>Track Records</span>
        </a>
        <a href="{{ route('user.profile') }}" class="nav-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class='bx bx-user'></i> <span>Profile Update</span>
        </a>
    </nav>

    <div class="sidebar-footer">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">
                <i class='bx bx-log-out'></i> <span>Log Out</span>
            </button>
        </form>
    </div>
</div>
