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
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="login-container">
        <!-- Logo/Brand -->
        <div class="login-header">
            <div class="login-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>
            <h1 class="brand-title">{{ config('app.name', 'SOAPS') }}</h1>
            <p class="brand-subtitle">Sign in to your account</p>
        </div>

        <!-- Login Form -->
            <div class="login-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="form-group">
                    <label for="email" class="form-label">
                        Email Address
                    </label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        class="form-input"
                        placeholder="Enter your email"
                        required
                        autocomplete="email"
                        autofocus
                    >
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password" class="form-label">
                        Password
                    </label>
                    <input 
                        type="password" 
                        id="password" 
                        name="password" 
                        class="form-input"
                        placeholder="Enter your password"
                        required
                        autocomplete="current-password"
                    >
                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="checkbox-input"
                        >
                        <span class="checkbox-text">Remember me</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="mb-4">
                    <button 
                        type="submit" 
                        class="btn-primary"
                    >
                        Sign In
                    </button>
                </div>

                <!-- Forgot Password Link -->
                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </form>
        </div>

        <!-- Flash Messages -->
        @if (session('status'))
            <div class="flash-success">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="flash-error">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>
