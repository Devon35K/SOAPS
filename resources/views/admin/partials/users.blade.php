<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); text-transform: uppercase;">System Users</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary" style="text-decoration: none;">
        <i class='bx bx-plus'></i> Add User
    </a>
</div>

<div class="data-table">
    <div class="table-header" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 1.5fr;">
        <div>Name</div>
        <div>Email</div>
        <div>Role</div>
        <div>Status</div>
        <div>Actions</div>
    </div>

    @forelse($users as $user)
        <div class="table-row" style="grid-template-columns: 2fr 1.5fr 1fr 1fr 1.5fr;">
            <div data-label="Name" style="display: flex; align-items: center; gap: 12px;">
                <div style="width: 40px; height: 40px; border-radius: 4px; background: rgba(122,20,40,.1); color: var(--maroon); font-family: 'Barlow Condensed', sans-serif; font-weight: 800; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
                    {{ strtoupper(substr($user->full_name, 0, 1)) }}
                </div>
                <div>
                    <div style="font-weight: 600;">{{ $user->full_name }}</div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $user->student_id }}</div>
                </div>
            </div>
            <div data-label="Email">{{ $user->email }}</div>
            <div data-label="Role">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; 
                    {{ $user->role === 'super_admin' ? 'background: #fef08a; color: #854d0e;' : ($user->role === 'admin' ? 'background: #e0f2fe; color: #0284c7;' : 'background: #f1f5f9; color: #475569;') }}">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
            </div>
            <div data-label="Status">
                <span style="font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 4px 8px; border-radius: 2px; font-family: 'Barlow Condensed'; 
                    {{ $user->approved ? 'background: #dcfce7; color: #166534;' : 'background: #fef08a; color: #854d0e;' }}">
                    {{ $user->approved ? 'Approved' : 'Pending' }}
                </span>
            </div>
            <div data-label="Actions" style="display: flex; gap: 8px;">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem; text-decoration: none;">
                    <i class='bx bx-edit'></i> Edit
                </a>
                @if($user->role !== 'super_admin')
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" style="margin: 0; display: inline;" onsubmit="return confirm('Delete {{ $user->full_name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.75rem;">
                            <i class='bx bx-trash'></i> Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="table-row" style="grid-template-columns: 1fr; justify-content: center; text-align: center; padding: 40px;">
            <div style="color: var(--text-muted); font-weight: 500;">No users found</div>
        </div>
    @endforelse
</div>
