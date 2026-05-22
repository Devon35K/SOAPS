@extends(Auth::user()->role === 'admin' || Auth::user()->role === 'super_admin' ? 'admin.layout' : 'user.layout', [
    'pageTitle' => 'Security ',
    'pageTitleSpan' => 'Check',
    'currentPage' => 'Security Check'
])

@section('content')
    <div style="max-width: 480px; margin: 40px auto;">
        <div class="search-form animate-pop" style="padding: 40px; border-top: 4px solid var(--maroon); background: white; box-shadow: 0 8px 25px rgba(0,0,0,0.04); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); position: relative;">
            <div style="text-align: center; margin-bottom: 28px;">
                <div style="width: 64px; height: 64px; border-radius: 50%; background: rgba(122,20,40,.06); border: 2px solid var(--maroon); display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 2rem; color: var(--maroon);">
                    <i class='bx bx-lock-alt'></i>
                </div>
                <h2 style="font-family: 'Barlow Condensed', sans-serif; font-size: 2rem; font-weight: 800; text-transform: uppercase; color: var(--charcoal); letter-spacing: -0.5px; margin-bottom: 8px;">Security <span style="color: var(--maroon);">Check</span></h2>
                <p style="font-size: 0.88rem; color: var(--text-muted); line-height: 1.5; margin: 0 auto; max-width: 320px;">For your security, please confirm your password to continue.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                
                <div style="margin-bottom: 28px;">
                    <label for="password" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.75rem; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password" autofocus style="width: 100%; padding: 13px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; font-size: 0.95rem; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                    @error('password')
                        <span style="color: #EF4444; font-size: 0.8rem; margin-top: 6px; display: block; font-weight: 500;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 16px;">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline" style="background: transparent !important; color: var(--maroon) !important; border: 2px solid var(--maroon) !important; padding: 11px 20px !important; text-decoration: none !important; display: inline-flex !important; align-items: center !important; justify-content: center !important; font-family: 'Barlow Condensed', sans-serif !important; font-weight: 800 !important; font-size: 0.95rem !important; letter-spacing: 1.5px !important; text-transform: uppercase !important; clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px)) !important; transition: all 0.2s !important; box-shadow: none !important; transform: none !important;">Cancel</a>
                    <button type="submit" class="btn btn-primary" style="display: inline-flex !important; align-items: center !important; justify-content: center !important; padding: 13px 22px !important; font-family: 'Barlow Condensed', sans-serif !important; font-weight: 800 !important; font-size: 0.95rem !important; letter-spacing: 1.5px !important; text-transform: uppercase !important; border: none !important; clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px)) !important; background: var(--maroon) !important; color: var(--white) !important; cursor: pointer !important; transition: all 0.2s !important; box-shadow: none !important; transform: none !important;">Confirm Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
