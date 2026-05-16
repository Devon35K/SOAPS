@extends('settings.layout')

@section('settings-content')
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Two-Factor Authentication</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Add additional security to your account using two-factor authentication.</p>

    <div class="alert" style="background: rgba(240,180,41,0.1); border-left: 4px solid var(--gold); color: var(--charcoal); padding: 12px 16px;">
        <i class='bx bx-lock'></i> Two-factor authentication configuration is currently managed by the system administrator. Contact support if you need to reset your 2FA settings.
    </div>
@endsection
