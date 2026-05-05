@extends('user.layout', ['pageTitle' => 'Update ', 'pageTitleSpan' => 'Profile'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>My <span>Personal</span> Details</h2>
        <p>Keep your contact information and sports affiliation up to date so the sports unit can reach you easily.</p>
    </div>

    <div class="data-table" style="padding: 32px; border-top: 4px solid var(--maroon);">
        <form method="POST" action="#">
            @csrf
            @method('PUT')
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
                <!-- Full Name -->
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Full Name</label>
                    <input type="text" name="full_name" value="{{ $user->full_name ?? '' }}" class="form-control" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                </div>

                <!-- Email Address -->
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email ?? '' }}" class="form-control" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);" readonly>
                    <p style="font-size: 0.75rem; color: var(--text-muted); margin-top: 6px;">Email address cannot be changed.</p>
                </div>

                <!-- Sport -->
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Primary Sport</label>
                    <select name="sport" class="form-control" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="Basketball" {{ ($user->sport ?? '') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                        <option value="Volleyball" {{ ($user->sport ?? '') == 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                        <option value="Football" {{ ($user->sport ?? '') == 'Football' ? 'selected' : '' }}>Football</option>
                        <option value="Athletics" {{ ($user->sport ?? '') == 'Athletics' ? 'selected' : '' }}>Athletics</option>
                        <option value="Swimming" {{ ($user->sport ?? '') == 'Swimming' ? 'selected' : '' }}>Swimming</option>
                    </select>
                </div>

                <!-- Campus -->
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Campus</label>
                    <select name="campus" class="form-control" style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="Tagum" {{ ($user->campus ?? '') == 'Tagum' ? 'selected' : '' }}>Tagum</option>
                        <option value="Mabini" {{ ($user->campus ?? '') == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 16px; padding-top: 16px; border-top: 1px solid rgba(0,0,0,0.06);">
                <a href="{{ route('user.dashboard') }}" class="btn btn-outline" style="border-color: rgba(61,42,47,.2); color: var(--text-muted);"><i class='bx bx-x'></i> Cancel</a>
                <button type="submit" class="btn btn-primary"><i class='bx bx-save'></i> Save Changes</button>
            </div>
        </form>
    </div>
@endsection
