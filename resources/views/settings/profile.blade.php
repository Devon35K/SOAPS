@extends('settings.layout')

@section('settings-content')
    <h3 style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.5rem; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Profile Information</h3>
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 24px;">Update your account's profile information and email address.</p>    @php
        $showSuccess = session('status') || session('success');
        $successText = session('status') == 'profile-updated' ? 'Profile updated successfully!' : (session('status') ?: session('success'));
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

    @if ($errors->any())
        <div style="background: rgba(122,20,40,0.05); border-left: 4px solid var(--maroon); padding: 16px; margin-bottom: 24px;">
            <p style="color: var(--maroon); font-weight: 700; font-family: 'Barlow Condensed', sans-serif; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;">Update Failed</p>
            <ul style="list-style: none; color: var(--text-muted); font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        @method('PATCH')

        <div style="display: flex; flex-direction: column; gap: 20px; max-width: 500px;">
            <div>
                <label for="full_name" style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Full Name</label>
                <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name', Auth::user()->full_name) }}" required autofocus autocomplete="name" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                @error('full_name')
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

            @if(Auth::user()->role === 'user')
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Primary Sport</label>
                    <select name="sport" class="form-control" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="Athletics" {{ old('sport', Auth::user()->sport) == 'Athletics' ? 'selected' : '' }}>Athletics</option>
                        <option value="Badminton" {{ old('sport', Auth::user()->sport) == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                        <option value="Basketball" {{ old('sport', Auth::user()->sport) == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                        <option value="Cheerleading" {{ old('sport', Auth::user()->sport) == 'Cheerleading' ? 'selected' : '' }}>Cheerleading</option>
                        <option value="Chess" {{ old('sport', Auth::user()->sport) == 'Chess' ? 'selected' : '' }}>Chess</option>
                        <option value="Dance Sports" {{ old('sport', Auth::user()->sport) == 'Dance Sports' || old('sport', Auth::user()->sport) == 'Dance' ? 'selected' : '' }}>Dance Sports</option>
                        <option value="ESports" {{ old('sport', Auth::user()->sport) == 'ESports' ? 'selected' : '' }}>ESports</option>
                        <option value="Football" {{ old('sport', Auth::user()->sport) == 'Football' ? 'selected' : '' }}>Football</option>
                        <option value="Sepak Takraw" {{ old('sport', Auth::user()->sport) == 'Sepak Takraw' ? 'selected' : '' }}>Sepak Takraw</option>
                        <option value="Swimming" {{ old('sport', Auth::user()->sport) == 'Swimming' ? 'selected' : '' }}>Swimming</option>
                        <option value="Table Tennis" {{ old('sport', Auth::user()->sport) == 'Table Tennis' ? 'selected' : '' }}>Table Tennis</option>
                        <option value="Taekwondo" {{ old('sport', Auth::user()->sport) == 'Taekwondo' ? 'selected' : '' }}>Taekwondo</option>
                        <option value="Tennis" {{ old('sport', Auth::user()->sport) == 'Tennis' ? 'selected' : '' }}>Tennis</option>
                        <option value="Volleyball" {{ old('sport', Auth::user()->sport) == 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                        <option value="Wrestling" {{ old('sport', Auth::user()->sport) == 'Wrestling' ? 'selected' : '' }}>Wrestling</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Campus/Unit</label>
                    <select name="campus" class="form-control" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="Tagum" {{ old('campus', Auth::user()->campus) == 'Tagum' ? 'selected' : '' }}>Tagum</option>
                        <option value="Mabini" {{ old('campus', Auth::user()->campus) == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                    </select>
                </div>
            @endif

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
