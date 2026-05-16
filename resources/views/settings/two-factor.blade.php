@extends('settings.layout')

@section('settings-content')
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Two-Factor Authentication</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Add additional security to your account using two-factor authentication.</p>

    @if(!$twoFactorEnabled)
        {{-- Enable 2FA --}}
        <div style="background: rgba(245,243,238,0.5); padding: 24px; border: 1px solid rgba(0,0,0,0.05); clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
            <p style="margin-bottom: 20px; font-weight: 500;">You have not enabled two-factor authentication.</p>
            <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Enable 2FA</button>
            </form>
        </div>
    @else
        @if(auth()->user()->two_factor_confirmed_at)
            {{-- 2FA is Active --}}
            <div style="background: #dcfce7; color: #166534; padding: 16px; border-radius: 4px; margin-bottom: 24px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                <i class='bx bxs-check-shield' style="font-size: 1.5rem;"></i> Two-factor authentication is active.
            </div>

            <div style="display: flex; gap: 12px;">
                <form method="POST" action="{{ url('user/two-factor-authentication') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline" style="border-color: #EF4444; color: #EF4444;">Disable 2FA</button>
                </form>

                <form method="POST" action="{{ url('user/two-factor-recovery-codes') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline">Regenerate Recovery Codes</button>
                </form>
            </div>

            {{-- Show Recovery Codes if needed --}}
            @if(session('status') == 'recovery-codes-generated')
                <div style="margin-top: 32px; padding: 24px; background: #1a1a1a; color: white; border-radius: 4px;">
                    <h4 style="font-family: 'Barlow Condensed'; text-transform: uppercase; margin-bottom: 12px; color: var(--gold);">Recovery Codes</h4>
                    <p style="font-size: 0.8rem; margin-bottom: 16px; opacity: 0.8;">Store these securely. They can be used to access your account if your device is lost.</p>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; font-family: monospace;">
                        @foreach (auth()->user()->recoveryCodes() as $code)
                            <div style="background: rgba(255,255,255,0.1); padding: 8px; text-align: center;">{{ $code }}</div>
                        @endforeach
                    </div>
                </div>
            @endif
        @else
            {{-- Confirming 2FA (QR Code Shown) --}}
            <div style="background: #fffbeb; border: 1px solid #fef3c7; padding: 24px; margin-bottom: 24px;">
                <h4 style="font-family: 'Barlow Condensed'; text-transform: uppercase; color: #92400e; margin-bottom: 16px;">Finish Enabling 2FA</h4>
                
                <div style="display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap;">
                    <div style="background: white; padding: 16px; border: 1px solid #ddd;">
                        {!! auth()->user()->twoFactorQrCodeSvg() !!}
                    </div>
                    
                    <div style="flex: 1; min-width: 280px;">
                        <p style="margin-bottom: 16px; font-size: 0.9rem;">Scan this QR code with your authenticator app (Google Authenticator, Authy, etc.) and enter the 6-digit code below to confirm.</p>
                        
                        <form method="POST" action="{{ url('user/confirmed-two-factor-authentication') }}">
                            @csrf
                            <div style="margin-bottom: 16px;">
                                <label style="display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 8px;">Authentication Code</label>
                                <input type="text" name="code" class="form-control" placeholder="000000" required style="width: 100%; padding: 12px 16px; border: 2px solid #ddd; outline: none; font-family: monospace;">
                            </div>
                            <button type="submit" class="btn btn-primary">Confirm & Activate</button>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
