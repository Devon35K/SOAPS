@php
use Illuminate\Support\Facades\Auth;
$currentPage = $currentPage ?? 'Dashboard';
$user = Auth::user();
@endphp

<div class="main-header">
    <div style="display: flex; align-items: center; gap: 12px;">
        <button class="menu-toggle" onclick="toggleSidebar()" aria-label="Toggle menu">
            <i class='bx bx-menu'></i>
        </button>
        <h1 class="page-title">{{ $currentPage }}</h1>
    </div>
    <div class="user-info">
        @if($user && $user->role === 'super_admin')
            <span style="background: var(--gold); color: var(--maroon-dark); font-size: 0.65rem; font-weight: 800; padding: 4px 10px; border-radius: 4px; text-transform: uppercase;">Super Admin</span>
        @endif
        <span class="user-name">{{ $user->full_name ?? 'Admin' }}</span>
    </div>
</div>

@if(session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error">
        {{ session('error') }}
    </div>
@endif
