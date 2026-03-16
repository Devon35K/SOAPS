<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - {{ config('app.name', 'SOAPS') }}</title>
    
    <!-- Scripts -->
    <style>
        @import 'tailwindcss';
        
        body {
            @apply bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center;
        }
        
        .login-card {
            @apply bg-white shadow-lg rounded-lg p-8;
        }
        
        .form-input {
            @apply w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }
        
        .btn-primary {
            @apply w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition duration-200;
        }
        
        .error-message {
            @apply mt-1 text-sm text-red-600;
        }
        
        .flash-success {
            @apply mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded;
        }
        
        .flash-error {
            @apply mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded;
        }
    </style>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md">
        <!-- Logo/Brand -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ config('app.name', 'SOAPS') }}</h1>
            <p class="text-gray-600">Sign in to your account</p>
        </div>

        <!-- Login Form -->
            <div class="login-card">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Email -->
                <div class="mb-6">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
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
                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
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
                <div class="mb-6">
                    <label class="flex items-center">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                        >
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
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
                        <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-500">
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
