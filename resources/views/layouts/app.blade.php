<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', 'TK Puspitasari Kaliwatubumi - Premium Kindergarten')</title>
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Tailwind CDN Fallback -->
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        @livewireStyles
        
        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased bg-slate-50 text-slate-800 selection:bg-indigo-500 selection:text-white">
        
        <!-- Navbar -->
        <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm" id="navbar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer" onclick="window.location.href='/'">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-500/30">
                            TK
                        </div>
                        <span class="font-bold text-xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-slate-800 to-slate-600">
                            Puspitasari Kaliwatubumi
                        </span>
                    </div>
                    <div class="hidden md:flex space-x-8">
                        <a href="/" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Home</a>
                        <a href="/register-student" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Admissions</a>
                        <a href="/admin" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Admin Portal</a>
                    </div>
                    <div class="md:hidden flex items-center">
                        <button class="text-slate-500 hover:text-slate-700 focus:outline-none">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="min-h-screen pt-20">
            @yield('content')
        </main>

        <footer class="bg-slate-900 border-t border-slate-800 mt-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex justify-center md:justify-start space-x-6 md:order-2">
                        <span class="text-slate-400 text-sm font-medium">Empowering Early Childhood Education</span>
                    </div>
                    <div class="mt-8 md:mt-0 md:order-1">
                        <p class="text-center md:text-left text-sm text-slate-400 font-medium">
                            &copy; {{ date('Y') }} TK Puspitasari Kaliwatubumi. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    @livewireScripts
    </body>
</html>
