<div class="main-header">
    <div style="display: flex; align-items: center; gap: 16px;">
        <button class="menu-toggle" onclick="toggleSidebar()"><i class='bx bx-menu'></i></button>
        <h1 class="page-title">{{ $pageTitle ?? 'Dash' }}<span>{{ $pageTitleSpan ?? 'board' }}</span></h1>
    </div>
    <div class="user-info">
        <div class="user-name">{{ Auth::user()->full_name ?? 'Student Profile' }}</div>
        <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.1); border: 1px solid var(--maroon); display: flex; align-items: center; justify-content: center;">
            <i class='bx bx-user' style="color: var(--maroon); font-size: 1.2rem;"></i>
        </div>
    </div>
</div>
