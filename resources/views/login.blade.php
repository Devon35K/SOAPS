<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — USeP OSAS Sports Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/Usep.png" sizes="any" />
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --maroon:      #7A1428;
            --maroon-dark: #500D1A;
            --maroon-mid:  #9C1E35;
            --gold:        #F0B429;
            --gold-dark:   #C48F10;
            --offwhite:    #F5F3EE;
            --charcoal:    #1C1410;
            --text-body:   #3D2A2F;
            --text-muted:  #7A5C64;
            --white:       #FFFFFF;
        }
        html, body { height: 100%; font-family: 'Barlow', sans-serif; background: var(--offwhite); overflow: hidden; }
        .page { display: grid; grid-template-columns: 1.1fr 0.9fr; height: 100vh; }

        /* ── LEFT ── */
        .left-panel {
            position: relative; background: var(--maroon-dark); overflow: hidden;
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 44px 52px 36px;
        }
        .gold-bar { position: absolute; top: 0; left: 0; right: 0; height: 5px; background: linear-gradient(90deg, var(--gold) 0%, var(--gold-dark) 60%, transparent 100%); }
        .slash { position: absolute; top: 0; right: -60px; width: 180px; height: 100%; background: var(--maroon-mid); transform: skewX(-8deg); pointer-events: none; }
        .slash-2 { right: -120px; background: rgba(255,255,255,.03); width: 200px; }
        .speed-bg { position: absolute; inset: 0; width: 100%; height: 100%; pointer-events: none; }
        .big-number {
            font-family: 'Barlow Condensed', sans-serif; font-size: clamp(5rem, 10vw, 9rem);
            font-weight: 900; line-height: .85; color: rgba(255,255,255,.06); letter-spacing: -4px;
            position: absolute; top: 140px; left: 44px; pointer-events: none; user-select: none;
        }
        .left-content { position: relative; z-index: 2; }
        .logo-row { display: flex; align-items: center; gap: 14px; margin-bottom: 52px; }
        .logo-badge {
            width: 46px; height: 46px; border-radius: 6px;
            background: rgba(255,255,255,.09); border: 1px solid rgba(240,180,41,.22);
            display: flex; align-items: center; justify-content: center; overflow: hidden;
        }
        .logo-badge img { width: 32px; height: 32px; object-fit: contain; filter: drop-shadow(0 1px 3px rgba(0,0,0,.4)); }
        .logo-name { font-family: 'Barlow Condensed', sans-serif; font-size: .75rem; font-weight: 700; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(240,180,41,.75); line-height: 1.35; }
        .headline-tag {
            display: inline-block; font-family: 'Barlow Condensed', sans-serif; font-size: .68rem;
            font-weight: 700; letter-spacing: 3px; text-transform: uppercase; color: var(--gold);
            background: rgba(240,180,41,.1); border: 1px solid rgba(240,180,41,.28);
            border-radius: 3px; padding: 4px 10px; margin-bottom: 14px;
        }
        .headline {
            font-family: 'Barlow Condensed', sans-serif; font-size: clamp(2.8rem, 4.5vw, 4.2rem);
            font-weight: 900; line-height: .95; color: var(--white); text-transform: uppercase; letter-spacing: -1px;
        }
        .headline .gold-word { color: var(--gold); display: block; }
        .tagline { margin-top: 20px; font-size: .88rem; font-weight: 300; color: rgba(255,255,255,.42); line-height: 1.65; max-width: 280px; }
        .stat-strip { display: flex; margin-top: 34px; border-top: 1px solid rgba(255,255,255,.08); padding-top: 22px; }
        .stat-item { flex: 1; padding-right: 18px; }
        .stat-item + .stat-item { border-left: 1px solid rgba(255,255,255,.08); padding-left: 18px; padding-right: 0; }
        .stat-val { font-family: 'Barlow Condensed', sans-serif; font-size: 1.75rem; font-weight: 800; color: var(--gold); line-height: 1; }
        .stat-lbl { font-size: .68rem; font-weight: 400; color: rgba(255,255,255,.32); text-transform: uppercase; letter-spacing: 1.2px; margin-top: 4px; }
        .left-footer { position: relative; z-index: 2; display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid rgba(255,255,255,.06); }
        .left-footer p, .left-footer a { font-size: .7rem; color: rgba(255,255,255,.22); text-decoration: none; }
        .left-footer a:hover { color: var(--gold); }

        /* ── RIGHT ── */
        .right-panel {
            display: flex; align-items: center; justify-content: center;
            background: var(--offwhite); padding: 40px 52px; position: relative;
        }
        .right-panel::before {
            content: ''; position: absolute; bottom: 0; right: 0; width: 240px; height: 240px;
            background-image: radial-gradient(circle, rgba(122,20,40,.1) 1.5px, transparent 1.5px);
            background-size: 14px 14px; pointer-events: none;
        }
        .right-panel::after {
            content: ''; position: absolute; top: -40px; right: -80px;
            width: 220px; height: 120%; background: rgba(122,20,40,.035);
            transform: skewX(-8deg); pointer-events: none;
        }
        .right-panel .bg-image {
            position: absolute; inset: 0;
            background-image: url('/image/background.png');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            pointer-events: none;
        }
        .login-card { width: 100%; max-width: 380px; position: relative; z-index: 1; animation: slideUp .6s cubic-bezier(.22,.9,.42,1) both; }
        @keyframes slideUp { from { opacity:0; transform:translateY(20px); } to { opacity:1; transform:translateY(0); } }
        .form-number {
            font-family: 'Barlow Condensed', sans-serif; font-size: 6rem; font-weight: 900;
            color: rgba(122,20,40,.055); line-height: 1; position: absolute; top: -30px; right: -20px;
            letter-spacing: -4px; user-select: none; pointer-events: none;
        }
        .form-eyebrow {
            font-family: 'Barlow Condensed', sans-serif; font-size: .7rem; font-weight: 700;
            letter-spacing: 3px; text-transform: uppercase; color: var(--maroon);
            margin-bottom: 8px; display: flex; align-items: center; gap: 8px;
        }
        .form-eyebrow::before { content: ''; display: inline-block; width: 20px; height: 3px; background: var(--gold); border-radius: 2px; flex-shrink: 0; }
        .form-title { font-family: 'Barlow Condensed', sans-serif; font-size: 3rem; font-weight: 900; line-height: .95; text-transform: uppercase; color: var(--charcoal); letter-spacing: -1px; margin-bottom: 6px; }
        .form-title span { color: var(--maroon); }
        .form-desc { font-size: .84rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 26px; }
        .server-error { display: flex; align-items: center; gap: 10px; background: rgba(122,20,40,.07); border-left: 3px solid var(--maroon); border-radius: 0 6px 6px 0; padding: 11px 14px; font-size: .82rem; color: var(--maroon); font-weight: 600; margin-bottom: 20px; }
        .error-messages { padding: 11px 14px; border-radius: 6px; background: rgba(122,20,40,.06); font-size: .82rem; color: var(--maroon); margin-bottom: 16px; }
        .error-messages p { line-height: 1.8; }
        .form-fields { display: flex; flex-direction: column; gap: 14px; }
        .field-lbl { font-size: .68rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px; }
        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-wrap i.icon { position: absolute; left: 14px; font-size: 1.1rem; color: var(--text-muted); pointer-events: none; transition: color .2s; }
        .input-wrap input {
            width: 100%; padding: 13px 14px 13px 42px;
            border: 2px solid rgba(61,42,47,.12); border-radius: 0;
            background: var(--white); font-family: 'Barlow', sans-serif;
            font-size: .9rem; font-weight: 500; color: var(--charcoal); outline: none;
            transition: border-color .2s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .input-wrap input::placeholder { color: rgba(61,42,47,.28); font-weight: 400; }
        .input-wrap input:focus { border-color: var(--maroon); }
        .toggle-password { position: absolute; right: 14px; font-size: 1rem; color: var(--text-muted); cursor: pointer; transition: color .2s; }
        .toggle-password:hover { color: var(--maroon); }
        .forgot-row { display: flex; justify-content: flex-end; margin-top: -4px; }
        .forgot-link { font-size: .76rem; font-weight: 600; color: var(--text-muted); text-decoration: none; letter-spacing: .3px; transition: color .2s; }
        .forgot-link:hover { color: var(--maroon); }
        .btn-login {
            margin-top: 4px; width: 100%; padding: 15px 20px; border: none;
            background: var(--maroon); color: var(--white);
            font-family: 'Barlow Condensed', sans-serif; font-size: 1.1rem; font-weight: 800;
            letter-spacing: 2px; text-transform: uppercase; cursor: pointer;
            position: relative; overflow: hidden; transition: background .2s, transform .1s;
            clip-path: polygon(0 0, calc(100% - 12px) 0, 100% 12px, 100% 100%, 12px 100%, 0 calc(100% - 12px));
        }
        .btn-login::after { content: ''; position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: rgba(255,255,255,.1); transform: skewX(-20deg); transition: left .4s; }
        .btn-login:hover { background: var(--maroon-mid); }
        .btn-login:hover::after { left: 150%; }
        .btn-login:active { transform: scale(.98); }
        .btn-accent { height: 3px; background: linear-gradient(90deg, var(--gold), transparent); }
        .signup-row { margin-top: 20px; text-align: center; font-size: .82rem; color: var(--text-muted); }
        .signup-row a { color: var(--maroon); font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: .76rem; letter-spacing: .5px; }
        .signup-row a:hover { text-decoration: underline; }

        /* ── Modals ── */
        .modal-overlay, .privacy-modal-overlay { position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 100; opacity: 0; pointer-events: none; transition: opacity .25s; }
        .modal-overlay.active, .privacy-modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal { background: var(--white); border-top: 4px solid var(--gold); padding: 40px; max-width: 480px; width: 90%; position: relative; transform: scale(.95) translateY(12px); transition: transform .25s cubic-bezier(.22,.9,.42,1); max-height: 80vh; overflow-y: auto; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); }
        .modal-overlay.active .modal { transform: scale(1) translateY(0); }
        .modal h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 1.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--charcoal); margin-bottom: 20px; text-align: center; }
        .modal p { font-size: .88rem; color: var(--text-body); line-height: 1.7; margin-bottom: 14px; }
        .modal a { color: var(--maroon); font-weight: 600; }
        .close-button { position: absolute; top: 14px; right: 14px; border: none; background: rgba(122,20,40,.08); width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--maroon); font-size: 1.1rem; transition: background .2s; }
        .close-button:hover { background: rgba(122,20,40,.15); }
        .privacy-modal { background: var(--white); border-top: 4px solid var(--gold); padding: 44px 40px 36px; max-width: 400px; width: 90%; text-align: center; transform: scale(.95) translateY(12px); transition: transform .25s cubic-bezier(.22,.9,.42,1); clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); }
        .privacy-modal-overlay.active .privacy-modal { transform: scale(1) translateY(0); }
        .privacy-modal-image img { width: 110px; height: 110px; object-fit: contain; margin-bottom: 18px; }
        .privacy-modal h3 { font-size: .9rem; font-weight: 400; color: var(--text-body); line-height: 1.65; margin-bottom: 26px; }
        .privacy-link { color: var(--maroon); font-weight: 600; cursor: pointer; }
        .privacy-button { background: var(--maroon); color: #fff; border: none; padding: 13px 44px; font-family: 'Barlow Condensed', sans-serif; font-size: 1rem; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; cursor: pointer; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 10px 100%, 0 calc(100% - 10px)); transition: background .2s; }
        .privacy-button:hover { background: var(--maroon-mid); }

        @media (max-width: 840px) {
            html, body { overflow: auto; }
            .page { grid-template-columns: 1fr; height: auto; }
            .left-panel { padding: 36px 28px 28px; min-height: 240px; }
            .big-number, .stat-strip, .form-number { display: none; }
            .right-panel { padding: 40px 28px 56px; }
        }
    </style>
</head>
<body>
<div class="page">

    <div class="left-panel">
        <div class="gold-bar"></div>
        <div class="slash"></div>
        <div class="slash slash-2"></div>
        <svg class="speed-bg" viewBox="0 0 600 900" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
            <line x1="0" y1="650" x2="700" y2="200" stroke="rgba(255,255,255,.04)" stroke-width="1"/>
            <line x1="0" y1="700" x2="700" y2="250" stroke="rgba(255,255,255,.03)" stroke-width="1"/>
            <line x1="0" y1="750" x2="700" y2="300" stroke="rgba(255,255,255,.025)" stroke-width="1"/>
            <line x1="0" y1="600" x2="700" y2="150" stroke="rgba(240,180,41,.06)" stroke-width="1.5"/>
            <circle cx="460" cy="80" r="2" fill="rgba(240,180,41,.2)"/>
            <circle cx="490" cy="80" r="2" fill="rgba(240,180,41,.2)"/>
            <circle cx="520" cy="80" r="2" fill="rgba(240,180,41,.2)"/>
            <circle cx="460" cy="104" r="2" fill="rgba(240,180,41,.15)"/>
            <circle cx="490" cy="104" r="2" fill="rgba(240,180,41,.15)"/>
            <circle cx="520" cy="104" r="2" fill="rgba(240,180,41,.15)"/>
            <circle cx="460" cy="128" r="2" fill="rgba(240,180,41,.1)"/>
            <circle cx="490" cy="128" r="2" fill="rgba(240,180,41,.1)"/>
            <circle cx="520" cy="128" r="2" fill="rgba(240,180,41,.1)"/>
            <polygon points="0,820 180,900 0,900" fill="rgba(240,180,41,.12)"/>
            <polygon points="0,860 100,900 0,900" fill="rgba(240,180,41,.08)"/>
        </svg>
        <div class="big-number">01</div>
        <div class="left-content">
            <div class="logo-row">
                <div class="logo-badge"><img src="/image/SportOffice.png" alt="Sports Office"></div>
                <div class="logo-badge"><img src="/image/Usep.png" alt="USeP"></div>
                <div class="logo-name">USeP OSAS<br>Sports Unit</div>
            </div>
            <span class="headline-tag">Official Portal</span>
            <h1 class="headline">One Data.<br><span class="gold-word">One USeP.</span></h1>
            <p class="tagline">The centralized hub for student-athletes, competitions, records &amp; official sports events.</p>
            <div class="stat-strip">
                <div class="stat-item"><div class="stat-val">1</div><div class="stat-lbl">Unified Portal</div></div>
                <div class="stat-item"><div class="stat-val">100%</div><div class="stat-lbl">Secure Access</div></div>
                <div class="stat-item"><div class="stat-val">All</div><div class="stat-lbl">Data Central</div></div>
            </div>
        </div>
        <div class="left-footer">
            <p>© 2025 USeP. All Rights Reserved.</p>
            <div><a href="#" id="termsLink">Terms</a> · <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank">Privacy</a></div>
        </div>
    </div>

    <div class="right-panel">
        <div class="bg-image"></div>
        <div class="login-card">
            <div class="form-number">01</div>
            <p class="form-eyebrow">Student &amp; Staff Portal</p>
            <h2 class="form-title">Sign<br><span>In.</span></h2>

            @if(session('login_error'))
                <div class="server-error"><i class='bx bx-error-circle'></i>{{ session('login_error') }}</div>
            @else
                <p class="form-desc">Access your account and stay in the game.</p>
            @endif

            <div id="error-messages" class="error-messages" hidden></div>

            <form method="POST" action="{{ route('login.post') }}" onsubmit="return validateForm(event)" novalidate>
                @csrf
                <div class="form-fields">
                    <div>
                        <div class="field-lbl">Email</div>
                        <div class="input-wrap">
                            <i class='bx bx-envelope icon'></i>
                            <input type="email" name="email" placeholder="you@usep.edu.ph" value="{{ old('email') }}" required>
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Password</div>
                        <div class="input-wrap">
                            <i class='bx bx-lock-alt icon'></i>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                            <i class="bx bx-hide toggle-password" aria-label="Show password" role="button" tabindex="0"></i>
                        </div>
                    </div>
                    <div class="forgot-row">
                        <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                    </div>
                    <button type="submit" class="btn-login">Enter the Field</button>
                    <div class="btn-accent"></div>
                </div>
            </form>

            <p class="signup-row">No account? <a href="{{ route('register') }}">Join the Team</a></p>
        </div>
    </div>
</div>

<div class="modal-overlay" id="termsModal">
    <div class="modal">
        <button class="close-button" id="closeModal" aria-label="Close"><i class="bx bx-x"></i></button>
        <h2>Terms of Use</h2>
        <p>Welcome to the USeP OSAS-Sports Unit system. By accessing or using this website, you agree to be bound by the following terms and conditions:</p>
        <p>1. <strong>Account Responsibility:</strong> You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
        <p>2. <strong>Prohibited Activities:</strong> You may not use this system for any unlawful purpose or in any way that violates these terms, including unauthorized access or data manipulation.</p>
        <p>3. <strong>Data Privacy:</strong> We are committed to protecting your personal information. Please refer to our <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank">Privacy Policy</a> for details.</p>
        <p>For any questions or concerns, please contact the USeP OSAS-Sports Unit administration.</p>
    </div>
</div>

<div class="privacy-modal-overlay" id="privacyModal">
    <div class="privacy-modal">
        <div class="privacy-modal-image"><img src="/image/dataPrivacy.png" alt="Data privacy"></div>
        <h3>By continuing to use the Student Portal, you agree to the <span class="privacy-link" id="privacyLink">University of Southeastern Philippines' Data Privacy Statement</span>.</h3>
        <button class="privacy-button" id="continueButton">Continue</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const termsModal = document.getElementById('termsModal');
    document.getElementById('termsLink').addEventListener('click', e => { e.preventDefault(); termsModal.classList.add('active'); document.body.style.overflow = 'hidden'; });
    document.getElementById('closeModal').addEventListener('click', () => { termsModal.classList.remove('active'); document.body.style.overflow = ''; });
    termsModal.addEventListener('click', e => { if (e.target === termsModal) { termsModal.classList.remove('active'); document.body.style.overflow = ''; } });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && termsModal.classList.contains('active')) { termsModal.classList.remove('active'); document.body.style.overflow = ''; } });

    const toggle = document.querySelector('.toggle-password'), passInput = document.getElementById('password');
    if (toggle && passInput) {
        const flip = () => { const s = passInput.type === 'password'; passInput.type = s ? 'text' : 'password'; toggle.classList.toggle('bx-hide', s); toggle.classList.toggle('bx-show', !s); toggle.setAttribute('aria-label', s ? 'Hide password' : 'Show password'); };
        toggle.addEventListener('click', flip);
        toggle.addEventListener('keydown', e => { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); flip(); } });
    }

    const privacyModal = document.getElementById('privacyModal');
    if (sessionStorage.getItem('privacyModalShown')) { privacyModal.style.display = 'none'; }
    else {
        privacyModal.classList.add('active'); document.body.style.overflow = 'hidden';
        document.getElementById('continueButton').addEventListener('click', () => { sessionStorage.setItem('privacyModalShown', 'true'); privacyModal.classList.remove('active'); document.body.style.overflow = ''; });
    }
    const pl = document.getElementById('privacyLink');
    if (pl) pl.addEventListener('click', () => window.open('https://www.usep.edu.ph/usep-data-privacy-statement/', '_blank'));

    window.validateForm = function (event) {
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value;
        const box = document.getElementById('error-messages'); const msgs = [];
        box.innerHTML = ''; box.hidden = true;
        if (!email) msgs.push('Email is required.');
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) msgs.push('Please enter a valid email address.');
        if (!password) msgs.push('Password is required.');
        if (msgs.length) { box.hidden = false; msgs.forEach(m => { const p = document.createElement('p'); p.textContent = m; box.appendChild(p); }); event.preventDefault(); return false; }
        return true;
    };
});
</script>
</body>
</html>