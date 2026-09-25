@extends('layouts.customer')

@section('title', '5Rose Cool Bar | Customer Experience')

@section('content')
<main class="customer-content pb-20">
    
    <!-- Premium Hero Section -->
    <section class="relative overflow-hidden rounded-[28px] p-8 mt-2 bg-gradient-to-br from-[#f2f9f5] via-[#e2f1e8] to-[#d4eadb] shadow-sm border border-white/60">
        <!-- Decorative blobs -->
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#cce3d5] rounded-full mix-blend-multiply filter blur-2xl opacity-70 animate-pulse"></div>
        <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-[#e8f4ec] rounded-full mix-blend-multiply filter blur-2xl opacity-70"></div>
        
        <div class="relative z-10">
            <h1 class="text-[34px] font-extrabold text-[#06452e] leading-[1.1] tracking-[-1px] mb-4">
                Good Food.<br>Brighter Days.
            </h1>
            <p class="text-[#4a6356] text-[14px] leading-relaxed mb-6 font-medium max-w-[280px]">
                Fresh drinks, delicious food and happy moments. Your experience matters to us.
            </p>
            
            <div class="flex items-center gap-3 mb-6 bg-white/60 backdrop-blur-sm rounded-full py-2 px-4 w-max border border-white/50 shadow-sm">
                <span class="text-[#ffb400] text-lg tracking-widest">★★★★★</span>
                <span class="text-[12px] font-bold text-[#06452e]">Top Rated</span>
            </div>
            
            <a href="#reviews" class="inline-flex items-center justify-center gap-2 bg-[#075b3a] hover:bg-[#06452e] text-white px-6 py-3.5 rounded-xl font-bold text-[14px] transition-all duration-300 shadow-[0_8px_20px_rgba(7,91,58,0.2)] hover:shadow-[0_10px_25px_rgba(7,91,58,0.3)] hover:-translate-y-0.5 w-full sm:w-auto">
                Explore Reviews 
                <span class="text-xl leading-none ml-1">→</span>
            </a>
        </div>
    </section>

    <!-- Menu Section -->
    <section id="menu" class="mt-10">
        <div class="flex items-center justify-between mb-5 px-1">
            <h2 class="text-xl font-extrabold text-[#173b2c] tracking-tight">Try Something New 🍹</h2>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Card 1 -->
            <article class="group relative bg-white p-5 rounded-[22px] border border-[#e8eeea] shadow-[0_4px_20px_rgba(0,0,0,0.02)] transition-all duration-300 hover:shadow-[0_12px_30px_rgba(7,91,58,0.08)] hover:-translate-y-1 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl group-hover:scale-110 group-hover:opacity-20 transition-all duration-500 origin-bottom-left">🥑</div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-[#e8f4ec] text-[#075b3a] text-[10px] font-bold rounded-full mb-3 uppercase tracking-wider">Fresh Drink</span>
                    <h3 class="text-[17px] font-bold text-[#173b2c] mb-1">Avocado Milkshake</h3>
                    <p class="text-[13px] text-[#77857c] font-medium">Creamy, rich and perfectly sweet.</p>
                </div>
            </article>
            
            <!-- Card 2 -->
            <article class="group relative bg-white p-5 rounded-[22px] border border-[#e8eeea] shadow-[0_4px_20px_rgba(0,0,0,0.02)] transition-all duration-300 hover:shadow-[0_12px_30px_rgba(7,91,58,0.08)] hover:-translate-y-1 overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl group-hover:scale-110 group-hover:opacity-20 transition-all duration-500 origin-bottom-left">🍨</div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-[#fff6e0] text-[#b38000] text-[10px] font-bold rounded-full mb-3 uppercase tracking-wider">Customer Favourite</span>
                    <h3 class="text-[17px] font-bold text-[#173b2c] mb-1">Falooda</h3>
                    <p class="text-[13px] text-[#77857c] font-medium">A refreshing sweet treat with ice cream.</p>
                </div>
            </article>
            
            <!-- Card 3 -->
            <article class="group relative bg-white p-5 rounded-[22px] border border-[#e8eeea] shadow-[0_4px_20px_rgba(0,0,0,0.02)] transition-all duration-300 hover:shadow-[0_12px_30px_rgba(7,91,58,0.08)] hover:-translate-y-1 overflow-hidden sm:col-span-2">
                <div class="absolute top-0 right-0 p-4 opacity-10 text-6xl group-hover:scale-110 group-hover:opacity-20 transition-all duration-500 origin-bottom-left">🍍</div>
                <div class="relative z-10">
                    <span class="inline-block px-3 py-1 bg-[#f0f2f4] text-[#4b5563] text-[10px] font-bold rounded-full mb-3 uppercase tracking-wider">Recommended</span>
                    <h3 class="text-[17px] font-bold text-[#173b2c] mb-1">Fresh Fruit Juice</h3>
                    <p class="text-[13px] text-[#77857c] font-medium">Made to order with seasonal fresh fruits.</p>
                </div>
            </article>
        </div>
    </section>

    <!-- Feedback CTA Section -->
    <section class="mt-10 mb-6">
        <div class="relative overflow-hidden bg-[#075b3a] rounded-[24px] p-7 sm:p-9 text-center shadow-[0_15px_40px_rgba(7,91,58,0.25)]">
            <!-- Background effects -->
            <div class="absolute inset-0 bg-gradient-to-tr from-[#054029] to-transparent opacity-80"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
            
            <div class="relative z-10 flex flex-col items-center">
                <div class="w-16 h-16 bg-white/10 rounded-full flex items-center justify-center text-3xl mb-4 backdrop-blur-sm border border-white/20">
                    ❤️
                </div>
                <h2 class="text-[22px] font-extrabold text-white mb-2 tracking-tight">We Value Your Feedback</h2>
                <p class="text-[#a7cbbd] text-[14px] font-medium mb-7 max-w-[260px] mx-auto leading-relaxed">
                    Tell us what you loved and how we can make your next visit even better.
                </p>
                
                <a href="{{ route('customer.feedback') }}" class="inline-flex items-center justify-center gap-2 bg-white text-[#075b3a] px-8 py-4 rounded-xl font-bold text-[15px] transition-transform duration-300 hover:scale-105 active:scale-95 shadow-lg w-full sm:w-auto">
                    Give Feedback Now
                    <span class="text-xl leading-none ml-1">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Reviews Section Placeholder -->
    <section id="reviews" class="mt-10">
        <div class="flex items-center justify-between mb-5 px-1">
            <h2 class="text-xl font-extrabold text-[#173b2c] tracking-tight">Recent Reviews ⭐</h2>
        </div>
        <div class="bg-white rounded-[20px] p-8 border border-dashed border-[#dce4de] text-center">
            <div class="text-4xl mb-3 opacity-50 grayscale">💬</div>
            <p class="text-[14px] font-medium text-[#77857c]">No published reviews yet.<br>Be the first to share your experience!</p>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="mt-10">
        <div class="flex items-center justify-between mb-5 px-1">
            <h2 class="text-xl font-extrabold text-[#173b2c] tracking-tight">Our Gallery 📸</h2>
        </div>
        
        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3">
            <div class="aspect-square bg-[#f5f8f6] rounded-[18px] flex items-center justify-center text-5xl hover:bg-[#e8f4ec] transition-colors duration-300">🍹</div>
            <div class="aspect-square bg-[#f5f8f6] rounded-[18px] flex items-center justify-center text-5xl hover:bg-[#e8f4ec] transition-colors duration-300">🥤</div>
            <div class="aspect-square bg-[#f5f8f6] rounded-[18px] flex items-center justify-center text-5xl hover:bg-[#e8f4ec] transition-colors duration-300">🍍</div>
            <div class="aspect-square bg-[#f5f8f6] rounded-[18px] flex items-center justify-center text-5xl hover:bg-[#e8f4ec] transition-colors duration-300">🍨</div>
            <div class="aspect-square bg-[#f5f8f6] rounded-[18px] flex items-center justify-center text-5xl hover:bg-[#e8f4ec] transition-colors duration-300 col-span-2 sm:col-span-1">🥑</div>
        </div>
    </section>

</main>
@endsection
