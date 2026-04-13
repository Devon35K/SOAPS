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
        <h1 class="page-title">{{ $currentPage }}<span>.</span></h1>
    </div>
    <div class="user-info">
        @if($user && $user->role === 'super_admin')
            <span style="background: rgba(240,180,41,.18); border: 1px solid rgba(240,180,41,.4); color: var(--gold-dark); font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; padding: 4px 10px; border-radius: 3px; text-transform: uppercase; letter-spacing: 1px;">Super Admin</span>
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
