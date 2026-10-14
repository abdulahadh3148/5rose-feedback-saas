@extends('layouts.pos')

@section('title', 'POS System | 5Rose')

@section('content')
{{-- LEFT: MENU & PRODUCT CATALOG --}}
<div class="flex-1 flex flex-col min-w-0 bg-[#f4f7f4]">
    
    {{-- SEARCH & FILTER BAR --}}
    <div class="p-4 sm:p-5 pb-3 bg-white border-b border-gray-200/80 shadow-xs z-10 shrink-0">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mb-3">
            {{-- Search Bar --}}
            <div class="relative flex-1">
                <input 
                    type="search" 
                    id="productSearch" 
                    placeholder="Search menu (Press F2)..." 
                    autocomplete="off"
                    class="w-full h-12 pl-12 pr-10 rounded-2xl bg-gray-50 border border-gray-200 text-sm font-bold text-[#102d22] placeholder-gray-400 focus:bg-white focus:border-emerald-600 focus:ring-4 focus:ring-emerald-500/10 outline-none transition shadow-inner"
                >
                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">🔍</span>
                <button 
                    type="button" 
                    id="clearSearchBtn" 
                    onclick="clearSearch()" 
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 font-bold text-xs flex items-center justify-center transition"
                >
                    ✕
                </button>
            </div>

            {{-- View Toggle (Grid / List) & Quick Stats --}}
            <div class="flex items-center gap-2 shrink-0">
                <div class="flex rounded-xl bg-gray-100 p-1 border border-gray-200">
                    <button 
                        type="button"
                        id="viewGridBtn" 
                        onclick="setViewMode('grid')" 
                        title="Grid View (Large Photos)" 
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs"
                    >
                        🖼️ Grid
                    </button>
                    <button 
                        type="button"
                        id="viewListBtn" 
                        onclick="setViewMode('list')" 
                        title="Compact View (Rush Hours)" 
                        class="px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20]"
                    >
                        📑 Compact
                    </button>
                </div>
                <div class="hidden lg:flex items-center gap-1.5 px-3 py-2 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/60 text-xs font-bold">
                    <span>✨</span>
                    <span><strong id="visibleProductsCount">{{ count($products) }}</strong> items</span>
                </div>
            </div>
        </div>

        {{-- Categories Horizontal Bar --}}
        <div class="flex overflow-x-auto hide-scrollbar gap-2 pb-2 -mx-4 px-4 sm:mx-0 sm:px-0" id="categoryTabs">
            <button 
                data-cat="all" 
                class="cat-btn active whitespace-nowrap px-4 py-2 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 bg-[#08784b] text-white shadow-md shadow-emerald-800/10"
            >
                <span>⭐</span>
                <span>ALL ITEMS</span>
                <span class="ml-1 text-[10px] bg-white/20 px-1.5 py-0.5 rounded-full">{{ count($products) }}</span>
            </button>
            @foreach($categories as $category)
            @php
                $catProductCount = $products->where('category_id', $category->id)->count();
            @endphp
            <button 
                data-cat="{{ $category->id }}" 
                class="cat-btn whitespace-nowrap px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold transition hover:bg-gray-50 hover:border-gray-300 flex items-center gap-1.5 shadow-2xs"
            >
                <span>{{ $category->icon }}</span>
                <span>{{ strtoupper($category->name) }}</span>
                <span class="ml-1 text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-semibold">{{ $catProductCount }}</span>
            </button>
            @endforeach
        </div>
    </div>

    {{-- PRODUCT CATALOG --}}
    <div class="flex-1 overflow-y-auto p-4 sm:p-5 hide-scrollbar">
        {{-- GRID VIEW --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3.5 sm:gap-4.5" id="productGrid">
            @foreach($products as $product)
            <div 
                class="product-card group relative bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-xs hover:shadow-lg transition-all duration-200 cursor-pointer flex flex-col select-none active:scale-[0.98]"
                id="product-card-{{ $product->id }}"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-cat="{{ $product->category_id }}"
                data-img="{{ $product->image_url }}"
                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->image_url) }}')"
            >
                {{-- Product Image Container --}}
                <div class="h-32 sm:h-36 bg-gray-100 relative overflow-hidden">
                    <img 
                        src="{{ $product->image_url }}" 
                        alt="{{ $product->name }}"
                        loading="lazy"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        onerror="this.src='{{ asset('images/5rose/logo.png') }}'; this.classList.add('p-6','bg-emerald-950');"
                    >
                    
                    {{-- Subtle overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 via-transparent to-transparent opacity-40 group-hover:opacity-60 transition"></div>

                    {{-- Category Tag Badge --}}
                    <span class="absolute top-2.5 left-2.5 px-2 py-0.5 rounded-lg bg-black/60 backdrop-blur-md text-[10px] font-bold text-white shadow-xs">
                        {{ $product->category->name ?? 'Menu' }}
                    </span>

                    {{-- Dynamic In-Cart Quantity Badge --}}
                    <div 
                        id="cardBadge-{{ $product->id }}" 
                        class="hidden absolute top-2.5 right-2.5 h-7 px-2 rounded-full bg-emerald-600 text-white text-xs font-black flex items-center justify-center shadow-lg border-2 border-white transition-all transform scale-100"
                    >
                        <span class="card-qty">1</span>&nbsp;in cart
                    </div>
                </div>
                
                {{-- Product Details --}}
                <div class="p-3.5 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs sm:text-sm font-black text-[#102d22] leading-snug mb-1 group-hover:text-emerald-700 transition">
                            {{ $product->name }}
                        </h3>
                    </div>

                    <div class="mt-2.5 flex items-center justify-between pt-2 border-t border-gray-100">
                        <strong class="text-[#08784b] font-black text-sm sm:text-base">
                            Rs. {{ number_format($product->price, 0) }}
                        </strong>
                        <div class="flex items-center gap-1">
                            <button 
                                type="button" 
                                onclick="event.stopPropagation(); updateQty({{ $product->id }}, -1);"
                                class="card-dec-btn-{{ $product->id }} hidden w-7 h-7 rounded-full bg-red-50 text-red-600 hover:bg-red-500 hover:text-white font-bold text-sm transition flex items-center justify-center"
                                title="Reduce quantity"
                            >
                                -
                            </button>
                            <button 
                                type="button" 
                                class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-700 font-black group-hover:bg-[#08784b] group-hover:text-white transition flex items-center justify-center shadow-2xs text-sm"
                                title="Add to cart"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- COMPACT LIST VIEW (Hidden by default, toggleable) --}}
        <div class="hidden flex-col gap-2" id="productList">
            @foreach($products as $product)
            <div 
                class="product-card group bg-white rounded-xl border border-gray-200/80 p-2.5 sm:p-3 flex items-center justify-between shadow-2xs hover:shadow-md hover:border-emerald-300 transition cursor-pointer select-none"
                id="product-list-{{ $product->id }}"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-cat="{{ $product->category_id }}"
                data-img="{{ $product->image_url }}"
                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->image_url) }}')"
            >
                <div class="flex items-center gap-3 min-w-0">
                    <img 
                        src="{{ $product->image_url }}" 
                        alt="{{ $product->name }}" 
                        class="w-12 h-12 rounded-lg object-cover shrink-0 border border-gray-100"
                        onerror="this.src='{{ asset('images/5rose/logo.png') }}';"
                    >
                    <div class="min-w-0">
                        <h4 class="text-xs sm:text-sm font-black text-[#102d22] truncate">{{ $product->name }}</h4>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">{{ $product->category->name }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3 shrink-0">
                    <strong class="text-[#08784b] font-black text-sm sm:text-base">Rs. {{ number_format($product->price, 0) }}</strong>
                    <div id="listBadge-{{ $product->id }}" class="hidden px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                        <span class="card-qty">1</span>x
                    </div>
                    <button class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-700 font-bold group-hover:bg-[#08784b] group-hover:text-white transition flex items-center justify-center">
                        +
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- EMPTY SEARCH RESULTS --}}
        <div id="noResults" class="hidden text-center py-20">
            <div class="text-5xl mb-3">🔍</div>
            <h3 class="text-lg font-black text-[#102d22]">No products found</h3>
            <p class="text-sm text-gray-500 mt-1">Try another keyword or select "All Items".</p>
            <button onclick="clearSearch()" class="mt-4 px-4 py-2 rounded-xl bg-[#08784b] text-white text-xs font-bold shadow-sm">
                Reset Search
            </button>
        </div>
    </div>
</div>

{{-- RIGHT: CART & BILLING PANEL --}}
<div class="w-full md:w-[390px] lg:w-[430px] bg-white border-l border-gray-200 flex flex-col shrink-0 absolute md:relative inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-300 z-30 shadow-2xl md:shadow-none" id="cartDrawer">
    
    {{-- CART HEADER --}}
    <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
        <div class="flex items-center gap-2.5">
            <h2 class="text-lg font-black tracking-tight text-[#092c20]">Current Order</h2>
            <span id="cartHeaderBadge" class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                0 items
            </span>
        </div>
        <div class="flex items-center gap-2">
            <button 
                type="button" 
                onclick="clearCart()" 
                id="clearCartBtn"
                class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider text-red-500 hover:bg-red-50 transition opacity-50 cursor-not-allowed" 
                disabled
            >
                Clear
            </button>
            <button 
                type="button" 
                onclick="toggleCart()" 
                class="md:hidden grid h-8 w-8 place-items-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200"
            >
                ✕
            </button>
        </div>
    </div>

    {{-- ORDER TYPE SWITCH (DINE IN / TAKEAWAY) --}}
    <div class="p-3.5 border-b border-gray-100 bg-gray-50/70 shrink-0">
        <div class="flex rounded-xl bg-white p-1 border border-gray-200 shadow-xs">
            <button 
                type="button"
                onclick="setOrderType('dine_in')" 
                id="btnDineIn" 
                class="flex-1 rounded-lg py-2 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5"
            >
                <span>🍽️</span>
                <span>Dine In</span>
            </button>
            <button 
                type="button"
                onclick="setOrderType('takeaway')" 
                id="btnTakeaway" 
                class="flex-1 rounded-lg py-2 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5"
            >
                <span>🛍️</span>
                <span>Takeaway (+Rs.50)</span>
            </button>
        </div>
    </div>

    {{-- CART ITEMS CONTAINER --}}
    <div class="flex-1 overflow-y-auto p-4 hide-scrollbar space-y-2.5" id="cartItems">
        {{-- EMPTY STATE --}}
        <div id="emptyCart" class="h-full flex flex-col items-center justify-center text-center py-16 opacity-60">
            <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-3xl mb-3 shadow-inner">
                🛒
            </div>
            <p class="text-sm font-black text-gray-700">Your cart is empty</p>
            <p class="text-xs text-gray-400 mt-1 max-w-[200px]">Tap on any product from the catalog to build the order.</p>
        </div>
    </div>

    {{-- CART TOTALS & ACTIONS --}}
    <div class="p-4 sm:p-5 bg-white border-t border-gray-200 shadow-[0_-10px_30px_rgba(0,0,0,0.04)] shrink-0">
        
        {{-- Quick Discount Row --}}
        <div class="mb-3.5 pb-3 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 flex items-center gap-1">
                <span>🏷️</span> Discount:
            </span>
            <div class="flex items-center gap-1">
                <button type="button" onclick="setDiscountPercent(0)" class="disc-btn active px-2 py-1 rounded-md text-[11px] font-bold bg-[#092c20] text-white">0%</button>
                <button type="button" onclick="setDiscountPercent(5)" class="disc-btn px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200">5%</button>
                <button type="button" onclick="setDiscountPercent(10)" class="disc-btn px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200">10%</button>
                <button type="button" onclick="promptCustomDiscount()" class="px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200" title="Custom Amount">Custom</button>
            </div>
        </div>

        {{-- Breakdown Lines --}}
        <div class="space-y-1.5 mb-3 text-xs">
            <div class="flex justify-between text-gray-500">
                <span>Subtotal</span>
                <span class="font-bold text-gray-800">Rs. <span id="cartSubtotal">0.00</span></span>
            </div>
            <div id="discountRow" class="hidden flex justify-between text-amber-600 font-bold">
                <span>Discount</span>
                <span>-Rs. <span id="cartDiscount">0.00</span></span>
            </div>
            <div id="takeawayChargeRow" class="hidden flex justify-between text-gray-500">
                <span>Takeaway Fee</span>
                <span class="font-bold text-gray-800">Rs. <span id="cartTakeawayCharge">0.00</span></span>
            </div>
        </div>

        {{-- Grand Total --}}
        <div class="flex justify-between items-baseline mb-4 pt-2 border-t border-gray-200/80">
            <div>
                <span class="text-[10px] font-black uppercase tracking-widest text-gray-400 block">Total Due</span>
                <span class="text-xs font-bold text-emerald-700">All Taxes Included</span>
            </div>
            <span class="text-3xl font-black text-[#08784b] tracking-tight">
                Rs. <span id="cartTotal">0</span>
            </span>
        </div>

        {{-- Checkout Button --}}
        <button 
            type="button" 
            onclick="openCheckout()" 
            id="checkoutBtn" 
            disabled 
            class="w-full rounded-2xl bg-[#08784b] hover:bg-[#06633e] active:scale-[0.99] py-4 text-sm font-black text-white transition disabled:opacity-40 disabled:cursor-not-allowed shadow-xl shadow-emerald-700/20 flex items-center justify-center gap-2"
        >
            <span>PROCEED TO PAYMENT</span>
            <span class="bg-black/20 px-2 py-0.5 rounded-lg text-xs font-mono font-bold">F4</span>
        </button>
    </div>
</div>

{{-- MOBILE CART FLOATING BUTTON --}}
<button 
    type="button" 
    onclick="toggleCart()" 
    class="md:hidden fixed bottom-5 right-5 z-20 h-16 w-16 rounded-full bg-[#092c20] text-white shadow-2xl shadow-emerald-950/40 flex items-center justify-center active:scale-95 transition"
    aria-label="Open Cart"
>
    <div class="relative">
        <span class="text-2xl">🛒</span>
        <span id="mobileCartBadge" class="absolute -top-2.5 -right-3 h-5 min-w-[20px] px-1 rounded-full bg-emerald-500 text-[10px] font-black flex items-center justify-center opacity-0 transition-opacity shadow-sm">0</span>
    </div>
</button>

{{-- ========================================================
     CHECKOUT MODAL WITH FAST CASH BUTTONS & NUMPAD
======================================================== --}}
<div id="checkoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-3xl w-full max-w-lg mx-4 overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 max-h-[92vh] flex flex-col" id="checkoutModalContent">
        
        {{-- Modal Header --}}
        <div class="p-5 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-3">
                <span class="text-2xl">💳</span>
                <div>
                    <h2 class="text-lg font-black leading-tight">Payment &amp; Billing</h2>
                    <p class="text-xs text-white/60">Choose payment method &amp; confirm</p>
                </div>
            </div>
            <button type="button" onclick="closeCheckout()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <div class="p-6 overflow-y-auto space-y-5 hide-scrollbar flex-1">
            
            {{-- Big Total Banner --}}
            <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-200/60 flex justify-between items-center">
                <div>
                    <span class="text-xs font-extrabold uppercase tracking-widest text-emerald-800 block">Total Payable</span>
                    <span class="text-xs text-gray-500" id="modalItemsSummary">0 items</span>
                </div>
                <span class="text-3xl font-black text-[#08784b]">Rs. <span id="modalTotal">0</span></span>
            </div>

            {{-- Customer Phone (With WhatsApp receipt pill) --}}
            <div>
                <div class="flex justify-between items-center mb-1.5">
                    <label class="text-xs font-black uppercase tracking-wider text-gray-600">Customer Phone (Optional)</label>
                    <span class="text-[10px] font-bold text-emerald-800 bg-emerald-100/70 px-2 py-0.5 rounded-full border border-emerald-300/40">
                        📱 Instant WhatsApp Receipt
                    </span>
                </div>
                <div class="relative">
                    <input 
                        type="tel" 
                        id="custPhone" 
                        placeholder="077XXXXXXX" 
                        class="w-full h-11 pl-10 pr-4 rounded-xl border border-gray-200 bg-gray-50 text-sm font-bold text-gray-800 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition"
                    >
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                </div>
            </div>

            {{-- Customer Name --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Customer Name (Optional)</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="custName" 
                        placeholder="Walk-in Customer" 
                        class="w-full h-11 pl-10 pr-4 rounded-xl border border-gray-200 bg-gray-50 text-sm font-bold text-gray-800 focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition"
                    >
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                </div>
            </div>

            {{-- Payment Method Selection --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1.5">Payment Method</label>
                <div class="grid grid-cols-3 gap-2">
                    <button 
                        type="button"
                        onclick="setPaymentMethod('cash')" 
                        id="payCash" 
                        class="rounded-xl py-3 text-xs font-black transition flex flex-col items-center gap-1 bg-[#08784b] text-white border-2 border-[#08784b] shadow-xs"
                    >
                        <span class="text-base">💵</span>
                        <span>CASH</span>
                    </button>
                    <button 
                        type="button"
                        onclick="setPaymentMethod('card')" 
                        id="payCard" 
                        class="rounded-xl py-3 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50"
                    >
                        <span class="text-base">💳</span>
                        <span>CARD</span>
                    </button>
                    <button 
                        type="button"
                        onclick="setPaymentMethod('upi')" 
                        id="payUpi" 
                        class="rounded-xl py-3 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50"
                    >
                        <span class="text-base">📱</span>
                        <span>UPI / QR</span>
                    </button>
                </div>
            </div>
            
            {{-- Cash Received & Quick Note Tender Section --}}
            <div id="cashReceivedBlock" class="p-4 rounded-2xl bg-gray-50 border border-gray-200 space-y-3">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-black uppercase tracking-wider text-gray-600">Amount Received</label>
                    <span class="text-[11px] text-gray-400">Tap quick notes or type</span>
                </div>

                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-400 text-lg">Rs.</span>
                    <input 
                        type="number" 
                        id="amtReceived" 
                        step="any"
                        oninput="calculateChange()" 
                        placeholder="0.00"
                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 bg-white text-xl font-black text-[#102d22] focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none transition"
                    >
                </div>

                {{-- Quick Tender Pills (Exact, 500, 1000, 2000, 5000) --}}
                <div class="flex flex-wrap gap-1.5 pt-1">
                    <button type="button" onclick="setCashAmount('exact')" class="flex-1 min-w-[60px] py-1.5 px-2 rounded-lg bg-emerald-700 text-white font-bold text-xs hover:bg-emerald-800 transition">
                        Exact
                    </button>
                    <button type="button" onclick="setCashAmount(500)" class="flex-1 min-w-[60px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition">
                        500
                    </button>
                    <button type="button" onclick="setCashAmount(1000)" class="flex-1 min-w-[60px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition">
                        1,000
                    </button>
                    <button type="button" onclick="setCashAmount(2000)" class="flex-1 min-w-[60px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition">
                        2,000
                    </button>
                    <button type="button" onclick="setCashAmount(5000)" class="flex-1 min-w-[60px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition">
                        5,000
                    </button>
                </div>

                {{-- Change Calculation Banner --}}
                <div class="pt-2 border-t border-gray-200 flex justify-between items-center text-sm font-bold">
                    <span class="text-gray-600">Change to Return:</span>
                    <strong id="changeAmount" class="text-base text-gray-500">Rs. 0.00</strong>
                </div>
            </div>
        </div>
        
        {{-- Modal Footer --}}
        <div class="p-4 sm:p-5 bg-gray-50 border-t border-gray-200 shrink-0">
            <button 
                type="button"
                onclick="submitOrder()" 
                id="confirmOrderBtn" 
                class="w-full rounded-2xl bg-[#08784b] hover:bg-[#06633e] py-4 text-sm font-black text-white transition active:scale-[0.99] shadow-lg shadow-emerald-800/20 flex items-center justify-center gap-2"
            >
                <span>CONFIRM ORDER &amp; PRINT BILL</span>
                <span class="bg-black/20 px-2 py-0.5 rounded text-xs font-mono">↵</span>
            </button>
        </div>
    </div>
</div>

{{-- ========================================================
     ORDER SUCCESS & INSTANT WHATSAPP MODAL
======================================================== --}}
<div id="orderSuccessModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200">
    <div class="bg-white rounded-3xl w-full max-w-sm mx-4 overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 p-6 text-center" id="orderSuccessModalContent">
        <div class="mx-auto w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl font-black mb-3 shadow-inner">
            ✓
        </div>
        <h2 class="text-xl font-black text-[#092c20]">Order Completed!</h2>
        <p class="text-xs font-mono font-bold text-gray-400 mt-1" id="successReceiptNo">ORD-XXXX</p>
        
        <div class="my-4 p-4 rounded-2xl bg-emerald-50/60 border border-emerald-100 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-600">Total Collected</span>
            <span class="text-xl font-black text-[#08784b]" id="successTotal">Rs. 0</span>
        </div>

        <div class="space-y-2.5">
            <a 
                id="btnSendWhatsApp" 
                href="#" 
                target="_blank" 
                class="w-full rounded-2xl bg-[#25D366] hover:bg-[#20bd5a] text-white py-3.5 px-4 font-black text-sm flex items-center justify-center gap-2 transition shadow-lg shadow-emerald-600/25 active:scale-[0.99]"
            >
                <span class="text-lg">📱</span>
                <span id="whatsAppBtnLabel">Send WhatsApp Receipt</span>
            </a>

            <button 
                type="button"
                id="btnPrintReceipt" 
                onclick="printSuccessReceipt()" 
                class="w-full rounded-2xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 py-3 px-4 font-bold text-xs flex items-center justify-center gap-2 transition"
            >
                <span>🖨️</span>
                <span>Re-Print Thermal Bill</span>
            </button>

            <button 
                type="button"
                onclick="closeSuccessModal()" 
                class="w-full rounded-2xl bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 px-4 font-bold text-xs transition"
            >
                Next Order (Esc)
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ==========================================
    // 5ROSE POS ENGINE
    // ==========================================
    let cart = [];
    let orderType = 'dine_in';
    const TAKEAWAY_CHARGE = 50;
    let discountAmount = 0;
    let discountPercent = 0;
    let paymentMethod = 'cash';
    let isModalOpen = false;
    let isSuccessModalOpen = false;
    let currentSuccessOrderId = null;
    let viewMode = 'grid';

    // DOM Elements
    const searchInput = document.getElementById('productSearch');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const catBtns = document.querySelectorAll('.cat-btn');
    const noResults = document.getElementById('noResults');
    const cartItemsDiv = document.getElementById('cartItems');
    const emptyCartDiv = document.getElementById('emptyCart');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const clearCartBtn = document.getElementById('clearCartBtn');
    const mobileCartBadge = document.getElementById('mobileCartBadge');
    const cartHeaderBadge = document.getElementById('cartHeaderBadge');
    const visibleCountEl = document.getElementById('visibleProductsCount');

    // --- AUDIO FEEDBACK (Pleasant web audio chimes) ---
    function playBeep(type = 'add') {
        try {
            const ctx = new (window.AudioContext || window.webkitAudioContext)();
            const osc = ctx.createOscillator();
            const gain = ctx.createGain();
            osc.connect(gain);
            gain.connect(ctx.destination);
            
            if (type === 'add') {
                osc.frequency.setValueAtTime(587.33, ctx.currentTime); // D5
                osc.frequency.exponentialRampToValueAtTime(880, ctx.currentTime + 0.08); // A5
                gain.gain.setValueAtTime(0.12, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.08);
                osc.start();
                osc.stop(ctx.currentTime + 0.08);
            } else if (type === 'success') {
                osc.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
                osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.08); // E5
                osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.16); // G5
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
                osc.start();
                osc.stop(ctx.currentTime + 0.25);
            }
        } catch (e) {
            // Audio context not allowed or unsupported
        }
    }

    // --- VIEW MODE TOGGLE (Grid vs Compact) ---
    function setViewMode(mode) {
        viewMode = mode;
        const grid = document.getElementById('productGrid');
        const list = document.getElementById('productList');
        const gridBtn = document.getElementById('viewGridBtn');
        const listBtn = document.getElementById('viewListBtn');

        if (mode === 'grid') {
            grid.classList.remove('hidden');
            list.classList.add('hidden');
            gridBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs";
            listBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20]";
        } else {
            grid.classList.add('hidden');
            list.classList.remove('hidden');
            listBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs";
            gridBtn.className = "px-3 py-1.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20]";
        }
        filterProducts();
    }

    // --- SEARCH & CATEGORY FILTERING ---
    let currentCategory = 'all';

    function filterProducts() {
        const query = searchInput.value.toLowerCase().trim();
        clearSearchBtn.style.display = query.length > 0 ? 'flex' : 'none';

        const cards = document.querySelectorAll(viewMode === 'grid' ? '#productGrid .product-card' : '#productList .product-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const cat = card.dataset.cat;
            
            const matchesSearch = name.includes(query);
            const matchesCat = currentCategory === 'all' || cat === currentCategory;

            if (matchesSearch && matchesCat) {
                card.style.display = viewMode === 'grid' ? 'flex' : 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        if (visibleCountEl) visibleCountEl.innerText = visibleCount;
    }

    function clearSearch() {
        searchInput.value = '';
        searchInput.focus();
        filterProducts();
    }

    searchInput.addEventListener('input', filterProducts);

    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            catBtns.forEach(b => {
                b.className = "cat-btn whitespace-nowrap px-4 py-2 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold transition hover:bg-gray-50 hover:border-gray-300 flex items-center gap-1.5 shadow-2xs";
            });
            btn.className = "cat-btn active whitespace-nowrap px-4 py-2 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 bg-[#08784b] text-white shadow-md shadow-emerald-800/10";

            currentCategory = btn.dataset.cat;
            filterProducts();
        });
    });

    // --- CART MANAGEMENT ---
    function addToCart(id, name, price, img) {
        const existingItem = cart.find(item => item.id === id);
        if (existingItem) {
            existingItem.qty++;
        } else {
            cart.push({ id, name, price, img, qty: 1 });
        }
        playBeep('add');
        renderCart();
    }

    function updateQty(id, change) {
        const itemIndex = cart.findIndex(item => item.id === id);
        if (itemIndex > -1) {
            cart[itemIndex].qty += change;
            if (cart[itemIndex].qty <= 0) {
                cart.splice(itemIndex, 1);
            }
            renderCart();
        }
    }

    function removeItem(id) {
        const itemIndex = cart.findIndex(item => item.id === id);
        if (itemIndex > -1) {
            cart.splice(itemIndex, 1);
            renderCart();
        }
    }

    function clearCart() {
        if(cart.length > 0 && confirm('Clear the current order?')) {
            cart = [];
            discountAmount = 0;
            discountPercent = 0;
            renderCart();
        }
    }

    function setOrderType(type) {
        orderType = type;
        const btnDine = document.getElementById('btnDineIn');
        const btnTake = document.getElementById('btnTakeaway');
        const takeawayRow = document.getElementById('takeawayChargeRow');
        
        if(type === 'dine_in') {
            btnDine.className = "flex-1 rounded-lg py-2 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5";
            btnTake.className = "flex-1 rounded-lg py-2 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5";
            takeawayRow.classList.add('hidden');
        } else {
            btnTake.className = "flex-1 rounded-lg py-2 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5";
            btnDine.className = "flex-1 rounded-lg py-2 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5";
            takeawayRow.classList.remove('hidden');
        }
        renderTotals();
    }

    function setDiscountPercent(pct) {
        discountPercent = pct;
        discountAmount = 0;
        
        document.querySelectorAll('.disc-btn').forEach((b, idx) => {
            const pcts = [0, 5, 10];
            if (pcts[idx] === pct) {
                b.className = "disc-btn active px-2 py-1 rounded-md text-[11px] font-bold bg-[#092c20] text-white";
            } else {
                b.className = "disc-btn px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200";
            }
        });
        renderTotals();
    }

    function promptCustomDiscount() {
        const val = prompt('Enter custom discount amount in Rs:', discountAmount || '');
        if (val !== null) {
            const parsed = parseFloat(val);
            if (!isNaN(parsed) && parsed >= 0) {
                discountAmount = parsed;
                discountPercent = 0;
                document.querySelectorAll('.disc-btn').forEach(b => {
                    b.className = "disc-btn px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200";
                });
                renderTotals();
            }
        }
    }

    function renderCart() {
        emptyCartDiv.style.display = cart.length === 0 ? 'flex' : 'none';
        checkoutBtn.disabled = cart.length === 0;
        clearCartBtn.disabled = cart.length === 0;
        clearCartBtn.style.opacity = cart.length > 0 ? '1' : '0.5';
        clearCartBtn.style.cursor = cart.length > 0 ? 'pointer' : 'not-allowed';
        
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        mobileCartBadge.innerText = totalItems;
        mobileCartBadge.style.opacity = totalItems > 0 ? '1' : '0';
        cartHeaderBadge.innerText = totalItems + (totalItems === 1 ? ' item' : ' items');

        // Clear existing cart list elements
        cartItemsDiv.innerHTML = '';
        cartItemsDiv.appendChild(emptyCartDiv);

        cart.forEach(item => {
            const el = document.createElement('div');
            el.className = 'flex items-center justify-between p-2.5 rounded-2xl bg-gray-50/80 hover:bg-gray-100/70 border border-gray-100 transition';
            el.innerHTML = `
                <div class="flex items-center gap-2.5 min-w-0 flex-1 pr-2">
                    <img src="${item.img || '{{ asset('images/5rose/logo.png') }}'}" class="w-10 h-10 rounded-xl object-cover shrink-0 border border-gray-200 bg-white" onerror="this.src='{{ asset('images/5rose/logo.png') }}';">
                    <div class="min-w-0">
                        <h4 class="text-xs font-black text-[#102d22] leading-tight truncate">${item.name}</h4>
                        <span class="text-[11px] text-gray-400 font-semibold">Rs. ${item.price.toLocaleString()}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <div class="flex items-center rounded-xl border border-gray-200 bg-white shadow-2xs">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-red-600 font-bold text-sm transition active:scale-90">-</button>
                        <span class="w-6 text-center text-xs font-black text-[#102d22]">${item.qty}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-7 h-7 flex items-center justify-center text-gray-500 hover:text-emerald-700 font-bold text-sm transition active:scale-90">+</button>
                    </div>
                    
                    <strong class="w-14 text-right text-xs font-black text-[#08784b]">
                        ${(item.price * item.qty).toLocaleString()}
                    </strong>

                    <button type="button" onclick="removeItem(${item.id})" class="text-gray-300 hover:text-red-500 text-xs p-1 transition" title="Remove item">
                        🗑️
                    </button>
                </div>
            `;
            cartItemsDiv.appendChild(el);
        });

        // Update product card badges on grid
        updateProductCardBadges();
        renderTotals();
    }

    function updateProductCardBadges() {
        // Reset all card badges
        document.querySelectorAll('.card-badge').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('[id^="cardBadge-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('[id^="listBadge-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('[class*="card-dec-btn-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('.product-card').forEach(c => {
            c.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/20');
        });

        cart.forEach(item => {
            // Grid card badge
            const badge = document.getElementById(`cardBadge-${item.id}`);
            const card = document.getElementById(`product-card-${item.id}`);
            const decBtn = document.querySelector(`.card-dec-btn-${item.id}`);
            if (badge) {
                badge.classList.remove('hidden');
                badge.querySelector('.card-qty').innerText = item.qty;
            }
            if (card) {
                card.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/20');
            }
            if (decBtn) {
                decBtn.classList.remove('hidden');
            }

            // List view badge
            const listBadge = document.getElementById(`listBadge-${item.id}`);
            const listCard = document.getElementById(`product-list-${item.id}`);
            if (listBadge) {
                listBadge.classList.remove('hidden');
                listBadge.querySelector('.card-qty').innerText = item.qty;
            }
            if (listCard) {
                listCard.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/20');
            }
        });
    }

    function renderTotals() {
        const subtotal = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        const takeawayCharge = orderType === 'takeaway' ? TAKEAWAY_CHARGE : 0;
        
        let calculatedDiscount = discountAmount;
        if (discountPercent > 0) {
            calculatedDiscount = Math.round((subtotal * discountPercent) / 100);
        }

        const total = Math.max(0, subtotal + takeawayCharge - calculatedDiscount);

        document.getElementById('cartSubtotal').innerText = subtotal.toLocaleString(undefined, { minimumFractionDigits: 2 });
        document.getElementById('cartTakeawayCharge').innerText = takeawayCharge.toLocaleString(undefined, { minimumFractionDigits: 2 });
        
        const discRow = document.getElementById('discountRow');
        if (calculatedDiscount > 0) {
            discRow.classList.remove('hidden');
            document.getElementById('cartDiscount').innerText = calculatedDiscount.toLocaleString(undefined, { minimumFractionDigits: 2 });
        } else {
            discRow.classList.add('hidden');
        }

        document.getElementById('cartTotal').innerText = total.toLocaleString();
        return { subtotal, takeawayCharge, discount: calculatedDiscount, total };
    }

    // --- MOBILE DRAWER TOGGLE ---
    function toggleCart() {
        const drawer = document.getElementById('cartDrawer');
        drawer.classList.toggle('translate-x-full');
    }

    // --- CHECKOUT MODAL LOGIC ---
    let finalPayableTotal = 0;

    function openCheckout() {
        if(cart.length === 0) return;
        
        const totals = renderTotals();
        finalPayableTotal = totals.total;

        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('modalTotal').innerText = finalPayableTotal.toLocaleString();
        document.getElementById('modalItemsSummary').innerText = `${totalItems} item${totalItems === 1 ? '' : 's'} · ${orderType === 'takeaway' ? 'Takeaway' : 'Dine In'}`;
        document.getElementById('amtReceived').value = finalPayableTotal;
        calculateChange();
        
        setPaymentMethod('cash');
        
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        isModalOpen = true;
        
        setTimeout(() => document.getElementById('amtReceived').select(), 150);
    }

    function closeCheckout() {
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        isModalOpen = false;
    }

    function setPaymentMethod(method) {
        paymentMethod = method;
        const btns = {
            'cash': document.getElementById('payCash'),
            'card': document.getElementById('payCard'),
            'upi': document.getElementById('payUpi')
        };
        
        Object.values(btns).forEach(b => {
            b.className = "rounded-xl py-3 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50";
        });
        
        btns[method].className = "rounded-xl py-3 text-xs font-black transition flex flex-col items-center gap-1 bg-[#08784b] text-white border-2 border-[#08784b] shadow-xs";
        
        const cashBlock = document.getElementById('cashReceivedBlock');
        cashBlock.style.display = method === 'cash' ? 'block' : 'none';
    }

    function setCashAmount(val) {
        const amtInput = document.getElementById('amtReceived');
        if (val === 'exact') {
            amtInput.value = finalPayableTotal;
        } else {
            amtInput.value = val;
        }
        calculateChange();
    }

    function calculateChange() {
        if(paymentMethod !== 'cash') return;
        
        const received = parseFloat(document.getElementById('amtReceived').value) || 0;
        const change = received - finalPayableTotal;
        const changeEl = document.getElementById('changeAmount');

        if (change >= 0) {
            changeEl.innerText = 'Rs. ' + change.toLocaleString(undefined, { minimumFractionDigits: 2 });
            changeEl.className = 'text-base font-black text-emerald-600';
        } else {
            changeEl.innerText = 'Short by Rs. ' + Math.abs(change).toLocaleString(undefined, { minimumFractionDigits: 2 });
            changeEl.className = 'text-base font-black text-red-500';
        }
    }

    // --- SUBMIT ORDER VIA AJAX ---
    async function submitOrder() {
        const btn = document.getElementById('confirmOrderBtn');
        btn.disabled = true;
        btn.innerHTML = '<span>SAVING ORDER...</span>';

        const totals = renderTotals();
        const received = paymentMethod === 'cash' 
            ? (parseFloat(document.getElementById('amtReceived').value) || finalPayableTotal) 
            : finalPayableTotal;

        const payload = {
            items: cart,
            order_type: orderType,
            payment_method: paymentMethod,
            amount_received: received,
            discount: totals.discount,
            customer_name: document.getElementById('custName').value.trim(),
            customer_phone: document.getElementById('custPhone').value.trim(),
        };

        try {
            const response = await fetch('{{ route('admin.pos.store') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });

            const data = await response.json();
            
            if (data.success) {
                playBeep('success');
                // Clear cart state
                cart = [];
                discountAmount = 0;
                discountPercent = 0;
                renderCart();
                closeCheckout();
                
                // Reset inputs
                document.getElementById('custName').value = '';
                document.getElementById('custPhone').value = '';
                
                // Show order success modal
                openSuccessModal(data);
                
            } else {
                alert(data.message || 'Error processing order');
            }
        } catch (error) {
            console.error('Checkout error:', error);
            alert('A network error occurred. Please check connection and try again.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = '<span>CONFIRM ORDER &amp; PRINT BILL</span> <span class="bg-black/20 px-2 py-0.5 rounded text-xs font-mono">↵</span>';
        }
    }

    // --- SUCCESS MODAL & ACTIONS ---
    function openSuccessModal(orderData) {
        currentSuccessOrderId = orderData.order_id;
        document.getElementById('successReceiptNo').innerText = orderData.receipt_number || ('ORD-' + orderData.order_id);
        document.getElementById('successTotal').innerText = 'Rs. ' + Number(orderData.total || 0).toLocaleString();

        const waBtn = document.getElementById('btnSendWhatsApp');
        waBtn.href = orderData.whatsapp_url;

        if (orderData.customer_phone) {
            document.getElementById('whatsAppBtnLabel').innerText = 'Send WhatsApp to ' + orderData.customer_phone;
        } else {
            document.getElementById('whatsAppBtnLabel').innerText = 'Share WhatsApp Receipt';
        }

        const modal = document.getElementById('orderSuccessModal');
        const content = document.getElementById('orderSuccessModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        isSuccessModalOpen = true;

        // Auto popup thermal receipt window for immediate printing
        window.open('/pos/receipt/' + orderData.order_id, 'Receipt', 'width=400,height=600');
    }

    function closeSuccessModal() {
        const modal = document.getElementById('orderSuccessModal');
        const content = document.getElementById('orderSuccessModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        isSuccessModalOpen = false;
        currentSuccessOrderId = null;
    }

    function printSuccessReceipt() {
        if (currentSuccessOrderId) {
            window.open('/pos/receipt/' + currentSuccessOrderId, 'Receipt', 'width=400,height=600');
        }
    }

    // --- KEYBOARD SHORTCUTS ---
    document.addEventListener('keydown', (e) => {
        // F4: Charge / Checkout
        if (e.key === 'F4') {
            e.preventDefault();
            if (isSuccessModalOpen) {
                closeSuccessModal();
            } else if (!checkoutBtn.disabled && !isModalOpen) {
                openCheckout();
            }
        }
        
        // Escape: Close active modals
        if (e.key === 'Escape') {
            if (isSuccessModalOpen) {
                closeSuccessModal();
            } else if (isModalOpen) {
                closeCheckout();
            }
        }

        // F2: Focus Search
        if (e.key === 'F2') {
            e.preventDefault();
            if (!isModalOpen && !isSuccessModalOpen) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // Enter key inside checkout modal to confirm
        if (e.key === 'Enter' && isModalOpen && !e.target.matches('textarea')) {
            e.preventDefault();
            submitOrder();
        }
    });

</script>
@endpush
