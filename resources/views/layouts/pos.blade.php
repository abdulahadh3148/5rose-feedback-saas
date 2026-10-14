<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <meta name="theme-color" content="#071d16">
    <title>@yield('title', '5Rose POS')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { overscroll-behavior: none; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    @stack('styles')
</head>
<body class="bg-[#f3f6f3] text-[#102d22] h-screen overflow-hidden flex flex-col font-sans">

    {{-- POS HEADER --}}
    <header class="h-16 shrink-0 bg-[#071d16] text-white flex items-center justify-between px-4 sm:px-6 z-20 shadow-md">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.dashboard') }}" class="h-10 w-10 overflow-hidden rounded-xl bg-white/10 p-1 flex items-center justify-center border border-white/20 transition hover:bg-white/20" title="Back to Dashboard">
                <img
                    src="{{ asset('images/5rose/logo.png') }}"
                    alt="5Rose Logo"
                    class="h-full w-full object-contain rounded-lg"
                    onerror="this.style.display='none'; this.parentElement.textContent='🌹';"
                >
            </a>
            <div>
                <strong class="block text-sm font-black">5Rose POS</strong>
                <span class="text-[10px] font-bold tracking-widest text-emerald-400">DIGITAL BILLING</span>
            </div>
        </div>

        <div class="hidden md:flex items-center gap-6">
            <div id="liveClock" class="text-sm font-bold text-white/70"></div>
            <div class="flex items-center gap-2 border-l border-white/20 pl-6">
                <div class="grid h-8 w-8 place-items-center rounded-full bg-emerald-500/20 text-xs font-black text-emerald-300">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="text-xs font-bold">{{ auth()->user()->name }}</span>
            </div>
            <button onclick="document.documentElement.requestFullscreen()" class="p-2 text-white/50 hover:text-white transition" title="Fullscreen">
                ⛶
            </button>
        </div>
    </header>

    {{-- MAIN POS AREA --}}
    <main class="flex-1 flex overflow-hidden relative">
        @yield('content')
    </main>

    <script>
        // Simple live clock
        setInterval(() => {
            const now = new Date();
            document.getElementById('liveClock').innerText = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }) + ' · ' + now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
        }, 1000);
    </script>
    @stack('scripts')
</body>
</html>
