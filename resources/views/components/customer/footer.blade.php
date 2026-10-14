<footer class="bg-[#073d2b] text-white mt-12 py-10 px-5 rounded-t-[30px] shadow-2xl relative overflow-hidden">
    <!-- Decorative subtle gradient -->
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#075b3a] via-[#10b981] to-[#075b3a] opacity-80"></div>
    
    <div class="max-w-[480px] mx-auto text-center relative z-10">
        <div class="flex items-center justify-center gap-2.5 mb-2">
            <img
                src="{{ asset('images/5rose/logo.png') }}"
                alt="5Rose Logo"
                class="w-7 h-7 object-contain rounded-lg bg-white/10 p-0.5 border border-white/20"
                onerror="this.style.display='none';"
            >
            <h2 class="text-2xl font-extrabold tracking-tight">5Rose Cool Bar</h2>
        </div>
        <p class="text-[#84a999] text-sm font-medium mb-6">Fresh Drinks • Great Taste • Happy People</p>
        
        <div class="flex justify-center gap-6 mb-8">
            <a href="{{ route('customer.home') }}#discover" class="text-[#a7cbbd] hover:text-white text-sm font-semibold transition-colors">Menu</a>
            <a href="{{ route('customer.home') }}#reviews" class="text-[#a7cbbd] hover:text-white text-sm font-semibold transition-colors">Reviews</a>
            <a href="{{ route('customer.home') }}#gallery" class="text-[#a7cbbd] hover:text-white text-sm font-semibold transition-colors">Gallery</a>
            <a href="{{ route('customer.feedback') }}" class="text-[#a7cbbd] hover:text-white text-sm font-semibold transition-colors">Feedback</a>
        </div>
        
        <div class="border-t border-[#124d3a] pt-6 flex flex-col items-center gap-3">
            <p class="text-[11px] text-[#698a7b]">© {{ date('Y') }} 5Rose Cool Bar. All rights reserved.</p>
            <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/5 hover:bg-white/10 text-[11px] font-semibold text-[#84a999] hover:text-white border border-white/10 transition-colors">
                <span>🔒 Staff / Admin Login</span>
            </a>
        </div>
    </div>
</footer>
