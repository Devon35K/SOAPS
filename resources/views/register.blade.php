<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - USeP OSAS-Sports Unit</title>
    <link rel="stylesheet" href="{{ asset('css/loginS.css') }}">
    <link rel="icon" href="{{ asset('image/Usep.png') }}" sizes="any">
    <script src="{{ asset('js/validateStudentAthlete.js') }}" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .drop-zone {
            border: 2px dashed #007bff;
            border-radius: 5px;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }
        .drop-zone.dragover {
            border-color: #28a745;
            background-color: #e9ecef;
        }
        .drop-zone p {
            margin: 0;
            color: #6c757d;
            font-size: 16px;
        }
        .drop-zone .file-name {
            margin-top: 10px;
            color: #007bff;
            font-weight: bold;
        }
        .drop-zone input[type="file"] {
            display: none;
        }
        .drop-zone:hover {
            border-color: #0056b3;
        }
        /* Loading Modal Styles */
        .loading-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .loading-modal.show {
            display: flex;
        }
        .loading-content {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #007bff;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 10px;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        /* Update container layout for signup */
        .container {
            background: linear-gradient(135deg, var(--dark-bg) 0%, #1a1a1a 100%);
        }
        .top-bar {
            background: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .top-bar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            margin: 0 auto;
        }
        .title-container {
            text-align: center;
            flex: 1;
        }
        .title-container h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 5px;
        }
        .title-container h1 {
            font-size: 1.2rem;
            color: var(--text-muted);
            font-weight: 400;
        }
        .center-panel {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
        }
        .login-box {
            max-width: 500px;
            width: 100%;
        }
        .login-box form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .login-box input,
        .login-box select {
            width: 100%;
            padding: 14px 15px;
            background: var(--input-bg);
            border: 1px solid var(--input-border);
            border-radius: 8px;
            color: var(--text-light);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .login-box select {
            cursor: pointer;
        }
        .login-box input:focus,
        .login-box select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(230, 57, 70, 0.2);
            background: rgba(255, 255, 255, 0.12);
        }
        .login-box input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }
        .login-box h2 {
            text-align: center;
            margin: 20px 0;
            font-size: 1.3rem;
            color: var(--primary-color);
        }
    </style>
</head>

<body>

<div class="container">
    <nav class="top-bar">
        <div class="top-bar-content">
            <div class="logo-container">
                <img src="{{ asset('image/SportOffice.png') }}" alt="Sports Office Logo" class="logo">
                <img src="{{ asset('image/Usep.png') }}" alt="USeP Logo" class="logo">
            </div>
            <div class="title-container">
                <h2><span class="highlight">Join</span> <span class="highlight">USeP Sports</span></h2>
                <h1>USeP OSAS-Sports Unit</h1>
            </div>
        </div>
    </nav>

    <div class="center-panel">
        <div class="login-box">
            <h1>CREATE ACCOUNT</h1>
            
            <!-- Laravel Error/Success Messages -->
            @if(session('error'))
                <div class="error-message">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('success'))
                <div style="background: rgba(40, 167, 69, 0.15); color: #28a745; border: 1px solid rgba(40, 167, 69, 0.3); text-align: center; margin-bottom: 20px; padding: 12px; border-radius: 8px; font-size: 0.9rem;">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" enctype="multipart/form-data" onsubmit="return validateStudentAthleteForm(event)">
                @csrf
                <input type="text" name="student_id" placeholder="Student ID" value="{{ old('student_id') }}" required autocomplete="off">
                <input type="text" name="full_name" placeholder="Full Name" value="{{ old('full_name') }}" required autocomplete="name">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autocomplete="email">
                
                <select name="status" required>
                    <option value="" {{ !old('status') ? 'selected' : '' }} disabled>Select Status</option>
                    <option value="undergraduate" {{ old('status') == 'undergraduate' ? 'selected' : '' }}>Undergraduate</option>
                    <option value="alumni" {{ old('status') == 'alumni' ? 'selected' : '' }}>Alumni</option>
                </select>
                
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
                
                <select name="campus" required>
                    <option value="" {{ !old('campus') ? 'selected' : '' }} disabled>Select Campus</option>
                    <option value="Tagum" {{ old('campus') == 'Tagum' ? 'selected' : '' }}>Tagum</option>
                    <option value="Mabini" {{ old('campus') == 'Mabini' ? 'selected' : '' }}>Mabini</option>
                </select>
                
                <h2><span class="highlight">Upload Verification Documents</span></h2>

                <div class="drop-zone" id="dropZone">
                    <p>Drag and drop your file here or click to select</p>
                    <span class="file-name" id="fileName"></span>
                    <input type="file" name="document" id="document" accept=".pdf,.jpg,.jpeg,.png" required>
                </div>

                <input type="hidden" name="page" value="signup">
                <button type="submit" onclick="showLoadingModal()">SIGN UP</button>
            </form>
            
            <p class="signup-link">Already have an account? <a href="{{ route('login') }}">Log In</a></p>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="loading-modal" id="loadingModal">
    <div class="loading-content">
        <div class="loading-spinner"></div>
        <p>Please wait, submitting your information...</p>
    </div>
</div>

<script>
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('document');
    const fileNameDisplay = document.getElementById('fileName');
    const loadingModal = document.getElementById('loadingModal');

    // Show loading modal
    function showLoadingModal() {
        loadingModal.classList.add('show');
    }

    // Hide loading modal (optional, can be called based on form submission result)
    function hideLoadingModal() {
        loadingModal.classList.remove('show');
    }

    dropZone.addEventListener('click', () => fileInput.click());

    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('dragover');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('dragover');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            fileNameDisplay.textContent = files[0].name;
        }
    });

    fileInput.addEventListener('change', () => {
        if (fileInput.files.length > 0) {
            fileNameDisplay.textContent = fileInput.files[0].name;
        } else {
            fileNameDisplay.textContent = '';
        }
    });

    // Handle form submission with validation
    function validateStudentAthleteForm(event) {
        event.preventDefault();
        showLoadingModal();
        // Assuming validateStudentAthleteForm performs validation
        // If validation passes, submit the form
        if (true) { // Replace with actual validation logic from validateStudentAthlete.js
            event.target.submit();
        } else {
            hideLoadingModal();
            return false;
        }
    }

    // Handle SweetAlert2 display based on query parameters
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');
        const message = urlParams.get('message');

        if (status === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Your account has been submitted successfully! Please wait for admin approval.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            }).then(() => {
                // Clear query parameters from URL
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        } else if (status === 'error' && message) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#007bff'
            }).then(() => {
                // Clear query parameters from URL
                window.history.replaceState({}, document.title, window.location.pathname);
            });
        }
        // Ensure loading modal is hidden on page load
        hideLoadingModal();
    };
</script>

</body>
</html>
