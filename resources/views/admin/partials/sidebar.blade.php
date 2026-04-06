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
    <div class="sidebar-header">
        <div class="logo-row">
            <div class="logo-badge">
                <img src="/image/SportOffice.png" alt="Logo">
            </div>
            <div class="logo-badge">
                <img src="/image/Usep.png" alt="USeP">
            </div>
            <div class="sidebar-title">Admin<br>Portal</div>
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
