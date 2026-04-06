<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up — USeP OSAS Sports Unit</title>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@400;600;700;800;900&family=Barlow:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="icon" href="/image/Usep.png" sizes="any" />
    <script src="{{ asset('js/validateStudentAthlete.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .login-card { width: 100%; max-width: 420px; position: relative; z-index: 1; animation: slideUp .6s cubic-bezier(.22,.9,.42,1) both; }
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
        .error-messages { padding: 11px 14px; border-radius: 6px; background: rgba(122,20,40,.06); font-size: .82rem; color: var(--maroon); margin-bottom: 16px; }
        .error-messages p { line-height: 1.8; }
        .form-fields { display: flex; flex-direction: column; gap: 14px; }
        .field-lbl { font-size: .68rem; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; color: var(--text-muted); margin-bottom: 6px; }
        .input-wrap { position: relative; display: flex; align-items: center; }
        .input-wrap i.icon { position: absolute; left: 14px; font-size: 1.1rem; color: var(--text-muted); pointer-events: none; transition: color .2s; }
        .input-wrap input, .input-wrap select {
            width: 100%; padding: 13px 14px 13px 42px;
            border: 2px solid rgba(61,42,47,.12); border-radius: 0;
            background: var(--white); font-family: 'Barlow', sans-serif;
            font-size: .9rem; font-weight: 500; color: var(--charcoal); outline: none;
            transition: border-color .2s;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .input-wrap select { cursor: pointer; appearance: none; padding-right: 40px; }
        .input-wrap select + i.icon { left: auto; right: 14px; pointer-events: none; }
        .input-wrap input::placeholder { color: rgba(61,42,47,.28); font-weight: 400; }
        .input-wrap input:focus, .input-wrap select:focus { border-color: var(--maroon); }
        .input-wrap select option { font-family: 'Barlow', sans-serif; }
        .drop-zone {
            border: 2px dashed var(--maroon);
            padding: 20px;
            text-align: center;
            background: var(--white);
            cursor: pointer;
            transition: all 0.3s ease;
            clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);
        }
        .drop-zone.dragover {
            border-color: var(--gold);
            background: rgba(240,180,41,.05);
        }
        .drop-zone p {
            margin: 0;
            color: var(--text-muted);
            font-size: .85rem;
            font-weight: 500;
        }
        .drop-zone .file-name {
            margin-top: 8px;
            color: var(--maroon);
            font-weight: 600;
            font-size: .85rem;
        }
        .drop-zone input[type="file"] { display: none; }
        .drop-zone:hover { border-color: var(--maroon-mid); }
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
        .modal-overlay { position: fixed; inset: 0; background: rgba(28,20,16,.65); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; z-index: 100; opacity: 0; pointer-events: none; transition: opacity .25s; }
        .modal-overlay.active { opacity: 1; pointer-events: all; }
        .modal { background: var(--white); border-top: 4px solid var(--gold); padding: 40px; max-width: 480px; width: 90%; position: relative; transform: scale(.95) translateY(12px); transition: transform .25s cubic-bezier(.22,.9,.42,1); max-height: 80vh; overflow-y: auto; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); }
        .modal-overlay.active .modal { transform: scale(1) translateY(0); }
        .modal h2 { font-family: 'Barlow Condensed', sans-serif; font-size: 1.6rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: var(--charcoal); margin-bottom: 20px; text-align: center; }
        .modal p { font-size: .88rem; color: var(--text-body); line-height: 1.7; margin-bottom: 14px; }
        .modal a { color: var(--maroon); font-weight: 600; }
        .close-button { position: absolute; top: 14px; right: 14px; border: none; background: rgba(122,20,40,.08); width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; cursor: pointer; color: var(--maroon); font-size: 1.1rem; transition: background .2s; }
        .close-button:hover { background: rgba(122,20,40,.15); }

        /* ── Loading Modal ── */
        .loading-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(28,20,16,.65);
            backdrop-filter: blur(4px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .loading-modal.show { display: flex; }
        .loading-content {
            background: var(--white);
            padding: 30px 40px;
            border-top: 4px solid var(--gold);
            position: relative;
            clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%);
            text-align: center;
        }
        .loading-spinner {
            border: 4px solid rgba(122,20,40,.1);
            border-top: 4px solid var(--maroon);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 15px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-content p {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--charcoal);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

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
        <div class="big-number">02</div>
        <div class="left-content">
            <div class="logo-row">
                <div class="logo-badge"><img src="/image/SportOffice.png" alt="Sports Office"></div>
                <div class="logo-badge"><img src="/image/Usep.png" alt="USeP"></div>
                <div class="logo-name">USeP OSAS<br>Sports Unit</div>
            </div>
            <span class="headline-tag">Join the Team</span>
            <h1 class="headline">One Goal.<br><span class="gold-word">One Family.</span></h1>
            <p class="tagline">Register as a student-athlete and be part of USeP's sports legacy. Train, compete, and excel with us.</p>
            <div class="stat-strip">
                <div class="stat-item"><div class="stat-val">12+</div><div class="stat-lbl">Sports</div></div>
                <div class="stat-item"><div class="stat-val">100%</div><div class="stat-lbl">Dedication</div></div>
                <div class="stat-item"><div class="stat-val">All</div><div class="stat-lbl">Campuses</div></div>
            </div>
        </div>
        <div class="left-footer">
            <p>&copy; 2025 USeP. All Rights Reserved.</p>
            <div><a href="#" id="termsLink">Terms</a> &middot; <a href="https://www.usep.edu.ph/usep-data-privacy-statement/" target="_blank">Privacy</a></div>
        </div>
    </div>

    <div class="right-panel">
        <div class="bg-image"></div>
        <div class="login-card">
            <div class="form-number">02</div>
            <p class="form-eyebrow">Student-Athlete Registration</p>
            <h2 class="form-title">Create<br><span>Account.</span></h2>

            @if(session('error'))
                <div class="server-error"><i class='bx bx-error-circle'></i>{{ session('error') }}</div>
            @else
                <p class="form-desc">Fill in your details to start your athletic journey.</p>
            @endif

            @if(session('success'))
                <div class="server-error" style="background: rgba(40,167,69,.1); border-left-color: #28a745; color: #28a745;">
                    <i class='bx bx-check-circle'></i>{{ session('success') }}
                </div>
            @endif

            <div id="error-messages" class="error-messages" hidden></div>

            <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" onsubmit="return validateStudentAthleteForm(event)" novalidate>
                @csrf
                <div class="form-fields">
                    <div>
                        <div class="field-lbl">Student ID</div>
                        <div class="input-wrap">
                            <i class='bx bx-id-card icon'></i>
                            <input type="text" name="student_id" placeholder="e.g., 2021-12345" value="{{ old('student_id') }}" required autocomplete="off">
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Full Name</div>
                        <div class="input-wrap">
                            <i class='bx bx-user icon'></i>
                            <input type="text" name="full_name" placeholder="Juan Dela Cruz" value="{{ old('full_name') }}" required autocomplete="name">
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Email</div>
                        <div class="input-wrap">
                            <i class='bx bx-envelope icon'></i>
                            <input type="email" name="email" placeholder="you@usep.edu.ph" value="{{ old('email') }}" required autocomplete="email">
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Status</div>
                        <div class="input-wrap">
                            <i class='bx bx-graduation icon'></i>
                            <select name="status" required>
                                <option value="" {{ !old('status') ? 'selected' : '' }} disabled>Select Status</option>
                                <option value="undergraduate" {{ old('status') == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                                <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                            </select>
                            <i class='bx bx-chevron-down icon'></i>
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Sport</div>
                        <div class="input-wrap">
                            <i class='bx bx-football icon'></i>
                            <select name="sport" required>
                                <option value="" {{ !old('sport') ? 'selected' : '' }} disabled>Select Sport</option>
                                <option value="Athletics" {{ old('sport') == 'Athletics' ? 'selected' : '' }}>Athletics</option>
                                <option value="Badminton" {{ old('sport') == 'Badminton' ? 'selected' : '' }}>Badminton</option>
                                <option value="Basketball" {{ old('sport') == 'Basketball' ? 'selected' : '' }}>Basketball</option>
                                <option value="Chess" {{ old('sport') == 'Chess' ? 'selected' : '' }}>Chess</option>
                                <option value="Football" {{ old('sport') == 'Football' ? 'selected' : '' }}>Football</option>
                                <option value="Sepak Takraw" {{ old('sport') == 'Sepak Takraw' ? 'selected' : '' }}>Sepak Takraw</option>
                                <option value="Swimming" {{ old('sport') == 'Swimming' ? 'selected' : '' }}>Swimming</option>
                                <option value="Table Tennis" {{ old('sport') == 'Table Tennis' ? 'selected' : '' }}>Table Tennis</option>
                                <option value="Taekwondo" {{ old('sport') == 'Taekwondo' ? 'selected' : '' }}>Taekwondo</option>
                                <option value="Tennis" {{ old('sport') == 'Tennis' ? 'selected' : '' }}>Tennis</option>
                                <option value="Volleyball" {{ old('sport') == 'Volleyball' ? 'selected' : '' }}>Volleyball</option>
                                <option value="ESports" {{ old('sport') == 'ESports' ? 'selected' : '' }}>Wrestling</option>
                            </select>
                            <i class='bx bx-chevron-down icon'></i>
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Campus</div>
                        <div class="input-wrap">
                            <i class='bx bx-buildings icon'></i>
                            <select name="campus" required>
                                <option value="" {{ !old('campus') ? 'selected' : '' }} disabled>Select Campus</option>
                                <option value="Tagum" {{ old('campus') == 'Tagum' ? 'selected' : '' }}>Tagum</option>
                                <option value="Mabini" {{ old('campus') == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                            </select>
                            <i class='bx bx-chevron-down icon'></i>
                        </div>
                    </div>
                    <div>
                        <div class="field-lbl">Verification Document</div>
                        <div class="drop-zone" id="dropZone">
                            <p><i class='bx bx-cloud-upload' style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>Drag and drop your file here or click to select</p>
                            <span class="file-name" id="fileName"></span>
                            <input type="file" name="document" id="document" accept=".pdf,.jpg,.jpeg,.png" required>
                        </div>
                    </div>
                    <input type="hidden" name="page" value="signup">
                    <button type="submit" class="btn-login" onclick="showLoadingModal()">Join the Team</button>
                    <div class="btn-accent"></div>
                </div>
            </form>

            <p class="signup-row">Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
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

<div class="loading-modal" id="loadingModal">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <p>Please wait, submitting your information...</p>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const termsModal = document.getElementById('termsModal');
    document.getElementById('termsLink').addEventListener('click', e => { e.preventDefault(); termsModal.classList.add('active'); document.body.style.overflow = 'hidden'; });
    document.getElementById('closeModal').addEventListener('click', () => { termsModal.classList.remove('active'); document.body.style.overflow = ''; });
    termsModal.addEventListener('click', e => { if (e.target === termsModal) { termsModal.classList.remove('active'); document.body.style.overflow = ''; } });
    document.addEventListener('keydown', e => { if (e.key === 'Escape' && termsModal.classList.contains('active')) { termsModal.classList.remove('active'); document.body.style.overflow = ''; } });

    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('document');
    const fileNameDisplay = document.getElementById('fileName');
    const loadingModal = document.getElementById('loadingModal');

    function showLoadingModal() {
        loadingModal.classList.add('show');
    }
    function hideLoadingModal() {
        loadingModal.classList.remove('show');
    }
    window.showLoadingModal = showLoadingModal;
    window.hideLoadingModal = hideLoadingModal;

    dropZone.addEventListener('click', () => fileInput.click());
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('dragover'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('dragover'));
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) { fileInput.files = files; fileNameDisplay.textContent = files[0].name; }
    });
    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) fileNameDisplay.textContent = fileInput.files[0].name;
        else fileNameDisplay.textContent = '';
    });

    window.validateStudentAthleteForm = function (event) {
        const form = event.target;
        const studentId = form.querySelector('input[name="student_id"]').value.trim();
        const fullName = form.querySelector('input[name="full_name"]').value.trim();
        const email = form.querySelector('input[name="email"]').value.trim();
        const status = form.querySelector('select[name="status"]').value;
        const sport = form.querySelector('select[name="sport"]').value;
        const campus = form.querySelector('select[name="campus"]').value;
        const document = form.querySelector('input[name="document"]').files.length;
        const box = document.getElementById('error-messages');
        const msgs = [];
        box.innerHTML = ''; box.hidden = true;
        if (!studentId) msgs.push('Student ID is required.');
        if (!fullName) msgs.push('Full Name is required.');
        if (!email) msgs.push('Email is required.');
        else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) msgs.push('Please enter a valid email address.');
        if (!status) msgs.push('Status is required.');
        if (!sport) msgs.push('Sport is required.');
        if (!campus) msgs.push('Campus is required.');
        if (!document) msgs.push('Verification document is required.');
        if (msgs.length) {
            box.hidden = false;
            msgs.forEach(m => { const p = document.createElement('p'); p.textContent = m; box.appendChild(p); });
            event.preventDefault();
            return false;
        }
        showLoadingModal();
        return true;
    };

    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const message = urlParams.get('message');
        if (status === 'success') {
            Swal.fire({
                icon: 'success', title: 'Success',
                text: 'Your account has been submitted successfully! Please wait for admin approval.',
                confirmButtonText: 'OK', confirmButtonColor: '#7A1428'
            }).then(() => window.history.replaceState({}, document.title, window.location.pathname));
        } else if (status === 'error' && message) {
            Swal.fire({
                icon: 'error', title: 'Error', text: message,
                confirmButtonText: 'OK', confirmButtonColor: '#7A1428'
            }).then(() => window.history.replaceState({}, document.title, window.location.pathname));
        }
        hideLoadingModal();
    };
});
</script>
</body>
</html>
