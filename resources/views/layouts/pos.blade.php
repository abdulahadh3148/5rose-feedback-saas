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
<body class="bg-[#f3f6f3] text-[#102d22] h-screen overflow-hidden flex flex-col font-sans select-none">

    {{-- POS HEADER --}}
    <header class="h-16 shrink-0 bg-[#071d16] text-white flex items-center justify-between px-3 sm:px-5 z-20 shadow-md border-b border-emerald-900/40">
        {{-- Left: Brand & Dashboard Link --}}
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.dashboard') }}" class="h-10 w-10 overflow-hidden rounded-xl bg-white/10 p-1 flex items-center justify-center border border-white/20 transition hover:bg-white/20" title="Exit to Admin Dashboard">
                <img
                    src="{{ asset('images/5rose/logo.png') }}"
                    alt="5Rose Logo"
                    class="h-full w-full object-contain rounded-lg"
                    onerror="this.style.display='none'; this.parentElement.textContent='🌹';"
                >
            </a>
            <div>
                <div class="flex items-center gap-2">
                    <strong class="text-sm font-black tracking-tight">5Rose POS</strong>
                    <span class="hidden sm:inline-block px-1.5 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">v2.0 Pro</span>
                </div>
                <div class="flex items-center gap-2 text-[10px] text-white/60">
                    <span id="liveClock" class="font-semibold"></span>
                </div>
            </div>
        </div>

        {{-- Center / Middle: Live Day Stats & Quick Actions --}}
        <div class="flex items-center gap-1.5 sm:gap-2">
            {{-- Today's Sales Counter Pill --}}
            <button 
                type="button" 
                onclick="openDailySummary()" 
                class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/15 border border-white/15 transition text-xs cursor-pointer"
                title="Click to view Today's Register Summary (F9)"
            >
                <span class="text-emerald-400 font-bold">● Live:</span>
                <span class="font-bold text-white/90">Rs. <span id="hdrTodaySales" class="font-black text-emerald-300">{{ number_format($todaySalesTotal ?? 0, 0) }}</span></span>
                <span class="text-[10px] bg-white/15 px-1.5 py-0.5 rounded-full text-white/80 font-bold"><span id="hdrTodayCount">{{ $todayOrdersCount ?? 0 }}</span> bills</span>
            </button>

            {{-- Held Orders Button --}}
            <button 
                type="button" 
                onclick="toggleHeldOrdersModal()" 
                id="btnHeldOrdersHeader" 
                class="flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition text-xs font-bold text-white relative"
                title="Held Orders (F3)"
            >
                <span>⏸️</span>
                <span class="hidden sm:inline">Parked</span>
                <span id="heldBadge" class="hidden px-1.5 py-0.2 rounded-full bg-amber-500 text-[#071d16] text-[10px] font-black">0</span>
            </button>

            {{-- Recent Orders Drawer Button --}}
            <button 
                type="button" 
                onclick="toggleRecentOrdersModal()" 
                class="flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition text-xs font-bold text-white"
                title="Recent Bills (F6)"
            >
                <span>🕒</span>
                <span class="hidden sm:inline">Recent</span>
            </button>

            {{-- Day Register Summary Button --}}
            <button 
                type="button" 
                onclick="openDailySummary()" 
                class="flex items-center gap-1.5 px-2.5 sm:px-3 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition text-xs font-bold text-white"
                title="End of Day Register Summary (F9)"
            >
                <span>📊</span>
                <span class="hidden sm:inline">Summary</span>
            </button>

            {{-- Audio Toggle --}}
            <button 
                type="button" 
                id="btnAudioToggle" 
                onclick="toggleAudioMute()" 
                class="h-8 w-8 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 flex items-center justify-center text-xs text-white transition"
                title="Toggle Beep Sounds"
            >
                <span id="audioIcon">🔊</span>
            </button>

            {{-- Keyboard Shortcuts Help --}}
            <button 
                type="button" 
                onclick="toggleShortcutsModal()" 
                class="hidden lg:flex items-center gap-1 px-2.5 py-1.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition text-xs font-bold text-white"
                title="Keyboard Shortcuts Cheat Sheet"
            >
                <span>⌨️</span>
                <span>Keys</span>
            </button>

            {{-- Fullscreen Toggle --}}
            <button 
                type="button" 
                onclick="toggleFullscreen()" 
                class="h-8 w-8 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 flex items-center justify-center text-xs text-white transition"
                title="Toggle Fullscreen"
            >
                ⛶
            </button>

            {{-- Cashier Profile Badge --}}
            <div class="hidden xl:flex items-center gap-2 border-l border-white/20 pl-3">
                <div class="grid h-7 w-7 place-items-center rounded-full bg-emerald-500/20 text-xs font-black text-emerald-300">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <span class="text-xs font-bold text-white/90 truncate max-w-[100px]">{{ auth()->user()->name ?? 'Cashier' }}</span>
            </div>
        </div>
    </header>

    {{-- MAIN POS AREA --}}
    <main class="flex-1 flex overflow-hidden relative">
        @yield('content')
    </main>

    <script>
        // Simple live clock with seconds
        function updateLiveClock() {
            const now = new Date();
            const el = document.getElementById('liveClock');
            if (el) {
                el.innerText = now.toLocaleDateString('en-US', { weekday: 'short', month: 'short', day: 'numeric' }) + ' · ' + now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' });
            }
        }
        setInterval(updateLiveClock, 1000);
        updateLiveClock();

        function toggleFullscreen() {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => console.log(err));
            } else {
                if (document.exitFullscreen) {
                    document.exitFullscreen();
                }
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
