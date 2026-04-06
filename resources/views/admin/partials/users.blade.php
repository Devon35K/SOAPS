<div class="flex justify-between items-center mb-6">
    <h3 class="text-lg font-medium">System Users</h3>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
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
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background: var(--maroon); color: white; font-weight: 600;">
                    {{ substr($user->full_name, 0, 1) }}
                </div>
                <div>
                    <div class="font-medium">{{ $user->full_name }}</div>
                    <div class="text-sm" style="color: var(--text-muted);">{{ $user->student_id }}</div>
                </div>
            </div>
            <div>{{ $user->email }}</div>
            <div>
                <span class="px-2 py-1 rounded text-xs font-semibold
                    {{ $user->role === 'super_admin' ? 'bg-yellow-100 text-yellow-800' : ($user->role === 'admin' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800') }}">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
            </div>
            <div>
                <span class="px-2 py-1 rounded text-xs {{ $user->approved ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                    {{ $user->approved ? 'Approved' : 'Pending' }}
                </span>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.7rem;">
                    <i class='bx bx-edit'></i> Edit
                </a>
                @if($user->role !== 'super_admin')
                    <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" class="inline" onsubmit="return confirm('Delete {{ $user->full_name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 0.7rem;">
                            <i class='bx bx-trash'></i> Delete
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <div class="table-row text-center" style="grid-template-columns: 1fr; padding: 40px;">
            <div>No users found</div>
        </div>
    @endforelse
</div>
