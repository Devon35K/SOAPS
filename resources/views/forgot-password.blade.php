<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password — USeP OSAS Sports Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .form-title { font-family: 'Barlow Condensed', sans-serif; font-size: 2.8rem; font-weight: 900; line-height: .95; text-transform: uppercase; color: var(--charcoal); letter-spacing: -1px; margin-bottom: 6px; }
        .form-title span { color: var(--maroon); }
        .form-desc { font-size: .84rem; color: var(--text-muted); line-height: 1.55; margin-bottom: 26px; }
        .server-error { display: flex; align-items: center; gap: 10px; background: rgba(122,20,40,.07); border-left: 3px solid var(--maroon); border-radius: 0 6px 6px 0; padding: 11px 14px; font-size: .82rem; color: var(--maroon); font-weight: 600; margin-bottom: 20px; }
        .server-success { display: flex; align-items: center; gap: 10px; background: rgba(40,167,69,.1); border-left: 3px solid #28a745; border-radius: 0 6px 6px 0; padding: 11px 14px; font-size: .82rem; color: #28a745; font-weight: 600; margin-bottom: 20px; }
        .error-messages { padding: 11px 14px; border-radius: 6px; background: rgba(122,20,40,.06); font-size: .82rem; color: var(--maroon); margin-bottom: 16px; }
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
        .otp-section { display: none; flex-direction: column; gap: 14px; animation: slideUp .4s ease; }
        .otp-section.show { display: flex; }
        .otp-input-wrap { display: flex; gap: 8px; justify-content: space-between; }
        .otp-input {
            width: 100%;
            text-align: center;
            font-size: 1.2rem;
            letter-spacing: 2px;
            padding: 13px 10px;
        }
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
        .btn-login:disabled { opacity: 0.6; cursor: not-allowed; }
        .btn-login:disabled:hover { background: var(--maroon); }
        .btn-login:disabled:hover::after { left: -100%; }
        .btn-login.loading {
            position: relative;
            color: transparent;
        }
        .btn-login.loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid #ffffff;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spinner .8s linear infinite;
        }
        @keyframes spinner {
            to { transform: rotate(360deg); }
        }
        .btn-secondary {
            background: transparent;
            border: 2px solid var(--maroon);
            color: var(--maroon);
        }
        .btn-secondary:hover { background: rgba(122,20,40,.05); }
        .btn-accent { height: 3px; background: linear-gradient(90deg, var(--gold), transparent); }
        .back-link { margin-top: 20px; text-align: center; font-size: .82rem; color: var(--text-muted); }
        .back-link a { color: var(--maroon); font-weight: 700; text-decoration: none; text-transform: uppercase; font-size: .76rem; letter-spacing: .5px; }
        .back-link a:hover { text-decoration: underline; }

        /* ── Modals ── */
        .modal-overlay { position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 100; opacity: 0; pointer-events: none; transition: opacity .25s; }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal { background: var(--white); border-top: 4px solid var(--gold); padding: 40px; max-width: 480px; width: 90%; position: relative; transform: scale(.95) translateY(12px); transition: transform .25s cubic-bezier(.22,.9,.42,1); max-height: 80vh; overflow-y: auto; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); }
        .modal-overlay.active .modal { transform: scale(1) translateY(0); }
        .modal h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 1.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--charcoal); margin-bottom: 20px; text-align: center; }
        .modal p { font-size: .88rem; color: var(--text-body); line-height: 1.7; margin-bottom: 14px; }
        .modal a { color: var(--maroon); font-weight: 600; }
        .close-button { position: absolute; top: 14px; right: 14px; border: none; background: rgba(122,20,40,.08); width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--maroon); font-size: 1.1rem; transition: background .2s; }
        .close-button:hover { background: rgba(122,20,40,.15); }

        /* ── Reset Password Modal ── */
        .reset-modal-content { display: none; }
        .reset-modal-content.show { display: block; }

        @media (max-width: 840px) {
            html, body { overflow: auto; }
            .page { grid-template-columns: 1fr; height: auto; }
            .left-panel { padding: 36px 28px 28px; min-height: 240px; }
            .big-number, .stat-strip, .form-number { display: none; }
            .right-panel { padding: 40px 28px 56px; }
        }

        /* ── Unique Loading Animation ── */
        .loader-overlay {
            position: fixed; inset: 0; background: rgba(122, 20, 40, 0.95);
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            z-index: 1000; opacity: 0; pointer-events: none; transition: opacity .4s ease;
        }
        .loader-overlay.active { opacity: 1; pointer-events: all; }
        
        .loader-content { position: relative; display: flex; flex-direction: column; align-items: center; }
        
        .loader-logo {
            width: 80px; height: 80px; margin-bottom: 24px;
            filter: drop-shadow(0 0 15px rgba(240, 180, 41, 0.4));
            animation: pulse-logo 2s ease-in-out infinite;
        }
        
        .loader-spinner {
            width: 120px; height: 120px; border: 3px solid transparent;
            border-top: 3px solid var(--gold); border-radius: 50%;
            position: absolute; top: -20px;
            animation: spin 1.5s linear infinite;
        }
        .loader-spinner::before {
            content: ''; position: absolute; inset: 8px; border: 2px solid transparent;
            border-top: 2px solid var(--white); border-radius: 50%;
            animation: spin 2s linear infinite reverse;
        }
        
        .loader-text {
            font-family: 'Barlow Condensed', sans-serif; font-size: 1.2rem;
            font-weight: 800; color: var(--gold); text-transform: uppercase;
            letter-spacing: 4px; margin-top: 10px; animation: text-flicker 2s infinite;
        }
        
        .loader-bar-container {
            width: 200px; height: 2px; background: rgba(255,255,255,0.1);
            margin-top: 20px; border-radius: 2px; overflow: hidden;
        }
        .loader-bar {
            width: 40%; height: 100%; background: var(--gold);
            animation: bar-slide 1.5s ease-in-out infinite;
        }

        @keyframes pulse-logo {
            0%, 100% { transform: scale(1); opacity: 0.8; }
            50% { transform: scale(1.1); opacity: 1; }
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes text-flicker {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        @keyframes bar-slide {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(250%); }
        }
    </style>
</head>
<body>
    <!-- Unique Loading Loader -->
    <div class="loader-overlay" id="loadingOverlay">
        <div class="loader-content">
            <div class="loader-spinner"></div>
            <img src="/image/SportOffice.png" alt="Logo" class="loader-logo">
            <div class="loader-text">Processing Request</div>
            <div class="loader-bar-container">
                <div class="loader-bar"></div>
            </div>
        </div>
    </div>

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
        <div class="big-number">03</div>
        <div class="left-content">
            <div class="logo-row">
                <div class="logo-badge"><img src="/image/SportOffice.png" alt="Sports Office"></div>
                <div class="logo-badge"><img src="/image/Usep.png" alt="USeP"></div>
                <div class="logo-name">USeP OSAS<br>Sports Unit</div>
            </div>
            <span class="headline-tag">Account Recovery</span>
            <h1 class="headline">Reset.<br><span class="gold-word">Recover.</span></h1>
            <p class="tagline">Enter your email address and we'll send you a verification code to reset your password.</p>
        </div>
        <div class="left-footer">
            <p>© 2026 USeP. All Rights Reserved.</p>
            <div><a href="#" id="termsLink">Terms</a> · <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank">Privacy</a></div>
        </div>
    </div>

    <div class="right-panel">
        <div class="bg-image"></div>
        <div class="login-card">
            <div class="form-number">03</div>
            <p class="form-eyebrow">Password Recovery</p>
            <h2 class="form-title">Forgot<br><span>Password.</span></h2>

            @if(session('status'))
                <div class="server-success"><i class='bx bx-check-circle'></i>{{ session('status') }}</div>
            @else
                <p class="form-desc">Enter your email to receive a verification code.</p>
            @endif

            @if(session('error'))
                <div class="server-error"><i class='bx bx-error-circle'></i>{{ session('error') }}</div>
            @endif

            <div id="error-messages" class="error-messages" hidden></div>

            {{-- Step 1: Email Form --}}
            <form id="emailForm" class="form-fields" onsubmit="return false;">
                @csrf
                <div>
                    <div class="field-lbl">Email Address</div>
                    <div class="input-wrap">
                        <i class='bx bx-envelope icon'></i>
                        <input type="email" name="email" id="email" placeholder="you@usep.edu.ph" value="{{ old('email') }}" required autocomplete="email">
                    </div>
                </div>
                <button type="button" class="btn-login" id="send-otp-btn">Send Verification Code</button>
                <div class="btn-accent"></div>
            </form>

            {{-- Step 2: OTP Verification --}}
            <div id="otpSection" class="form-fields otp-section">
                <div>
                    <div class="field-lbl">Verification Code</div>
                    <div class="input-wrap">
                        <i class='bx bx-lock-alt icon'></i>
                        <input type="text" id="otp_inp" name="otp" placeholder="Enter 6-digit OTP" maxlength="6" pattern="\d{6}" required autocomplete="off">
                    </div>
                </div>
                <button type="button" class="btn-login" id="verify-btn">Verify OTP</button>
                <button type="button" class="btn-login btn-secondary" onclick="showEmailForm()">Back to Email</button>
            </div>

            <p class="back-link">Remember your password? <a href="{{ route('login') }}">Sign In</a></p>
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

<div class="modal-overlay" id="resetModal">
    <div class="modal">
        <button class="close-button" onclick="closeResetModal()" aria-label="Close"><i class="bx bx-x"></i></button>
        <h2>Reset Your Password</h2>
        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="email" id="resetEmail">
            <input type="hidden" name="otp" id="resetOtp">
            <div class="form-fields">
                <div>
                    <div class="field-lbl">New Password</div>
                    <div class="input-wrap">
                        <i class='bx bx-lock-alt icon'></i>
                        <input type="password" name="password" placeholder="Enter new password" required minlength="8">
                    </div>
                </div>
                <div>
                    <div class="field-lbl">Confirm Password</div>
                    <div class="input-wrap">
                        <i class='bx bx-lock-alt icon'></i>
                        <input type="password" name="password_confirmation" placeholder="Confirm new password" required minlength="8">
                    </div>
                </div>
                <button type="submit" class="btn-login">Reset Password</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sendOtpBtn = document.getElementById('send-otp-btn');
    const verifyBtn = document.getElementById('verify-btn');
    const emailInput = document.getElementById('email');
    const otpInput = document.getElementById('otp_inp');
    const otpSection = document.getElementById('otpSection');
    const resetModal = document.getElementById('resetModal');
    const emailForm = document.getElementById('emailForm');

    // Terms modal
    const termsModal = document.getElementById('termsModal');
    document.getElementById('termsLink').addEventListener('click', e => { 
        e.preventDefault(); 
        termsModal.classList.add('active'); 
        document.body.style.overflow = 'hidden'; 
    });
    document.getElementById('closeModal').addEventListener('click', () => { 
        termsModal.classList.remove('active'); 
        document.body.style.overflow = ''; 
    });
    termsModal.addEventListener('click', e => { 
        if (e.target === termsModal) { 
            termsModal.classList.remove('active'); 
            document.body.style.overflow = ''; 
        } 
    });

    // Send OTP button click handler
    sendOtpBtn.addEventListener('click', async function() {
        const email = emailInput.value.trim();
        const loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.classList.add('active');

        if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            loadingOverlay.classList.remove('active');
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#7A1428'
            });
            return;
        }

        try {
            const response = await fetch('{{ route("password.email") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email })
            });

            const result = await response.json();

            if (result.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Sent',
                    text: result.message,
                    confirmButtonColor: '#7A1428'
                });
                otpSection.classList.add('show');
                sendOtpBtn.style.display = 'none';
                emailInput.disabled = true;
                document.querySelector('.form-desc').textContent = 'Enter the 6-digit code sent to your email.';
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                    confirmButtonColor: '#7A1428'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send OTP. Please try again.',
                confirmButtonColor: '#7A1428'
            });
        } finally {
            loadingOverlay.classList.remove('active');
        }
    });

    // Verify OTP button click handler
    verifyBtn.addEventListener('click', async function() {
        const otp = otpInput.value.trim();
        const email = emailInput.value.trim();
        const loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.classList.add('active');

        if (!otp || otp.length !== 6 || !/^\d{6}$/.test(otp)) {
            loadingOverlay.classList.remove('active');
            Swal.fire({
                icon: 'error',
                title: 'Invalid OTP',
                text: 'Please enter a valid 6-digit OTP.',
                confirmButtonColor: '#7A1428'
            });
            return;
        }

        try {
            const response = await fetch('{{ route("password.verify-otp") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ email: email, otp: otp })
            });

            const result = await response.json();

            if (result.status === 'success') {
                loadingOverlay.classList.remove('active');
                Swal.fire({
                    icon: 'success',
                    title: 'OTP Verified',
                    text: result.message,
                    confirmButtonColor: '#7A1428'
                }).then(() => {
                    resetModal.classList.add('active');
                    document.getElementById('resetEmail').value = email;
                    document.getElementById('resetOtp').value = otp;
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: result.message,
                    confirmButtonColor: '#7A1428'
                });
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to verify OTP. Please try again.',
                confirmButtonColor: '#7A1428'
            });
        } finally {
            loadingOverlay.classList.remove('active');
        }
    });

    // Handle reset password form submission
    document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const loadingOverlay = document.getElementById('loadingOverlay');
        loadingOverlay.classList.add('active');
        const newPassword = this.querySelector('input[name="password"]').value;
        const confirmPassword = this.querySelector('input[name="password_confirmation"]').value;

        if (newPassword.length < 8) {
            loadingOverlay.classList.remove('active');
            Swal.fire({
                icon: 'error',
                title: 'Invalid Password',
                text: 'Password must be at least 8 characters long.',
                confirmButtonColor: '#7A1428'
            });
            return;
        }

        if (newPassword !== confirmPassword) {
            loadingOverlay.classList.remove('active');
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch',
                text: 'Passwords do not match.',
                confirmButtonColor: '#7A1428'
            });
            return;
        }

        try {
            const formData = new FormData(this);
            const response = await fetch('{{ route("password.update") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const result = await response.json();

            if (result.status === 'success') {
                loadingOverlay.classList.remove('active');
                Swal.fire({
                     icon: 'success',
                     title: 'Success',
                     text: 'Password reset successfully! Redirecting to login...',
                     confirmButtonColor: '#7A1428'
                 }).then(() => {
                     window.location.href = '{{ route("login") }}?success=password_reset';
                 });
             } else {
                loadingOverlay.classList.remove('active');
                Swal.fire({
                     icon: 'error',
                     title: 'Error',
                     text: result.message || 'Failed to reset password.',
                     confirmButtonColor: '#7A1428'
                 });
             }
         } catch (error) {
            loadingOverlay.classList.remove('active');
            Swal.fire({
                 icon: 'error',
                 title: 'Error',
                 text: 'Failed to reset password. Please try again.',
                 confirmButtonColor: '#7A1428'
             });
         }
    });

    // Utility function to hide loader for errors/success
    function hideLoader() {
        document.getElementById('loadingOverlay').classList.remove('active');
    }

    // Wrap the finally blocks or explicit removals
    // For sendOtpBtn
    // (We need to ensure it's removed everywhere)

    // Display any error/success messages from querystring
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    const success = urlParams.get('success');

    if (error === 'unauthorized') {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Unauthorized access. Please complete the verification process.',
            confirmButtonColor: '#7A1428'
        });
    } else if (error === 'reset_failed') {
        Swal.fire({
            icon: 'error',
            title: 'Password Reset Failed',
            text: 'There was an error resetting your password. Please try again.',
            confirmButtonColor: '#7A1428'
        });
    }

    if (success === 'email_sent') {
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'Email sent successfully. Please check your inbox.',
            confirmButtonColor: '#7A1428'
        });
    }
});

function showEmailForm() {
    document.getElementById('emailForm').style.display = 'flex';
    document.getElementById('otpSection').classList.remove('show');
    document.getElementById('send-otp-btn').style.display = 'block';
    document.getElementById('email').disabled = false;
    document.getElementById('email').value = '';
    document.getElementById('otp_inp').value = '';
    document.querySelector('.form-desc').textContent = 'Enter your email to receive a verification code.';
}

function closeResetModal() {
    document.getElementById('resetModal').classList.remove('active');
    document.getElementById('emailForm').style.display = 'flex';
    document.getElementById('otpSection').classList.remove('show');
    document.getElementById('send-otp-btn').style.display = 'block';
    document.getElementById('email').disabled = false;
}
</script>
</body>
</html>
