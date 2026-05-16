@extends('settings.layout')

@section('settings-content')
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Update Password</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Ensure your account is using a long, random password to stay secure.</p>
    
    @php
        $showSuccess = session('status') || session('success');
        $successText = session('status') == 'password-updated' ? 'Password updated successfully!' : (session('status') ?: session('success'));
    @endphp

    @if ($showSuccess)
        <div style="background: #D1FAE5; border-left: 5px solid #10B981; padding: 20px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); animation: slideDown 0.4s ease-out;">
            <p style="color: #065F46; font-weight: 800; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; letter-spacing: 1px; display: flex; align-items: center; gap: 10px; margin: 0;">
                <i class='bx bx-check-circle' style="font-size: 1.5rem;"></i>
                {{ $successText }}
            </p>
        </div>
        <style> @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } } </style>
    @endif

    @if ($errors->updatePassword->any())
        <div style="background: rgba(122,20,40,0.05); border-left: 4px solid var(--maroon); padding: 16px; margin-bottom: 24px;">
            <p style="color: var(--maroon); font-weight: 700; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Update Failed</p>
            <ul style="list-style: none; color: var(--text-muted); font-size: 0.85rem;">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('user-password.update') }}">
        @csrf
        @method('PUT')

        <div style="display: flex; flex-direction: column; gap: 20px; max-width: 500px;">
            <div>
                <label for="current_password" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required autocomplete="current-password" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">

            </div>

            <div>
                <label for="password" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="new-password" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">

            </div>

            <div>
                <label for="password_confirmation" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">

            </div>

            <div style="margin-top: 8px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>
@endsection
