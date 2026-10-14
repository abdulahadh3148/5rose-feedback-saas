@extends('layouts.admin')

@section('title', 'Dashboard | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-[1500px] px-4 py-7 sm:px-6 lg:px-9 lg:py-9">

    <div class="mb-8">
        <span class="text-[10px] font-extrabold tracking-[.18em] text-[#0b8152]">OVERVIEW</span>
        <h1 class="mt-3 text-4xl font-black tracking-[-.055em] text-[#092c20] sm:text-5xl">Dashboard</h1>
    </div>

    {{-- STATS WIDGETS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Revenue Widget --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
            <div class="absolute right-0 top-0 h-32 w-32 -translate-y-12 translate-x-12 rounded-full bg-emerald-50 opacity-50"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Today's Revenue</span>
                <div class="mt-4 flex items-end gap-2">
                    <span class="text-2xl font-bold text-gray-400">Rs.</span>
                    <strong class="text-4xl font-black tracking-tighter text-[#08784b]">{{ number_format($revenueToday, 2) }}</strong>
                </div>
                <div class="mt-2 text-[10px] font-bold text-emerald-600 bg-emerald-50 inline-block px-2 py-1 rounded-full">+ Updated Live</div>
            </div>
        </div>

        {{-- Orders Widget --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
            <div class="absolute right-0 top-0 h-32 w-32 -translate-y-12 translate-x-12 rounded-full bg-blue-50 opacity-50"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Today's Orders</span>
                <div class="mt-4 flex items-end gap-2">
                    <strong class="text-4xl font-black tracking-tighter text-blue-600">{{ $ordersToday }}</strong>
                    <span class="text-sm font-bold text-gray-400 mb-1">Bills</span>
                </div>
            </div>
        </div>

        {{-- Feedback Widget --}}
        <div class="rounded-3xl border border-gray-200 bg-white p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] relative overflow-hidden">
            <div class="absolute right-0 top-0 h-32 w-32 -translate-y-12 translate-x-12 rounded-full bg-amber-50 opacity-50"></div>
            <div class="relative z-10">
                <span class="text-xs font-bold uppercase tracking-widest text-gray-400">Pending Feedback</span>
                <div class="mt-4 flex items-end gap-2">
                    <strong class="text-4xl font-black tracking-tighter text-amber-500">{{ $pendingFeedback }}</strong>
                    <span class="text-sm font-bold text-gray-400 mb-1">Awaiting</span>
                </div>
                @if($pendingFeedback > 0)
                    <a href="{{ route('admin.feedback.index') }}" class="mt-3 block text-xs font-bold text-amber-600 hover:text-amber-700">Review Now →</a>
                @endif
            </div>
        </div>
    </div>

    {{-- TOP SELLING PRODUCTS --}}
    <div class="grid lg:grid-cols-2 gap-8">
        <div class="rounded-[24px] border border-gray-200 bg-white shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-100 bg-[#f4f7f4]">
                <h3 class="text-sm font-black uppercase tracking-widest text-[#092c20]">Top Selling Products</h3>
            </div>
            <div class="p-0">
                <ul class="divide-y divide-gray-100">
                    @forelse($topProducts as $index => $item)
                    <li class="flex items-center justify-between p-5 hover:bg-gray-50 transition">
                        <div class="flex items-center gap-4">
                            <span class="grid h-8 w-8 place-items-center rounded-full bg-emerald-50 text-xs font-black text-emerald-700">#{{ $index + 1 }}</span>
                            <span class="font-bold text-[#092c20]">{{ $item->product_name }}</span>
                        </div>
                        <span class="font-black text-gray-400">{{ $item->total_sold }} <span class="text-xs font-normal">sold</span></span>
                    </li>
                    @empty
                    <li class="p-8 text-center text-gray-500 font-bold">No sales data yet. Make some orders!</li>
                    @endforelse
                </ul>
            </div>
        </div>
        
        <div class="rounded-[24px] bg-[#092c20] p-8 text-white flex flex-col justify-center items-center text-center relative overflow-hidden shadow-xl">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/5"></div>
            <div class="absolute -left-20 -bottom-20 h-48 w-48 rounded-full bg-white/5"></div>
            
            <div class="relative z-10">
                <div class="text-6xl mb-6">💻</div>
                <h2 class="text-2xl font-black mb-2">Ready to take orders?</h2>
                <p class="text-white/60 text-sm mb-8 max-w-sm mx-auto">Open the POS system in a new window to start taking customer orders immediately.</p>
                <a href="{{ route('admin.pos.index') }}" target="_blank" class="inline-flex min-h-14 items-center justify-center rounded-2xl bg-[#08784b] px-8 font-black tracking-wide transition hover:bg-[#06633e] shadow-[0_10px_20px_rgba(8,120,75,0.3)] hover:shadow-[0_5px_10px_rgba(8,120,75,0.3)] transform hover:translate-y-1">
                    OPEN POS TERMINAL
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
