<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'SOAPS') }}</title>
    
    <!-- Scripts -->
    @vite(['resources/js/app.ts', 'resources/js/ssr.ts'])
    
    <!-- Styles -->
    @vite('resources/css/app.css')
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Inertia Head -->
    @inertiaHead
</head>
<body class="font-sans antialiased">
    @inertia
</body>
</html>
