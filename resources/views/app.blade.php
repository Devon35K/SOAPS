<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'SOAPS') }}</title>
    
    <!-- Scripts -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
<title>USeP OSAS-Sports Unit Login</title>
    <link rel="stylesheet" href="/css/loginStyle.css">
    <link href="https://cdn.jsdelivr.net/npm/boxicons/css/boxicons.min.css" rel="stylesheet" />
    <link rel="icon" href="/image/Usep.png" sizes="any" />

</head>

<body>
<div class="container">
    <!-- Left Panel  nigga -->


    <div class="left-panel">
        <div class="content-wrapper">
            <div class="logo-container">
                <img src="/image/SportOffice.png" alt="Sports Office Logo" class="logo">
                <img src="/image/Usep.png" alt="USeP Logo" class="logo">
            </div>
            <h2><span class="highlight">One Data.</span> <span class="highlight">One USeP.</span></h2>
            <h1>USeP OSAS-Sports Unit</h1>
        </div>
        <footer>
            <p>© 2025. All Rights Reserved.</p>
            <a href="#" id="termsLink">Terms of Use</a> | <a href="https://www.usep.edu.ph/usep-data-privacy-statement/">Privacy Policy</a>
        </footer>
    </div>

    <!-- Right Panel / Login -->
    <div class="right-panel">
        <div class="login-box">
            <h1>WELCOME</h1>

            <?php if (!empty($errorMessage)): ?>
                <div class="error-message">
                    <?php echo htmlspecialchars($errorMessage); ?>
                </div>
            <?php else: ?>
                <p>Please log in to get started.</p>
            <?php endif; ?>

            <div id="error-messages" class="error-messages" hidden></div>
            <form method="POST" action="../controller/auth.php" onsubmit="return validateForm(event)" novalidate>
                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>">
                <label>
                    <input type="email" name="email" placeholder="Enter Email" required>
                </label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Enter Password" required>
                    <i class="bx bx-hide toggle-password" aria-label="Show password" role="button" tabindex="0"></i>
                </div>
                <button type="submit">LOGIN</button>
            </form>

            <p class="signup-link">
                Don't have an account? <a href="../view/signupView.php">Sign Up</a>
                <a href="OTP/forgotPassView.php" style="font-size: 0.8em;">Forgot Password?</a>
            </p>
        </div>
    </div>
</div>

<!-- Terms of Use Modal -->
<div class="modal-overlay" id="termsModal">
    <div class="modal">
        <button class="close-button" id="closeModal" aria-label="Close modal">
            <i class="bx bx-x"></i>
        </button>
        <h2 style="text-align: center;">Terms of Use</h2>
        <p>Welcome to the USeP OSAS-Sports Unit system. By accessing or using this website, you agree to be bound by the following terms and conditions:</p>
        <p>1. <strong>Account Responsibility:</strong> You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.</p>
        <p>2. <strong>Prohibited Activities:</strong> You may not use this system for any unlawful purpose or in any way that violates these terms, including unauthorized access or data manipulation.</p>
        <p>3. <strong>Data Privacy:</strong> We are committed to protecting your personal information. Please refer to our <a href="https://www.usep.edu.ph/usep-data-privacy-statement/">Privacy Policy</a> for details.</p>
        <p>For any questions or concerns, please contact the USeP OSAS-Sports Unit administration.</p>
    </div>
</div>

<!-- Privacy Statement Modal -->
<div class="privacy-modal-overlay" id="privacyModal">
    <div class="privacy-modal">
        <div class="privacy-modal-content">
            <div class="privacy-modal-image">
                <img src="/image/dataPrivacy.png" alt="Student privacy illustration" />
            </div>
            <h3>By continuing to use the Student Portal, you agree to the
                <span class="privacy-link">University of Southeastern Philippines' Data Privacy Statement</span>
            </h3>
            <button class="privacy-button" id="continueButton">CONTINUE</button>
        </div>
    </div>
</div>



<div class="footer-container">
    <footer>
        <p>© 2025. All Rights Reserved.</p>
        <a href="#" id="termsLink">Terms of Use</a> | <a href="https://www.usep.edu.ph/usep-data-privacy-statement/">Privacy Policy</a>
    </footer>
</div>

<!-- Scripts -->

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Terms modal elements
        const termsModal = document.getElementById('termsModal');
        const termsLink = document.getElementById('termsLink');
        const closeModal = document.getElementById('closeModal');

        // Open Terms modal
        termsLink.addEventListener('click', function(e) {
            e.preventDefault();
            termsModal.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Close Terms modal
        closeModal.addEventListener('click', function() {
            termsModal.classList.remove('active');
            document.body.style.overflow = '';
        });

        termsModal.addEventListener('click', function(e) {
            if (e.target === termsModal) {
                termsModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && termsModal.classList.contains('active')) {
                termsModal.classList.remove('active');
                document.body.style.overflow = '';
            }
        });

        // Password toggle functionality
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('password');

        if (togglePassword && passwordInput) {
            togglePassword.addEventListener('click', function() {
                const isPasswordVisible = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPasswordVisible ? 'text' : 'password');
                togglePassword.classList.toggle('bx-hide', isPasswordVisible);
                togglePassword.classList.toggle('bx-show', !isPasswordVisible);
                togglePassword.setAttribute('aria-label', isPasswordVisible ? 'Hide password' : 'Show password');
            });

            togglePassword.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    togglePassword.click();
                }
            });
        }

        // Privacy Modal functionality
        const privacyModal = document.getElementById('privacyModal');
        const continueButton = document.getElementById('continueButton');
        const privacyLink = document.querySelector('.privacy-link');

        if (sessionStorage.getItem('privacyModalShown')) {
            privacyModal.style.display = 'none';
        } else {
            document.body.style.overflow = 'hidden';
            continueButton.addEventListener('click', function() {
                sessionStorage.setItem('privacyModalShown', 'true');
                privacyModal.style.display = 'none';
                document.body.style.overflow = '';
            });
        }

        if (privacyLink) {
            privacyLink.addEventListener('click', function() {
                window.open('https://www.usep.edu.ph/usep-data-privacy-statement/', '_blank');
            });
        }

        // Form validation
        function validateForm(event) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;
            const errorMessages = document.getElementById('error-messages');
            let isValid = true;
            let messages = [];

            errorMessages.innerHTML = '';
            errorMessages.hidden = true;

            if (!email) {
                messages.push('Email is required');
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                messages.push('Please enter a valid email address');
                isValid = false;
            }

            if (!password) {
                messages.push('Password is required');
                isValid = false;
            }

            if (!isValid) {
                errorMessages.hidden = false;
                messages.forEach(message => {
                    const p = document.createElement('p');
                    p.textContent = message;
                    errorMessages.appendChild(p);
                });
                event.preventDefault();
            }

            return isValid;
        }
    });
</script>
</body>
</html>