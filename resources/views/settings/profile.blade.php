@extends('settings.layout')

@section('settings-content')
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Profile Information</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Update your account's profile information and email address.</p>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" style="background: rgba(16,185,129,0.08); border-left: 4px solid #10B981; color: #065F46; padding: 12px 16px; margin-bottom: 20px;">
            Profile updated successfully.
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div style="display: flex; flex-direction: column; gap: 20px; max-width: 500px;">
            <div>
                <label for="name" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? Auth::user()->full_name) }}" required autofocus autocomplete="name" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                @error('name')
                    <span style="color: #EF4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label for="email" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                @error('email')
                    <span style="color: #EF4444; font-size: 0.8rem; margin-top: 4px; display: block;">{{ $message }}</span>
                @enderror
            </div>

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !Auth::user()->hasVerifiedEmail())
                <div>
                    <p style="font-size: 0.85rem; color: var(--text-muted); margin-top: 8px;">
                        Your email address is unverified.
                        <button form="send-verification" style="background: none; border: none; color: var(--maroon); text-decoration: underline; cursor: pointer; padding: 0; font: inherit;">
                            Click here to resend the verification email.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="color: #10B981; font-size: 0.85rem; font-weight: 500; margin-top: 8px;">
                            A new verification link has been sent to your email address.
                        </p>
                    @endif
                </div>
            @endif

            <div style="margin-top: 8px;">
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </div>
    </form>

    <!-- Hidden form for resending verification email -->
    <form id="send-verification" method="POST" action="{{ route('verification.send') }}">
        @csrf
    </form>
@endsection
