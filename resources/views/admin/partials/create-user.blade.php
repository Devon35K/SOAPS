<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
    <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.5rem; color: var(--maroon); text-transform: uppercase;">Create User</h3>
    <a href="{{ route('admin.users') }}" class="btn btn-secondary" style="text-decoration: none;">
        <i class='bx bx-arrow-back'></i> Back to Users
    </a>
</div>

<div class="data-table" style="padding: 24px;">
    @if ($errors->any())
        <div style="background: rgba(122,20,40,.06); color: var(--maroon); padding: 12px; border-radius: 6px; margin-bottom: 20px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                    <li style="font-size: 0.85rem;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.users.store') }}">
        @csrf
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Student / Staff ID</label>
                <input type="text" name="student_id" value="{{ old('student_id') }}" required style="width: 100%; padding: 10px; border: 1px solid rgba(0,0,0,0.1); border-radius: 4px; font-family: 'Barlow', sans-serif;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Full Name</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" required style="width: 100%; padding: 10px; border: 1px solid rgba(0,0,0,0.1); border-radius: 4px; font-family: 'Barlow', sans-serif;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px; border: 1px solid rgba(0,0,0,0.1); border-radius: 4px; font-family: 'Barlow', sans-serif;">
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Role</label>
                <select name="user_type" required style="width: 100%; padding: 10px; border: 1px solid rgba(0,0,0,0.1); border-radius: 4px; font-family: 'Barlow', sans-serif;">
                    <option value="" disabled selected>Select Role</option>
                    <option value="student" {{ old('user_type') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="alumni" {{ old('user_type') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                    <option value="admin" {{ old('user_type') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('user_type') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-size: 0.8rem; font-weight: 600; color: var(--text-muted); margin-bottom: 6px; text-transform: uppercase;">Password</label>
                <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid rgba(0,0,0,0.1); border-radius: 4px; font-family: 'Barlow', sans-serif;">
            </div>
            
        </div>

        <div style="text-align: right; margin-top: 30px;">
            <button type="submit" class="btn btn-primary" style="padding: 10px 24px; font-size: 0.9rem;">
                <i class='bx bx-save'></i> Save User
            </button>
        </div>
    </form>
</div>
