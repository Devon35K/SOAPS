@extends('user.layout', ['pageTitle' => 'Security ', 'pageTitleSpan' => 'Check'])

@section('content')
    <div style="max-width: 500px; margin: 40px auto;">
        <div class="welcome-card" style="margin-bottom: 24px; text-align: center;">
            <div style="font-size: 3rem; color: var(--gold); margin-bottom: 16px;">
                <i class='bx bx-lock-alt'></i>
            </div>
            <h2>Security <span>Check</span></h2>
            <p>For your security, please confirm your password to continue.</p>
        </div>

        <div class="data-table" style="padding: 32px; border-top: 4px solid var(--maroon);">
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                
                <div style="margin-bottom: 24px;">
                    <label for="password" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" autofocus style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                    @error('password')
                        <span style="color: #EF4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 16px;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline">Cancel</a>
                    <button type="submit" class="btn btn-primary">Confirm Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
