@php
use Illuminate\Support\Facades\Auth;

$currentPage = $currentPage ?? 'Dashboard';
$user = Auth::user();
$isSuperAdmin = $user && $user->role === 'super_admin';

$menuItems = [
    ['name' => 'Dashboard', 'icon' => 'dashboard', 'route' => 'admin.dashboard'],
    ['name' => 'Student Athletes', 'icon' => 'user-circle', 'route' => 'admin.student-athletes'],
    ['name' => 'Achievement', 'icon' => 'trophy', 'route' => 'admin.achievements'],
    ['name' => 'Evaluation', 'icon' => 'line-chart', 'route' => 'admin.evaluations'],
    ['name' => 'Approved Docs', 'icon' => 'file-doc', 'route' => 'admin.approved-docs'],
    ['name' => 'Reports', 'icon' => 'report', 'route' => 'admin.reports'],
    ['name' => 'Account Approvals', 'icon' => 'user-check', 'route' => 'admin.account-approvals'],
];

if ($isSuperAdmin) {
    $menuItems[] = ['name' => 'Users', 'icon' => 'user-plus', 'route' => 'admin.users'];
}
@endphp

<div class="sidebar" id="sidebar">
    <div style="position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--gold) 0%, var(--gold-dark) 60%, transparent 100%); z-index: 1;"></div>
    <div style="position: absolute; top: 0; right: -60px; width: 180px; height: 100%; background: var(--maroon-mid); transform: skewX(-8deg); pointer-events: none; z-index: 0;"></div>
    <div style="position: absolute; top: 0; right: -120px; background: rgba(255,255,255,.03); width: 200px; height: 100%; transform: skewX(-8deg); pointer-events: none; z-index: 0;"></div>
    <svg viewBox="0 0 600 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg" style="position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0;">
        <line x1="0" y1="650" x2="700" y2="200" stroke="rgba(255,255,255,.04)" stroke-width="1"/>
        <line x1="0" y1="700" x2="700" y2="250" stroke="rgba(255,255,255,.03)" stroke-width="1"/>
        <line x1="0" y1="750" x2="700" y2="300" stroke="rgba(255,255,255,.025)" stroke-width="1"/>
        <line x1="0" y1="600" x2="700" y2="150" stroke="rgba(240,180,41,.06)" stroke-width="1.5"/>
    </svg>

    <div class="sidebar-header">
        <div class="logo-row">
            <div class="logo-badge">
                <img src="/image/SportOffice.png" alt="Logo">
            </div>
            <div class="logo-badge">
                <img src="/image/Usep.png" alt="USeP">
            </div>
            <div class="sidebar-title">USeP OSAS<br>Sports Unit</div>
        </div>
        <button class="mobile-close-btn" onclick="closeSidebar()" aria-label="Close menu">
            <i class='bx bx-x'></i>
        </button>
    </div>

    @if($isSuperAdmin)
        <div class="role-badge">Super Admin</div>
    @endif

    <nav class="nav-menu">
        @foreach($menuItems as $item)
            @php
                $isActive = $currentPage === $item['name'];
            @endphp
            <a href="{{ route($item['route']) }}"
               class="nav-item {{ $isActive ? 'active' : '' }}">
                <i class='bx bx-{{ $item['icon'] }}'></i>
                <span>{{ $item['name'] }}</span>
            </a>
        @endforeach
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
