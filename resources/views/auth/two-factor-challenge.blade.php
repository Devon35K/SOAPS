<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Two-Factor Authentication — USeP OSAS Sports Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/SportOffice.png" sizes="any" />
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
        .page { display: grid; grid-template-columns: 0.9fr 1.1fr; height: 100vh; overflow: hidden; }

        /* ── LEFT PANEL ── */
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
        .left-content { position: relative; z-index: 2; transition: all .8s ease; }
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
        .left-footer { position: relative; z-index: 2; display: flex; justify-content: space-between; align-items: center; padding-top: 14px; border-top: 1px solid rgba(255,255,255,.06); }
        .left-footer p, .left-footer a { font-size: .7rem; color: rgba(255,255,255,.22); text-decoration: none; }
        .left-footer a:hover { color: var(--gold); }

        /* ── RIGHT PANEL ── */
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
            position: absolute; inset: -50px;
            background-image: url('/image/background.png');
            background-size: cover;
            background-position: center;
            opacity: 0.15;
            pointer-events: none;
            transform: scale(1.3);
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
        .form-fields { display: flex; flex-direction: column; gap: 18px; }
        .field-lbl { font-size: .68rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px; }
        
        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-wrap i.icon { position: absolute; left: 14px; font-size: 1.1rem; color: var(--text-muted); pointer-events: none; transition: color .2s; }
        .input-wrap input {
            width: 100%; padding: 14px 14px 14px 42px;
            border: 2px solid rgba(61,42,47,.12); border-radius: 0;
            background: var(--white); font-family: 'Barlow', sans-serif;
            font-size: .9rem; font-weight: 500; color: var(--charcoal); outline: none;
            transition: border-color .2s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .input-wrap input::placeholder { color: rgba(61,42,47,.28); font-weight: 400; }
        .input-wrap input:focus { border-color: var(--maroon); }

        /* Monospace OTP Specific Class */
        .otp-input {
            font-family: monospace !important;
            font-size: 1.25rem !important;
            letter-spacing: 4px;
            font-weight: 700 !important;
            text-align: center;
            padding-left: 14px !important; /* Center the letters */
        }

        .btn-login {
            margin-top: 8px; width: 100%; padding: 15px 20px; border: none;
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
        
        .signup-row { margin-top: 22px; text-align: center; font-size: .82rem; color: var(--text-muted); }
        .signup-row button { border: none; background: none; color: var(--maroon); font-weight: 700; text-transform: uppercase; font-size: .76rem; letter-spacing: .5px; cursor: pointer; text-decoration: underline; }
        .signup-row button:hover { color: var(--maroon-mid); }

        .hidden { display: none !important; }

        @media (max-width: 840px) {
            html, body { overflow: auto; }
            .page { grid-template-columns: 1fr; height: auto; }
            .left-panel { padding: 36px 28px 28px; min-height: 240px; }
            .big-number, .form-number { display: none; }
            .right-panel { padding: 40px 28px 56px; }
        }

        .login-card { opacity: 0; transform: translateY(30px); transition: all .8s cubic-bezier(0.22, 1, 0.36, 1) .2s; }
        .page-loaded .login-card { opacity: 1; transform: translateY(0); }
        .left-content { opacity: 0; transform: translateX(-30px); transition: all .8s cubic-bezier(0.22, 1, 0.36, 1) .2s; }
        .page-loaded .left-content { opacity: 1; transform: translateX(0); }
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
        <div class="big-number">02</div>
        <div class="left-content">
            <div class="logo-row">
                <div class="logo-badge"><img src="/image/SportOffice.png" alt="Sports Office"></div>
                <div class="logo-badge"><img src="/image/Usep.png" alt="USeP"></div>
                <div class="logo-name">USeP OSAS<br>Sports Unit</div>
            </div>
            <span class="headline-tag">Security Layer</span>
            <h1 class="headline">Secure<br><span class="gold-word">Identity.</span></h1>
            <p class="tagline">An additional layer of protection ensuring your records, events and credentials remain safe.</p>
        </div>
        <div class="left-footer">
            <p>© 2026 USeP. All Rights Reserved.</p>
            <div><a href="#">Terms</a> · <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank">Privacy</a></div>
        </div>
    </div>

    <div class="right-panel">
        <div class="bg-image"></div>
        <div class="login-card">
            <div class="form-number">02</div>
            
            <p id="challenge-eyebrow" class="form-eyebrow">Security Verification</p>
            <h2 id="challenge-title" class="form-title">Security<br><span>Verify.</span></h2>
            <p id="challenge-desc" class="form-desc">Please confirm access to your account by entering the code from your authenticator app.</p>

            @if($errors->any())
                <div class="server-error">
                    <i class='bx bx-error-circle'></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ url('/two-factor-challenge') }}">
                @csrf
                <div class="form-fields">
                    
                    {{-- OTP Code section --}}
                    <div id="otp-section">
                        <label class="field-lbl">Authentication Code</label>
                        <div class="input-wrap">
                            <i class='bx bx-shield-quarter icon'></i>
                            <input type="text" name="code" id="otp-code-input" class="otp-input" placeholder="000000" maxlength="6" inputmode="numeric" autocomplete="one-time-code" autofocus>
                        </div>
                    </div>

                    {{-- Recovery Code section (hidden by default) --}}
                    <div id="recovery-section" class="hidden">
                        <label class="field-lbl">Emergency Recovery Code</label>
                        <div class="input-wrap">
                            <i class='bx bx-key icon'></i>
                            <input type="text" name="recovery_code" id="recovery-code-input" placeholder="Enter one of your emergency recovery codes" autocomplete="off" disabled>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">Verify &amp; Continue</button>
                </div>
            </form>

            <div class="signup-row">
                <span id="toggle-label">Lost your device? </span>
                <button type="button" id="toggle-challenge-btn" onclick="toggleChallengeMode()">Use an emergency recovery code</button>
            </div>

            <div style="margin-top: 24px; text-align: center; border-top: 1px solid rgba(61,42,47,0.08); padding-top: 20px;">
                <a href="{{ route('login') }}" style="display: inline-flex; align-items: center; gap: 6px; font-family: 'Barlow Condensed', sans-serif; font-size: 0.9rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; text-decoration: none; letter-spacing: 1px; transition: color 0.2s;" onmouseover="this.style.color='var(--maroon)'" onmouseout="this.style.color='var(--text-muted)'">
                    <i class='bx bx-left-arrow-alt' style="font-size: 1.25rem;"></i> Back to Login
                </a>
            </div>
        </div>
    </div>

</div>

<script>
    // Trigger transition when page is fully loaded
    window.addEventListener('DOMContentLoaded', () => {
        document.body.classList.add('page-loaded');
    });

    let isRecoveryMode = false;

    function toggleChallengeMode() {
        isRecoveryMode = !isRecoveryMode;

        const otpSection = document.getElementById('otp-section');
        const recoverySection = document.getElementById('recovery-section');
        const otpInput = document.getElementById('otp-code-input');
        const recoveryInput = document.getElementById('recovery-code-input');

        const eyebrow = document.getElementById('challenge-eyebrow');
        const title = document.getElementById('challenge-title');
        const desc = document.getElementById('challenge-desc');
        const toggleBtn = document.getElementById('toggle-challenge-btn');
        const toggleLabel = document.getElementById('toggle-label');

        if (isRecoveryMode) {
            // Switch to Recovery Code Mode
            otpSection.classList.add('hidden');
            recoverySection.classList.remove('hidden');

            otpInput.disabled = true;
            recoveryInput.disabled = false;

            eyebrow.textContent = "Recovery Verification";
            title.innerHTML = "Recovery<br><span>Verify.</span>";
            desc.textContent = "Please confirm access to your account by entering one of your single-use emergency recovery codes.";
            toggleLabel.textContent = "Found your device? ";
            toggleBtn.textContent = "Use authenticator app code";
            
            setTimeout(() => recoveryInput.focus(), 50);
        } else {
            // Switch to OTP Code Mode
            otpSection.classList.remove('hidden');
            recoverySection.classList.add('hidden');

            otpInput.disabled = false;
            recoveryInput.disabled = true;

            eyebrow.textContent = "Security Verification";
            title.innerHTML = "Security<br><span>Verify.</span>";
            desc.textContent = "Please confirm access to your account by entering the code from your authenticator app.";
            toggleLabel.textContent = "Lost your device? ";
            toggleBtn.textContent = "Use an emergency recovery code";

            setTimeout(() => otpInput.focus(), 50);
        }
    }
</script>
</body>
</html>
