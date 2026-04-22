<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Pendaftaran Siswa Baru - TK Puspitasari Kaliwatubumi' }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Outfit:400,500,600,700,800&display=swap" rel="stylesheet">

    @livewireStyles

    <style>
        body { font-family: 'Outfit', sans-serif; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-indigo-50 via-white to-purple-50 text-slate-800 selection:bg-indigo-500 selection:text-white min-h-screen">

    <!-- Navbar -->
    <nav class="fixed w-full z-50 bg-white/80 backdrop-blur-md border-b border-white/20 shadow-sm">
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
                    <a href="/register-student" class="text-sm font-semibold text-indigo-600 transition-colors">Pendaftaran</a>
                    <a href="/admin" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition-colors">Admin Portal</a>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen pt-20">
        {{ $slot }}
    </main>

    <footer class="bg-slate-900 border-t border-slate-800 mt-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex justify-center md:justify-start space-x-6 md:order-2">
                    <span class="text-slate-400 text-sm font-medium">Memajukan Pendidikan Anak Usia Dini</span>
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
