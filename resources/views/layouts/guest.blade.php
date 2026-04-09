<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kadellabs') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.4);
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased min-h-screen bg-gradient-to-br from-blue-50 via-gray-100 to-green-50 flex items-center justify-center relative overflow-hidden">
        
        <!-- Decorative Shapes -->
        <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>
        <div class="absolute bottom-[-10%] right-[-5%] w-96 h-96 bg-green-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20"></div>

        <div class="w-full max-w-md px-8 py-10 glass-panel shadow-2xl rounded-3xl relative z-10 m-4">
            <div class="flex justify-center mb-8">
                <a href="/" class="block text-center flex flex-col items-center">
                    <img src="{{ asset('images/logo.png') }}" class="h-16 w-auto mb-2 hover:scale-105 transition-transform" alt="KadelLabs Logo" onerror="this.outerHTML='<div class=\'hover:scale-105 transition-transform\'><h1 class=\'text-3xl font-extrabold text-[#0f3a69]\'>Kadel<span class=\'text-[#8bc53f]\'>Labs</span></h1><p class=\'text-sm text-gray-500 font-medium\'>serving through technology</p></div>'">
                </a>
            </div>

            {{ $slot }}
        </div>
    </body>
</html>
