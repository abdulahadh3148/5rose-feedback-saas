@extends('layouts.pos')

@section('title', '5Rose POS - Smart Billing')

@section('content')
{{-- ========================================================
     LEFT PANEL: PRODUCT CATALOG & FAST NAVIGATION
======================================================== --}}
<div class="flex-1 flex flex-col min-w-0 bg-[#f4f7f4] relative">
    
    {{-- SEARCH & CONTROLS TOOLBAR --}}
    <div class="p-3 sm:p-4 pb-2.5 bg-white border-b border-gray-200 shadow-xs z-10 shrink-0">
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5 mb-2.5">
            {{-- Search Bar with Enter-to-Add --}}
            <div class="relative flex-1">
                <input 
                    type="search" 
                    id="productSearch" 
                    placeholder="Search menu or press Enter to add (F2)..." 
                    autocomplete="off"
                    class="w-full h-11 pl-11 pr-10 rounded-xl bg-gray-50 border border-gray-200 text-sm font-bold text-[#102d22] placeholder-gray-400 focus:bg-white focus:border-emerald-600 focus:ring-3 focus:ring-emerald-500/15 outline-none transition shadow-inner"
                >
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 text-base">🔍</span>
                <button 
                    type="button" 
                    id="clearSearchBtn" 
                    onclick="clearSearch()" 
                    class="hidden absolute right-3 top-1/2 -translate-y-1/2 w-6 h-6 rounded-full bg-gray-200 text-gray-600 hover:bg-gray-300 font-bold text-xs flex items-center justify-center transition"
                >
                    ✕
                </button>
            </div>

            {{-- Action Tools: + Custom Item, Grid/List Toggle, Stats --}}
            <div class="flex items-center gap-2 shrink-0">
                {{-- Fast Custom Item Button --}}
                <button 
                    type="button" 
                    onclick="openCustomItemModal()" 
                    class="h-11 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-xs font-black flex items-center gap-1.5 transition active:scale-95 shadow-2xs"
                    title="Add Custom / Open Item (F8)"
                >
                    <span class="text-base font-bold">+</span>
                    <span class="hidden md:inline">Custom Item</span>
                    <span class="hidden xl:inline text-[10px] bg-emerald-200/60 px-1.5 py-0.5 rounded text-emerald-900 font-mono">F8</span>
                </button>

                {{-- View Toggle (Grid / Compact) --}}
                <div class="flex h-11 rounded-xl bg-gray-100 p-1 border border-gray-200 items-center">
                    <button 
                        type="button"
                        id="viewGridBtn" 
                        onclick="setViewMode('grid')" 
                        title="Grid View (Photos)" 
                        class="h-full px-2.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs flex items-center gap-1"
                    >
                        <span>🖼️</span>
                        <span class="hidden sm:inline">Grid</span>
                    </button>
                    <button 
                        type="button"
                        id="viewListBtn" 
                        onclick="setViewMode('list')" 
                        title="Compact View (Rush Hours)" 
                        class="h-full px-2.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20] flex items-center gap-1"
                    >
                        <span>📑</span>
                        <span class="hidden sm:inline">List</span>
                    </button>
                </div>

                {{-- Total Item Counter --}}
                <div class="hidden lg:flex h-11 items-center px-3 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200/60 text-xs font-bold">
                    <span>✨ <strong id="visibleProductsCount">{{ count($products) }}</strong> items</span>
                </div>
            </div>
        </div>

        {{-- Categories Horizontal Carousel Bar --}}
        <div class="flex overflow-x-auto hide-scrollbar gap-1.5 pb-1 -mx-3 px-3 sm:mx-0 sm:px-0" id="categoryTabs">
            <button 
                data-cat="all" 
                class="cat-btn active whitespace-nowrap px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 bg-[#08784b] text-white shadow-xs"
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
                class="cat-btn whitespace-nowrap px-3.5 py-1.5 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold transition hover:bg-gray-50 hover:border-gray-300 flex items-center gap-1.5 shadow-2xs"
            >
                <span>{{ $category->icon ?: '🍽️' }}</span>
                <span>{{ strtoupper($category->name) }}</span>
                <span class="ml-1 text-[10px] bg-gray-100 text-gray-500 px-1.5 py-0.5 rounded-full font-semibold">{{ $catProductCount }}</span>
            </button>
            @endforeach
        </div>
    </div>

    {{-- PRODUCT CATALOG CONTAINER --}}
    <div class="flex-1 overflow-y-auto p-3 sm:p-4 hide-scrollbar">
        {{-- GRID VIEW --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3" id="productGrid">
            @foreach($products as $product)
            <div 
                class="product-card group relative bg-white rounded-2xl border border-gray-200/80 overflow-hidden shadow-2xs hover:shadow-lg hover:border-emerald-400 transition-all duration-200 cursor-pointer flex flex-col select-none active:scale-[0.98]"
                id="product-card-{{ $product->id }}"
                data-id="{{ $product->id }}"
                data-name="{{ $product->name }}"
                data-price="{{ $product->price }}"
                data-cat="{{ $product->category_id }}"
                data-img="{{ $product->image_url }}"
                onclick="addToCart({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ addslashes($product->image_url) }}')"
            >
                {{-- Product Image Container --}}
                <div class="h-28 sm:h-32 bg-gray-100 relative overflow-hidden">
                    <img 
                        src="{{ $product->image_url }}" 
                        alt="{{ $product->name }}"
                        loading="lazy"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                        onerror="this.src='{{ asset('images/5rose/logo.png') }}'; this.classList.add('p-5','bg-emerald-950');"
                    >
                    
                    {{-- Overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-40 group-hover:opacity-60 transition"></div>

                    {{-- Category Tag Badge --}}
                    <span class="absolute top-2 left-2 px-2 py-0.5 rounded-md bg-black/60 backdrop-blur-md text-[10px] font-bold text-white shadow-xs">
                        {{ $product->category->name ?? 'Menu' }}
                    </span>

                    {{-- Dynamic In-Cart Quantity Badge --}}
                    <div 
                        id="cardBadge-{{ $product->id }}" 
                        class="hidden absolute top-2 right-2 h-6 px-2 rounded-full bg-emerald-600 text-white text-[11px] font-black flex items-center justify-center shadow-md border border-white"
                    >
                        <span class="card-qty">1</span>&nbsp;in cart
                    </div>
                </div>
                
                {{-- Product Details --}}
                <div class="p-3 flex-1 flex flex-col justify-between">
                    <div>
                        <h3 class="text-xs sm:text-sm font-black text-[#102d22] leading-snug group-hover:text-emerald-700 transition line-clamp-2">
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
                                class="card-dec-btn-{{ $product->id }} hidden w-7 h-7 rounded-lg bg-red-50 text-red-600 hover:bg-red-500 hover:text-white font-bold text-sm transition flex items-center justify-center"
                                title="Reduce"
                            >
                                -
                            </button>
                            <button 
                                type="button" 
                                class="w-7 h-7 rounded-lg bg-emerald-50 text-emerald-700 font-black group-hover:bg-[#08784b] group-hover:text-white transition flex items-center justify-center shadow-2xs text-sm"
                                title="Add"
                            >
                                +
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- COMPACT LIST VIEW --}}
        <div class="hidden flex-col gap-2" id="productList">
            @foreach($products as $product)
            <div 
                class="product-card group bg-white rounded-xl border border-gray-200/80 p-2 sm:p-2.5 flex items-center justify-between shadow-2xs hover:shadow-md hover:border-emerald-300 transition cursor-pointer select-none"
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
                        class="w-10 h-10 rounded-lg object-cover shrink-0 border border-gray-100"
                        onerror="this.src='{{ asset('images/5rose/logo.png') }}';"
                    >
                    <div class="min-w-0">
                        <h4 class="text-xs sm:text-sm font-black text-[#102d22] truncate">{{ $product->name }}</h4>
                        <span class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">{{ $product->category->name }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    <strong class="text-[#08784b] font-black text-sm sm:text-base">Rs. {{ number_format($product->price, 0) }}</strong>
                    <div id="listBadge-{{ $product->id }}" class="hidden px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black">
                        <span class="card-qty">1</span>x
                    </div>
                    <button class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-700 font-bold group-hover:bg-[#08784b] group-hover:text-white transition flex items-center justify-center">
                        +
                    </button>
                </div>
            </div>
            @endforeach
        </div>
        
        {{-- EMPTY SEARCH RESULTS --}}
        <div id="noResults" class="hidden text-center py-16">
            <div class="text-5xl mb-3">🔍</div>
            <h3 class="text-base font-black text-[#102d22]">No menu items found</h3>
            <p class="text-xs text-gray-500 mt-1">Try another keyword or tap "+ Custom Item" to create one on the fly.</p>
            <div class="mt-3 flex justify-center gap-2">
                <button onclick="clearSearch()" class="px-3.5 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold transition">
                    Reset Search
                </button>
                <button onclick="openCustomItemModal()" class="px-3.5 py-1.5 rounded-xl bg-[#08784b] hover:bg-[#06633e] text-white text-xs font-bold shadow-xs transition">
                    + Add Custom Item
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================
     RIGHT PANEL: ACTIVE ORDER / CART & TOTALS
======================================================== --}}
<div class="w-full md:w-[390px] lg:w-[420px] bg-white border-l border-gray-200 flex flex-col shrink-0 absolute md:relative inset-y-0 right-0 transform translate-x-full md:translate-x-0 transition-transform duration-300 z-30 shadow-2xl md:shadow-none" id="cartDrawer">
    
    {{-- CART HEADER WITH MULTI-ORDER ACTIONS --}}
    <div class="p-3.5 sm:p-4 border-b border-gray-100 flex items-center justify-between bg-white shrink-0">
        <div class="flex items-center gap-2">
            <h2 class="text-base sm:text-lg font-black tracking-tight text-[#092c20]">Active Order</h2>
            <span id="cartHeaderBadge" class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[11px] font-black">
                0 items
            </span>
        </div>
        <div class="flex items-center gap-1.5">
            {{-- Hold Order Button --}}
            <button 
                type="button" 
                onclick="holdCurrentOrder()" 
                id="holdCartBtn"
                class="px-2.5 py-1 rounded-lg text-xs font-bold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200/70 transition opacity-50 cursor-not-allowed flex items-center gap-1"
                title="Park / Hold this order for later (F1)"
                disabled
            >
                <span>⏸️</span>
                <span class="hidden sm:inline">Hold</span>
            </button>

            {{-- Clear Cart Button --}}
            <button 
                type="button" 
                onclick="clearCart()" 
                id="clearCartBtn"
                class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider text-red-500 hover:bg-red-50 transition opacity-50 cursor-not-allowed" 
                disabled
            >
                Clear
            </button>

            {{-- Close Mobile Drawer --}}
            <button 
                type="button" 
                onclick="toggleCart()" 
                class="md:hidden grid h-8 w-8 place-items-center rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200"
            >
                ✕
            </button>
        </div>
    </div>

    {{-- ORDER TYPE SWITCH (DINE IN / TAKEAWAY) & TABLE / TOKEN NO --}}
    <div class="p-3 border-b border-gray-100 bg-gray-50/70 shrink-0 space-y-2">
        <div class="flex rounded-xl bg-white p-1 border border-gray-200 shadow-2xs">
            <button 
                type="button"
                onclick="setOrderType('dine_in')" 
                id="btnDineIn" 
                class="flex-1 rounded-lg py-1.5 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5"
            >
                <span>🍽️</span>
                <span>Dine In</span>
            </button>
            <button 
                type="button"
                onclick="setOrderType('takeaway')" 
                id="btnTakeaway" 
                class="flex-1 rounded-lg py-1.5 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5"
            >
                <span>🛍️</span>
                <span>Takeaway (+Rs.50)</span>
            </button>
        </div>

        {{-- Table / Token Quick Input --}}
        <div class="flex items-center gap-2">
            <div class="relative flex-1">
                <input 
                    type="text" 
                    id="orderTableNo" 
                    placeholder="Table / Token # (Optional)..." 
                    class="w-full h-8 pl-8 pr-3 rounded-lg border border-gray-200 bg-white text-xs font-bold text-gray-800 placeholder-gray-400 focus:border-emerald-500 outline-none transition"
                >
                <span class="absolute left-2.5 top-1/2 -translate-y-1/2 text-gray-400 text-xs">🏷️</span>
            </div>
            <button 
                type="button" 
                onclick="openOrderNotesModal()" 
                id="btnOrderNote" 
                class="h-8 px-2.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-[11px] font-bold text-gray-600 transition flex items-center gap-1"
                title="Add kitchen/bill note"
            >
                <span>📝</span>
                <span id="orderNoteStatus">Note</span>
            </button>
        </div>
    </div>

    {{-- CART ITEMS CONTAINER --}}
    <div class="flex-1 overflow-y-auto p-3 hide-scrollbar space-y-2" id="cartItems">
        {{-- EMPTY STATE --}}
        <div id="emptyCart" class="h-full flex flex-col items-center justify-center text-center py-12 opacity-60">
            <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mb-2.5 shadow-inner">
                🛒
            </div>
            <p class="text-sm font-black text-gray-700">Order is empty</p>
            <p class="text-xs text-gray-400 mt-0.5 max-w-[200px]">Tap products from the catalog or click "+ Custom Item" to bill.</p>
        </div>
    </div>

    {{-- CART TOTALS & CHECKOUT PANEL --}}
    <div class="p-3.5 sm:p-4 bg-white border-t border-gray-200 shadow-[0_-10px_25px_rgba(0,0,0,0.03)] shrink-0">
        
        {{-- Quick Discount Row --}}
        <div class="mb-2.5 pb-2 border-b border-gray-100 flex items-center justify-between">
            <span class="text-xs font-bold text-gray-500 flex items-center gap-1">
                <span>🏷️</span> Discount:
            </span>
            <div class="flex items-center gap-1">
                <button type="button" onclick="setDiscountPercent(0)" class="disc-btn active px-2 py-0.5 rounded-md text-[11px] font-bold bg-[#092c20] text-white">0%</button>
                <button type="button" onclick="setDiscountPercent(5)" class="disc-btn px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200">5%</button>
                <button type="button" onclick="setDiscountPercent(10)" class="disc-btn px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200">10%</button>
                <button type="button" onclick="promptCustomDiscount()" class="px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200" title="Custom Amount">Custom</button>
            </div>
        </div>

        {{-- Breakdown Lines --}}
        <div class="space-y-1 mb-2.5 text-xs">
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
        <div class="flex justify-between items-baseline mb-3 pt-2 border-t border-gray-200/80">
            <div>
                <span class="text-[9px] font-black uppercase tracking-widest text-gray-400 block">Total Due</span>
                <span class="text-[11px] font-bold text-emerald-700">Taxes Included</span>
            </div>
            <span class="text-2xl sm:text-3xl font-black text-[#08784b] tracking-tight">
                Rs. <span id="cartTotal">0</span>
            </span>
        </div>

        {{-- Checkout Button --}}
        <button 
            type="button" 
            onclick="openCheckout()" 
            id="checkoutBtn" 
            disabled 
            class="w-full rounded-2xl bg-[#08784b] hover:bg-[#06633e] active:scale-[0.99] py-3.5 text-sm font-black text-white transition disabled:opacity-40 disabled:cursor-not-allowed shadow-xl shadow-emerald-700/20 flex items-center justify-center gap-2"
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
     MODAL 1: ADVANCED CHECKOUT & INTERACTIVE NUMPAD
======================================================== --}}
<div id="checkoutModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-3 sm:p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 max-h-[94vh] flex flex-col" id="checkoutModalContent">
        
        {{-- Modal Header --}}
        <div class="p-4 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl">💳</span>
                <div>
                    <h2 class="text-base sm:text-lg font-black leading-tight">Payment &amp; Billing</h2>
                    <p class="text-xs text-emerald-300/80" id="modalItemsSummary">0 items</p>
                </div>
            </div>
            <button type="button" onclick="closeCheckout()" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <div class="p-4 sm:p-5 overflow-y-auto space-y-4 hide-scrollbar flex-1">
            
            {{-- Big Total Banner --}}
            <div class="p-3.5 rounded-2xl bg-emerald-50 border border-emerald-200/70 flex justify-between items-center">
                <div>
                    <span class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-800 block">Total Payable</span>
                    <span class="text-xs font-bold text-gray-500" id="modalOrderTypeSummary">Dine In</span>
                </div>
                <span class="text-2xl sm:text-3xl font-black text-[#08784b]">Rs. <span id="modalTotal">0</span></span>
            </div>

            {{-- Customer Phone with Live Autocomplete + WhatsApp Badge --}}
            <div class="relative">
                <div class="flex justify-between items-center mb-1">
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
                        autocomplete="off"
                        oninput="handleCustomerPhoneInput(this.value)"
                        class="w-full h-11 pl-10 pr-4 rounded-xl border border-gray-200 bg-gray-50 text-sm font-bold text-gray-800 focus:bg-white focus:border-emerald-500 focus:ring-3 focus:ring-emerald-500/10 outline-none transition"
                    >
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">📞</span>
                </div>
                {{-- Quick Autocomplete Suggestions Dropdown --}}
                <div id="customerSuggestions" class="hidden absolute top-full left-0 right-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg z-30 overflow-hidden divide-y divide-gray-100"></div>
            </div>

            {{-- Customer Name --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Customer Name (Optional)</label>
                <div class="relative">
                    <input 
                        type="text" 
                        id="custName" 
                        placeholder="Walk-in Customer" 
                        class="w-full h-11 pl-10 pr-4 rounded-xl border border-gray-200 bg-gray-50 text-sm font-bold text-gray-800 focus:bg-white focus:border-emerald-500 focus:ring-3 focus:ring-emerald-500/10 outline-none transition"
                    >
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">👤</span>
                </div>
            </div>

            {{-- Payment Method Selection --}}
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Payment Method</label>
                <div class="grid grid-cols-3 gap-2">
                    <button 
                        type="button"
                        onclick="setPaymentMethod('cash')" 
                        id="payCash" 
                        class="rounded-xl py-2.5 text-xs font-black transition flex flex-col items-center gap-1 bg-[#08784b] text-white border-2 border-[#08784b] shadow-xs"
                    >
                        <span class="text-lg">💵</span>
                        <span>CASH</span>
                    </button>
                    <button 
                        type="button"
                        onclick="setPaymentMethod('card')" 
                        id="payCard" 
                        class="rounded-xl py-2.5 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50"
                    >
                        <span class="text-lg">💳</span>
                        <span>CARD</span>
                    </button>
                    <button 
                        type="button"
                        onclick="setPaymentMethod('upi')" 
                        id="payUpi" 
                        class="rounded-xl py-2.5 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50"
                    >
                        <span class="text-lg">📱</span>
                        <span>UPI / QR</span>
                    </button>
                </div>
            </div>
            
            {{-- Cash Received, Interactive Numpad & Fast Tender Section --}}
            <div id="cashReceivedBlock" class="p-3.5 sm:p-4 rounded-2xl bg-gray-50 border border-gray-200 space-y-3">
                <div class="flex justify-between items-center">
                    <label class="text-xs font-black uppercase tracking-wider text-gray-600">Cash Received</label>
                    <span class="text-[11px] text-gray-400">Use quick pills or numpad</span>
                </div>

                {{-- Amount Input --}}
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-gray-400 text-lg">Rs.</span>
                    <input 
                        type="number" 
                        id="amtReceived" 
                        step="any"
                        oninput="calculateChange()" 
                        placeholder="0.00"
                        class="w-full pl-12 pr-4 py-2.5 rounded-xl border border-gray-300 bg-white text-xl font-black text-[#102d22] focus:border-emerald-500 focus:ring-3 focus:ring-emerald-500/10 outline-none transition"
                    >
                </div>

                {{-- Quick Notes Tender (Exact, 500, 1000, 2000, 5000) --}}
                <div class="flex flex-wrap gap-1.5 pt-0.5">
                    <button type="button" onclick="setCashAmount('exact')" class="flex-1 min-w-[55px] py-1.5 px-2 rounded-lg bg-emerald-700 text-white font-bold text-xs hover:bg-emerald-800 transition active:scale-95">
                        Exact
                    </button>
                    <button type="button" onclick="setCashAmount(500)" class="flex-1 min-w-[55px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition active:scale-95">
                        500
                    </button>
                    <button type="button" onclick="setCashAmount(1000)" class="flex-1 min-w-[55px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition active:scale-95">
                        1,000
                    </button>
                    <button type="button" onclick="setCashAmount(2000)" class="flex-1 min-w-[55px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition active:scale-95">
                        2,000
                    </button>
                    <button type="button" onclick="setCashAmount(5000)" class="flex-1 min-w-[55px] py-1.5 px-2 rounded-lg bg-white border border-gray-300 text-gray-700 font-bold text-xs hover:bg-gray-100 transition active:scale-95">
                        5,000
                    </button>
                </div>

                {{-- Interactive Touch Numpad (Toggleable / Available for Touch POS) --}}
                <div class="pt-2 border-t border-gray-200">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Touch Numpad</span>
                        <div class="flex gap-1">
                            <button type="button" onclick="addNumpadTender(100)" class="px-2 py-0.5 rounded bg-gray-200 hover:bg-gray-300 text-[10px] font-bold text-gray-700">+100</button>
                            <button type="button" onclick="addNumpadTender(500)" class="px-2 py-0.5 rounded bg-gray-200 hover:bg-gray-300 text-[10px] font-bold text-gray-700">+500</button>
                            <button type="button" onclick="addNumpadTender(1000)" class="px-2 py-0.5 rounded bg-gray-200 hover:bg-gray-300 text-[10px] font-bold text-gray-700">+1000</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-4 gap-1.5 text-center">
                        <button type="button" onclick="pressNumpad('1')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">1</button>
                        <button type="button" onclick="pressNumpad('2')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">2</button>
                        <button type="button" onclick="pressNumpad('3')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">3</button>
                        <button type="button" onclick="pressNumpad('backspace')" class="py-2 rounded-lg bg-red-50 text-red-600 border border-red-200 font-bold text-sm hover:bg-red-100 active:bg-red-200">⌫</button>

                        <button type="button" onclick="pressNumpad('4')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">4</button>
                        <button type="button" onclick="pressNumpad('5')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">5</button>
                        <button type="button" onclick="pressNumpad('6')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">6</button>
                        <button type="button" onclick="pressNumpad('clear')" class="py-2 rounded-lg bg-gray-100 text-gray-600 border border-gray-200 font-bold text-xs hover:bg-gray-200">Clear</button>

                        <button type="button" onclick="pressNumpad('7')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">7</button>
                        <button type="button" onclick="pressNumpad('8')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">8</button>
                        <button type="button" onclick="pressNumpad('9')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">9</button>
                        <button type="button" onclick="pressNumpad('00')" class="py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">00</button>

                        <button type="button" onclick="pressNumpad('0')" class="col-span-2 py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">0</button>
                        <button type="button" onclick="pressNumpad('.')" class="col-span-2 py-2 rounded-lg bg-white border border-gray-200 font-black text-sm hover:bg-gray-100 active:bg-gray-200">.</button>
                    </div>
                </div>

                {{-- Change Calculation Banner --}}
                <div class="pt-2 border-t border-gray-200 flex justify-between items-center text-sm font-bold">
                    <span class="text-gray-600">Change to Return:</span>
                    <strong id="changeAmount" class="text-base text-gray-500">Rs. 0.00</strong>
                </div>
            </div>
        </div>
        
        {{-- Modal Footer --}}
        <div class="p-3.5 sm:p-4 bg-gray-50 border-t border-gray-200 shrink-0">
            <button 
                type="button"
                onclick="submitOrder()" 
                id="confirmOrderBtn" 
                class="w-full rounded-2xl bg-[#08784b] hover:bg-[#06633e] py-3.5 text-sm font-black text-white transition active:scale-[0.99] shadow-lg shadow-emerald-800/20 flex items-center justify-center gap-2"
            >
                <span>CONFIRM ORDER &amp; PRINT BILL</span>
                <span class="bg-black/20 px-2 py-0.5 rounded text-xs font-mono">↵</span>
            </button>
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 2: ORDER SUCCESS & INSTANT WHATSAPP MODAL
======================================================== --}}
<div id="orderSuccessModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 p-6 text-center" id="orderSuccessModalContent">
        <div class="mx-auto w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl font-black mb-3 shadow-inner">
            ✓
        </div>
        <h2 class="text-xl font-black text-[#092c20]">Order Completed!</h2>
        <p class="text-xs font-mono font-bold text-gray-400 mt-1" id="successReceiptNo">ORD-XXXX</p>
        
        <div class="my-4 p-3.5 rounded-2xl bg-emerald-50/70 border border-emerald-100 flex justify-between items-center">
            <span class="text-xs font-bold text-gray-600">Total Collected</span>
            <span class="text-xl font-black text-[#08784b]" id="successTotal">Rs. 0</span>
        </div>

        <div class="space-y-2">
            <a 
                id="btnSendWhatsApp" 
                href="#" 
                target="_blank" 
                class="w-full rounded-xl bg-[#25D366] hover:bg-[#20bd5a] text-white py-3 px-4 font-black text-sm flex items-center justify-center gap-2 transition shadow-md shadow-emerald-600/20 active:scale-[0.99]"
            >
                <span class="text-lg">📱</span>
                <span id="whatsAppBtnLabel">Send WhatsApp Receipt</span>
            </a>

            <button 
                type="button"
                id="btnPrintReceipt" 
                onclick="printSuccessReceipt()" 
                class="w-full rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 py-2.5 px-4 font-bold text-xs flex items-center justify-center gap-2 transition"
            >
                <span>🖨️</span>
                <span>Re-Print Thermal Bill</span>
            </button>

            <button 
                type="button"
                onclick="closeSuccessModal()" 
                class="w-full rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 px-4 font-bold text-xs transition"
            >
                Next Order (Esc)
            </button>
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 3: ADD CUSTOM / OPEN ITEM MODAL (F8)
======================================================== --}}
<div id="customItemModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-md mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 flex flex-col" id="customItemModalContent">
        <div class="p-4 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-2">
                <span class="text-xl">✨</span>
                <h3 class="text-base font-black">Add Custom / Open Item</h3>
            </div>
            <button type="button" onclick="closeCustomItemModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <form onsubmit="addCustomItemToCart(event)" class="p-5 space-y-3.5">
            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Item Name *</label>
                <input 
                    type="text" 
                    id="customItemName" 
                    placeholder="e.g. Special Falooda / Extra Scoop" 
                    required 
                    autocomplete="off"
                    class="w-full h-10 px-3.5 rounded-xl border border-gray-300 text-sm font-bold text-gray-800 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                >
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Price (Rs.) *</label>
                    <input 
                        type="number" 
                        id="customItemPrice" 
                        min="1" 
                        step="any" 
                        placeholder="0.00" 
                        required 
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-300 text-sm font-black text-[#08784b] focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 outline-none transition"
                    >
                </div>
                <div>
                    <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Quantity</label>
                    <input 
                        type="number" 
                        id="customItemQty" 
                        min="1" 
                        value="1" 
                        required 
                        class="w-full h-10 px-3.5 rounded-xl border border-gray-300 text-sm font-bold text-gray-800 text-center focus:border-emerald-500 outline-none transition"
                    >
                </div>
            </div>

            <div>
                <label class="block text-xs font-black uppercase tracking-wider text-gray-600 mb-1">Item Note (Optional)</label>
                <input 
                    type="text" 
                    id="customItemNotes" 
                    placeholder="e.g. Less sugar, extra ice" 
                    class="w-full h-10 px-3.5 rounded-xl border border-gray-300 text-xs font-semibold text-gray-700 focus:border-emerald-500 outline-none transition"
                >
            </div>

            <div class="pt-2">
                <button 
                    type="submit" 
                    class="w-full rounded-xl bg-[#08784b] hover:bg-[#06633e] text-white py-3 text-sm font-black shadow-md shadow-emerald-700/20 transition active:scale-[0.99]"
                >
                    Add to Active Order
                </button>
            </div>
        </form>
    </div>
</div>


{{-- ========================================================
     MODAL 4: ITEM NOTE / CUSTOMIZATION POPUP
======================================================== --}}
<div id="itemNoteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 p-5 space-y-3.5" id="itemNoteModalContent">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-black text-gray-800 flex items-center gap-1.5">
                <span>📝</span>
                <span>Item Instructions: <span id="noteItemName" class="text-emerald-700"></span></span>
            </h3>
            <button type="button" onclick="closeItemNoteModal()" class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center text-xs">✕</button>
        </div>

        <input 
            type="text" 
            id="itemNoteInput" 
            placeholder="e.g. Less Sugar, No Ice..." 
            class="w-full h-10 px-3.5 rounded-xl border border-gray-300 text-xs font-bold text-gray-800 focus:border-emerald-500 outline-none"
        >

        {{-- Quick Chip Presets --}}
        <div>
            <span class="block text-[10px] font-bold text-gray-400 mb-1.5">QUICK PRESETS</span>
            <div class="flex flex-wrap gap-1.5">
                <button type="button" onclick="appendItemNote('Less Sugar')" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700 transition">Less Sugar</button>
                <button type="button" onclick="appendItemNote('No Ice')" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700 transition">No Ice</button>
                <button type="button" onclick="appendItemNote('Extra Ice')" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700 transition">Extra Ice</button>
                <button type="button" onclick="appendItemNote('Takeaway Cup')" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700 transition">Takeaway Cup</button>
                <button type="button" onclick="appendItemNote('Extra Sweet')" class="px-2.5 py-1 rounded-lg bg-gray-100 hover:bg-gray-200 text-[11px] font-semibold text-gray-700 transition">Extra Sweet</button>
            </div>
        </div>

        <div class="flex gap-2 pt-2">
            <button type="button" onclick="clearItemNote()" class="flex-1 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-600 text-xs font-bold py-2.5 transition">Clear</button>
            <button type="button" onclick="saveItemNote()" class="flex-2 rounded-xl bg-[#08784b] hover:bg-[#06633e] text-white text-xs font-black py-2.5 shadow-sm transition">Save Note</button>
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 5: ORDER GENERAL NOTE
======================================================== --}}
<div id="orderNoteModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 p-5 space-y-3.5" id="orderNoteModalContent">
        <div class="flex justify-between items-center">
            <h3 class="text-sm font-black text-gray-800 flex items-center gap-1.5">
                <span>📝</span>
                <span>Order Note</span>
            </h3>
            <button type="button" onclick="closeOrderNotesModal()" class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center text-xs">✕</button>
        </div>
        <textarea 
            id="orderGeneralNoteInput" 
            rows="3" 
            placeholder="Special instructions for the whole order..."
            class="w-full p-3 rounded-xl border border-gray-300 text-xs font-bold text-gray-800 focus:border-emerald-500 outline-none"
        ></textarea>
        <div class="flex gap-2">
            <button type="button" onclick="saveOrderNote('')" class="flex-1 rounded-xl bg-gray-100 text-gray-600 text-xs font-bold py-2.5">Clear</button>
            <button type="button" onclick="saveOrderNote(document.getElementById('orderGeneralNoteInput').value)" class="flex-2 rounded-xl bg-[#08784b] text-white text-xs font-black py-2.5">Save Note</button>
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 6: HELD / PARKED ORDERS DRAWER (F1 / F3)
======================================================== --}}
<div id="heldOrdersModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 flex flex-col max-h-[85vh]" id="heldOrdersModalContent">
        <div class="p-4 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-2">
                <span class="text-xl">⏸️</span>
                <div>
                    <h3 class="text-base font-black">Parked Orders</h3>
                    <p class="text-[11px] text-emerald-300">Resume any paused order in 1 tap</p>
                </div>
            </div>
            <button type="button" onclick="toggleHeldOrdersModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <div class="p-4 overflow-y-auto space-y-2.5 flex-1 hide-scrollbar" id="heldOrdersList">
            {{-- Injected dynamically --}}
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 7: TODAY'S RECENT ORDERS (F6)
======================================================== --}}
<div id="recentOrdersModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-2xl mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 flex flex-col max-h-[88vh]" id="recentOrdersModalContent">
        <div class="p-4 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-2">
                <span class="text-xl">🕒</span>
                <div>
                    <h3 class="text-base font-black">Today's Recent Orders</h3>
                    <p class="text-[11px] text-emerald-300">Quick re-print thermal bills or share WhatsApp</p>
                </div>
            </div>
            <button type="button" onclick="toggleRecentOrdersModal()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <div class="p-4 overflow-y-auto space-y-2.5 flex-1 hide-scrollbar" id="recentOrdersList">
            @forelse($recentOrders as $ro)
            <div class="p-3 rounded-2xl bg-gray-50 hover:bg-gray-100/80 border border-gray-200/80 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 transition">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-black text-xs text-gray-900">{{ $ro->receipt_number }}</span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black uppercase {{ $ro->order_type === 'takeaway' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ $ro->order_type === 'takeaway' ? 'Takeaway' : 'Dine In' }}
                        </span>
                        @if($ro->table_no)
                            <span class="text-[10px] font-bold text-gray-500">· {{ $ro->table_no }}</span>
                        @endif
                    </div>
                    <div class="text-[11px] text-gray-500 mt-0.5">
                        <span>{{ $ro->created_at->format('h:i A') }}</span> · 
                        <span>{{ count($ro->items) }} items</span> · 
                        <span class="font-bold text-gray-700">{{ $ro->customer?->phone ?? 'Walk-in' }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-3 shrink-0">
                    <strong class="text-sm font-black text-[#08784b]">Rs. {{ number_format($ro->total, 0) }}</strong>
                    <div class="flex items-center gap-1.5">
                        <button 
                            type="button" 
                            onclick="window.open('/admin/pos/receipt/{{ $ro->id }}', 'Receipt', 'width=400,height=600')" 
                            class="px-2.5 py-1.5 rounded-lg border border-gray-200 bg-white hover:bg-gray-100 text-xs font-bold text-gray-700 transition flex items-center gap-1"
                            title="Re-Print Thermal Bill"
                        >
                            <span>🖨️</span>
                            <span class="hidden sm:inline">Print</span>
                        </button>
                        <a 
                            href="{{ $ro->getWhatsAppUrl() }}" 
                            target="_blank" 
                            class="px-2.5 py-1.5 rounded-lg bg-[#25D366] hover:bg-[#20bd5a] text-white text-xs font-bold transition flex items-center gap-1 shadow-2xs"
                            title="Share on WhatsApp"
                        >
                            <span>📱</span>
                            <span class="hidden sm:inline">WhatsApp</span>
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-10 text-gray-400">
                <span class="text-4xl block mb-2">🧾</span>
                <p class="text-xs font-bold">No completed orders today yet.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 8: DAILY SALES REGISTER SUMMARY (F9)
======================================================== --}}
<div id="dailySummaryModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-md mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 flex flex-col" id="dailySummaryModalContent">
        <div class="p-4 bg-[#092c20] text-white flex justify-between items-center shrink-0">
            <div class="flex items-center gap-2">
                <span class="text-xl">📊</span>
                <div>
                    <h3 class="text-base font-black">Daily Sales Register</h3>
                    <p class="text-[11px] text-emerald-300" id="summaryModalDate">{{ now()->format('d M Y') }}</p>
                </div>
            </div>
            <button type="button" onclick="closeDailySummary()" class="w-7 h-7 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition">✕</button>
        </div>
        
        <div class="p-5 space-y-4 overflow-y-auto hide-scrollbar">
            {{-- Big Total Banner --}}
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200/80 text-center">
                <span class="text-[10px] font-black uppercase tracking-widest text-emerald-800">Total Revenue Today</span>
                <h2 class="text-3xl font-black text-[#08784b] mt-0.5">Rs. <span id="summaryTotalSales">{{ number_format($todaySummary['total_sales'] ?? 0, 0) }}</span></h2>
                <div class="flex justify-center gap-3 text-xs text-gray-600 mt-1">
                    <span><strong id="summaryTotalOrders">{{ $todaySummary['total_orders'] ?? 0 }}</strong> Bills</span> · 
                    <span><strong id="summaryTotalItems">{{ $todaySummary['total_items_sold'] ?? 0 }}</strong> Items</span>
                </div>
            </div>

            {{-- Breakdown by Payment Method --}}
            <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-200 space-y-2 text-xs">
                <div class="flex justify-between items-center py-1 border-b border-gray-200">
                    <span class="font-bold text-gray-600 flex items-center gap-1.5"><span>💵</span> Cash Sales:</span>
                    <strong class="text-gray-900 font-black">Rs. <span id="summaryCashSales">{{ number_format($todaySummary['cash_sales'] ?? 0, 2) }}</span></strong>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-200">
                    <span class="font-bold text-gray-600 flex items-center gap-1.5"><span>💳</span> Card Sales:</span>
                    <strong class="text-gray-900 font-black">Rs. <span id="summaryCardSales">{{ number_format($todaySummary['card_sales'] ?? 0, 2) }}</span></strong>
                </div>
                <div class="flex justify-between items-center py-1 border-b border-gray-200">
                    <span class="font-bold text-gray-600 flex items-center gap-1.5"><span>📱</span> UPI / QR Sales:</span>
                    <strong class="text-gray-900 font-black">Rs. <span id="summaryUpiSales">{{ number_format($todaySummary['upi_sales'] ?? 0, 2) }}</span></strong>
                </div>
                <div class="flex justify-between items-center py-1 text-amber-700">
                    <span class="font-bold flex items-center gap-1.5"><span>🏷️</span> Total Discounts Given:</span>
                    <strong class="font-black">Rs. <span id="summaryDiscount">{{ number_format($todaySummary['total_discount'] ?? 0, 2) }}</span></strong>
                </div>
            </div>

            {{-- Dine-In vs Takeaway --}}
            <div class="grid grid-cols-2 gap-2 text-center text-xs">
                <div class="p-2.5 rounded-xl bg-gray-100 border border-gray-200">
                    <span class="text-gray-500 block text-[10px] font-bold">Dine In Orders</span>
                    <strong class="text-base font-black text-gray-800" id="summaryDineInCount">{{ $todaySummary['dine_in_count'] ?? 0 }}</strong>
                </div>
                <div class="p-2.5 rounded-xl bg-gray-100 border border-gray-200">
                    <span class="text-gray-500 block text-[10px] font-bold">Takeaway Orders</span>
                    <strong class="text-base font-black text-gray-800" id="summaryTakeawayCount">{{ $todaySummary['takeaway_count'] ?? 0 }}</strong>
                </div>
            </div>

            <button 
                type="button" 
                onclick="window.print()" 
                class="w-full rounded-xl bg-[#092c20] hover:bg-[#071d16] text-white py-3 text-xs font-black flex items-center justify-center gap-2 transition shadow-md"
            >
                <span>🖨️</span>
                <span>Print Shift Summary Slip</span>
            </button>
        </div>
    </div>
</div>


{{-- ========================================================
     MODAL 9: KEYBOARD SHORTCUTS CHEAT SHEET
======================================================== --}}
<div id="shortcutsModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-xs opacity-0 pointer-events-none transition-opacity duration-200 p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm mx-auto overflow-hidden shadow-2xl transform scale-95 transition-transform duration-200 p-5 space-y-3" id="shortcutsModalContent">
        <div class="flex justify-between items-center pb-2 border-b border-gray-100">
            <h3 class="text-sm font-black text-[#092c20] flex items-center gap-2">
                <span>⌨️</span>
                <span>POS Keyboard Shortcuts</span>
            </h3>
            <button type="button" onclick="toggleShortcutsModal()" class="w-6 h-6 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center text-xs">✕</button>
        </div>
        <div class="space-y-1.5 text-xs">
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">F1 / Park Order</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F1</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Focus Search Bar</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F2</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">View Parked Orders</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F3</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Proceed to Payment</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F4</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Today's Recent Bills</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F6</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">+ Custom Open Item</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F8</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Daily Register Summary</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">F9</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Confirm Order in Checkout</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">Enter ↵</span>
            </div>
            <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 font-bold">
                <span class="text-gray-600">Close Active Popup</span>
                <span class="bg-emerald-100 text-emerald-800 px-2 py-0.5 rounded font-mono font-black">Esc</span>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ==========================================
    // 5ROSE ADVANCED POS ENGINE v2.0
    // ==========================================
    let cart = [];
    let heldOrders = JSON.parse(localStorage.getItem('5rose_pos_held_orders') || '[]');
    let orderType = 'dine_in';
    const TAKEAWAY_CHARGE = 50;
    let discountAmount = 0;
    let discountPercent = 0;
    let paymentMethod = 'cash';
    let currentOrderGeneralNote = '';
    let currentEditingItemIndex = null;
    let isAudioMuted = localStorage.getItem('5rose_pos_mute') === 'true';
    let currentSuccessOrderId = null;
    let viewMode = 'grid';

    // Modal state trackers
    let activeModal = null; // 'checkout' | 'success' | 'customItem' | 'itemNote' | 'orderNote' | 'held' | 'recent' | 'dailySummary' | 'shortcuts'

    // DOM Elements
    const searchInput = document.getElementById('productSearch');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    const catBtns = document.querySelectorAll('.cat-btn');
    const noResults = document.getElementById('noResults');
    const cartItemsDiv = document.getElementById('cartItems');
    const emptyCartDiv = document.getElementById('emptyCart');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const clearCartBtn = document.getElementById('clearCartBtn');
    const holdCartBtn = document.getElementById('holdCartBtn');
    const mobileCartBadge = document.getElementById('mobileCartBadge');
    const cartHeaderBadge = document.getElementById('cartHeaderBadge');
    const visibleCountEl = document.getElementById('visibleProductsCount');
    const heldBadge = document.getElementById('heldBadge');

    // Update audio icon on load
    updateAudioIcon();
    updateHeldOrdersBadge();

    // --- AUDIO SOUND SYSTEM (Pleasant Web Audio Chimes) ---
    function playSound(type = 'add') {
        if (isAudioMuted) return;
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
            } else if (type === 'delete') {
                osc.frequency.setValueAtTime(440, ctx.currentTime);
                osc.frequency.exponentialRampToValueAtTime(220, ctx.currentTime + 0.08);
                gain.gain.setValueAtTime(0.1, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.08);
                osc.start();
                osc.stop(ctx.currentTime + 0.08);
            } else if (type === 'hold') {
                osc.frequency.setValueAtTime(440, ctx.currentTime);
                osc.frequency.setValueAtTime(554.37, ctx.currentTime + 0.06);
                gain.gain.setValueAtTime(0.1, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.12);
                osc.start();
                osc.stop(ctx.currentTime + 0.12);
            } else if (type === 'success') {
                osc.frequency.setValueAtTime(523.25, ctx.currentTime); // C5
                osc.frequency.setValueAtTime(659.25, ctx.currentTime + 0.07); // E5
                osc.frequency.setValueAtTime(783.99, ctx.currentTime + 0.14); // G5
                gain.gain.setValueAtTime(0.15, ctx.currentTime);
                gain.gain.exponentialRampToValueAtTime(0.01, ctx.currentTime + 0.25);
                osc.start();
                osc.stop(ctx.currentTime + 0.25);
            }
        } catch (e) {
            // Audio context not allowed or unsupported
        }
    }

    function toggleAudioMute() {
        isAudioMuted = !isAudioMuted;
        localStorage.setItem('5rose_pos_mute', isAudioMuted);
        updateAudioIcon();
    }

    function updateAudioIcon() {
        const iconEl = document.getElementById('audioIcon');
        if (iconEl) {
            iconEl.innerText = isAudioMuted ? '🔇' : '🔊';
        }
    }

    // --- VIEW MODE TOGGLE (Grid vs Compact List) ---
    function setViewMode(mode) {
        viewMode = mode;
        const grid = document.getElementById('productGrid');
        const list = document.getElementById('productList');
        const gridBtn = document.getElementById('viewGridBtn');
        const listBtn = document.getElementById('viewListBtn');

        if (mode === 'grid') {
            grid.classList.remove('hidden');
            list.classList.add('hidden');
            gridBtn.className = "h-full px-2.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs flex items-center gap-1";
            listBtn.className = "h-full px-2.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20] flex items-center gap-1";
        } else {
            grid.classList.add('hidden');
            list.classList.remove('hidden');
            listBtn.className = "h-full px-2.5 rounded-lg text-xs font-bold transition bg-white text-[#092c20] shadow-xs flex items-center gap-1";
            gridBtn.className = "h-full px-2.5 rounded-lg text-xs font-bold transition text-gray-500 hover:text-[#092c20] flex items-center gap-1";
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
        let lastVisibleCard = null;

        cards.forEach(card => {
            const name = card.dataset.name.toLowerCase();
            const cat = card.dataset.cat;
            
            const matchesSearch = name.includes(query);
            const matchesCat = currentCategory === 'all' || cat === currentCategory;

            if (matchesSearch && matchesCat) {
                card.style.display = 'flex';
                visibleCount++;
                lastVisibleCard = card;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        if (visibleCountEl) visibleCountEl.innerText = visibleCount;
        return { visibleCount, lastVisibleCard };
    }

    function clearSearch() {
        searchInput.value = '';
        searchInput.focus();
        filterProducts();
    }

    searchInput.addEventListener('input', filterProducts);

    // Fast Enter to add sole match
    searchInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            const { visibleCount, lastVisibleCard } = filterProducts();
            if (visibleCount === 1 && lastVisibleCard) {
                lastVisibleCard.click();
                clearSearch();
            }
        }
    });

    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            catBtns.forEach(b => {
                b.className = "cat-btn whitespace-nowrap px-3.5 py-1.5 rounded-xl border border-gray-200 bg-white text-gray-700 text-xs font-bold transition hover:bg-gray-50 hover:border-gray-300 flex items-center gap-1.5 shadow-2xs";
            });
            btn.className = "cat-btn active whitespace-nowrap px-3.5 py-1.5 rounded-xl text-xs font-black tracking-wide transition flex items-center gap-1.5 bg-[#08784b] text-white shadow-xs";

            currentCategory = btn.dataset.cat;
            filterProducts();
        });
    });

    // --- CART CORE ENGINE ---
    function addToCart(id, name, price, img, notes = '') {
        const existingItem = cart.find(item => item.id === id && (item.notes || '') === notes);
        if (existingItem) {
            existingItem.qty++;
        } else {
            cart.push({ id, name, price: parseFloat(price), img, qty: 1, notes: notes });
        }
        playSound('add');
        renderCart();
    }

    function updateQty(id, change) {
        const itemIndex = cart.findIndex(item => item.id === id);
        if (itemIndex > -1) {
            cart[itemIndex].qty += change;
            if (cart[itemIndex].qty <= 0) {
                cart.splice(itemIndex, 1);
                playSound('delete');
            } else {
                playSound('add');
            }
            renderCart();
        }
    }

    function removeItemByIndex(index) {
        if (index >= 0 && index < cart.length) {
            cart.splice(index, 1);
            playSound('delete');
            renderCart();
        }
    }

    function clearCart() {
        if (cart.length > 0 && confirm('Clear active order?')) {
            cart = [];
            discountAmount = 0;
            discountPercent = 0;
            currentOrderGeneralNote = '';
            document.getElementById('orderTableNo').value = '';
            document.getElementById('orderNoteStatus').innerText = 'Note';
            playSound('delete');
            renderCart();
        }
    }

    function setOrderType(type) {
        orderType = type;
        const btnDine = document.getElementById('btnDineIn');
        const btnTake = document.getElementById('btnTakeaway');
        const takeawayRow = document.getElementById('takeawayChargeRow');
        
        if (type === 'dine_in') {
            btnDine.className = "flex-1 rounded-lg py-1.5 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5";
            btnTake.className = "flex-1 rounded-lg py-1.5 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5";
            takeawayRow.classList.add('hidden');
        } else {
            btnTake.className = "flex-1 rounded-lg py-1.5 text-xs font-black transition bg-[#092c20] text-white shadow-xs flex items-center justify-center gap-1.5";
            btnDine.className = "flex-1 rounded-lg py-1.5 text-xs font-black transition text-gray-500 hover:text-[#092c20] flex items-center justify-center gap-1.5";
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
                b.className = "disc-btn active px-2 py-0.5 rounded-md text-[11px] font-bold bg-[#092c20] text-white";
            } else {
                b.className = "disc-btn px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200";
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
                    b.className = "disc-btn px-2 py-0.5 rounded-md text-[11px] font-bold bg-gray-100 text-gray-600 hover:bg-gray-200";
                });
                renderTotals();
            }
        }
    }

    // --- RENDER CART & UI BINDINGS ---
    function renderCart() {
        const hasItems = cart.length > 0;
        emptyCartDiv.style.display = hasItems ? 'none' : 'flex';
        checkoutBtn.disabled = !hasItems;
        clearCartBtn.disabled = !hasItems;
        holdCartBtn.disabled = !hasItems;
        clearCartBtn.style.opacity = hasItems ? '1' : '0.5';
        clearCartBtn.style.cursor = hasItems ? 'pointer' : 'not-allowed';
        holdCartBtn.style.opacity = hasItems ? '1' : '0.5';
        holdCartBtn.style.cursor = hasItems ? 'pointer' : 'not-allowed';
        
        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        mobileCartBadge.innerText = totalItems;
        mobileCartBadge.style.opacity = totalItems > 0 ? '1' : '0';
        cartHeaderBadge.innerText = totalItems + (totalItems === 1 ? ' item' : ' items');

        // Clear cart DOM and rebuild
        cartItemsDiv.innerHTML = '';
        cartItemsDiv.appendChild(emptyCartDiv);

        cart.forEach((item, index) => {
            const el = document.createElement('div');
            el.className = 'flex flex-col p-2.5 rounded-2xl bg-gray-50/90 hover:bg-gray-100/80 border border-gray-100 transition space-y-1.5';
            
            const isCustom = !item.id || isNaN(item.id);
            const notesDisplay = item.notes ? `<div class="text-[10px] text-amber-700 italic flex items-center gap-1 font-semibold"><span>↳</span> ${item.notes}</div>` : '';

            el.innerHTML = `
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2.5 min-w-0 flex-1 pr-2">
                        <img 
                            src="${item.img || '{{ asset('images/5rose/logo.png') }}'}" 
                            class="w-9 h-9 rounded-xl object-cover shrink-0 border border-gray-200 bg-white" 
                            onerror="this.src='{{ asset('images/5rose/logo.png') }}';"
                        >
                        <div class="min-w-0">
                            <h4 class="text-xs font-black text-[#102d22] leading-tight truncate">
                                ${isCustom ? '<span class="text-emerald-700 font-bold">[Custom]</span> ' : ''}${item.name}
                            </h4>
                            <span class="text-[11px] text-gray-400 font-semibold">Rs. ${item.price.toLocaleString()}</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 shrink-0">
                        <div class="flex items-center rounded-xl border border-gray-200 bg-white shadow-2xs">
                            <button type="button" onclick="changeCartItemQty(${index}, -1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-red-600 font-bold text-xs transition active:scale-90">-</button>
                            <span class="w-5 text-center text-xs font-black text-[#102d22]">${item.qty}</span>
                            <button type="button" onclick="changeCartItemQty(${index}, 1)" class="w-6 h-6 flex items-center justify-center text-gray-500 hover:text-emerald-700 font-bold text-xs transition active:scale-90">+</button>
                        </div>
                        
                        <strong class="w-14 text-right text-xs font-black text-[#08784b]">
                            ${(item.price * item.qty).toLocaleString()}
                        </strong>

                        <button type="button" onclick="removeItemByIndex(${index})" class="text-gray-300 hover:text-red-500 text-xs p-1 transition" title="Remove item">
                            ✕
                        </button>
                    </div>
                </div>
                
                <div class="flex items-center justify-between pt-1 border-t border-gray-200/50">
                    ${notesDisplay || '<span class="text-[10px] text-gray-400">Standard prep</span>'}
                    <button type="button" onclick="openItemNoteModal(${index})" class="text-[10px] text-emerald-800 bg-emerald-50 hover:bg-emerald-100 font-bold px-1.5 py-0.5 rounded transition">
                        ${item.notes ? 'Edit Note ✏️' : '+ Add Note'}
                    </button>
                </div>
            `;
            cartItemsDiv.appendChild(el);
        });

        updateProductCardBadges();
        renderTotals();
    }

    function changeCartItemQty(index, change) {
        if (cart[index]) {
            cart[index].qty += change;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
                playSound('delete');
            } else {
                playSound('add');
            }
            renderCart();
        }
    }

    function updateProductCardBadges() {
        document.querySelectorAll('[id^="cardBadge-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('[id^="listBadge-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('[class*="card-dec-btn-"]').forEach(b => b.classList.add('hidden'));
        document.querySelectorAll('.product-card').forEach(c => {
            c.classList.remove('ring-2', 'ring-emerald-500', 'bg-emerald-50/20');
        });

        // Group quantities by product ID
        const qtyById = {};
        cart.forEach(item => {
            if (item.id && !isNaN(item.id)) {
                qtyById[item.id] = (qtyById[item.id] || 0) + item.qty;
            }
        });

        Object.keys(qtyById).forEach(id => {
            const qty = qtyById[id];
            const badge = document.getElementById(`cardBadge-${id}`);
            const card = document.getElementById(`product-card-${id}`);
            const decBtn = document.querySelector(`.card-dec-btn-${id}`);
            if (badge) {
                badge.classList.remove('hidden');
                badge.querySelector('.card-qty').innerText = qty;
            }
            if (card) {
                card.classList.add('ring-2', 'ring-emerald-500', 'bg-emerald-50/20');
            }
            if (decBtn) {
                decBtn.classList.remove('hidden');
            }

            const listBadge = document.getElementById(`listBadge-${id}`);
            const listCard = document.getElementById(`product-list-${id}`);
            if (listBadge) {
                listBadge.classList.remove('hidden');
                listBadge.querySelector('.card-qty').innerText = qty;
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

    // --- PARK / HOLD ORDERS (F1 / F3) ---
    function holdCurrentOrder() {
        if (cart.length === 0) return;
        
        const tableNo = document.getElementById('orderTableNo').value.trim();
        const totals = renderTotals();
        
        const heldOrder = {
            id: 'HOLD_' + Date.now(),
            cart: JSON.parse(JSON.stringify(cart)),
            orderType: orderType,
            tableNo: tableNo,
            discountAmount: discountAmount,
            discountPercent: discountPercent,
            generalNote: currentOrderGeneralNote,
            total: totals.total,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }),
            date: new Date().toLocaleDateString()
        };

        heldOrders.push(heldOrder);
        localStorage.setItem('5rose_pos_held_orders', JSON.stringify(heldOrders));
        
        playSound('hold');
        
        // Reset active cart
        cart = [];
        discountAmount = 0;
        discountPercent = 0;
        currentOrderGeneralNote = '';
        document.getElementById('orderTableNo').value = '';
        document.getElementById('orderNoteStatus').innerText = 'Note';
        renderCart();
        updateHeldOrdersBadge();
    }

    function updateHeldOrdersBadge() {
        if (heldOrders.length > 0) {
            heldBadge.classList.remove('hidden');
            heldBadge.innerText = heldOrders.length;
        } else {
            heldBadge.classList.add('hidden');
        }
    }

    function toggleHeldOrdersModal() {
        const modal = document.getElementById('heldOrdersModal');
        const content = document.getElementById('heldOrdersModalContent');
        
        if (activeModal === 'held') {
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.add('scale-95');
            activeModal = null;
        } else {
            renderHeldOrdersList();
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            activeModal = 'held';
        }
    }

    function renderHeldOrdersList() {
        const listDiv = document.getElementById('heldOrdersList');
        if (heldOrders.length === 0) {
            listDiv.innerHTML = `
                <div class="text-center py-10 text-gray-400">
                    <span class="text-4xl block mb-2">⏸️</span>
                    <p class="text-xs font-bold">No parked orders.</p>
                    <p class="text-[11px] text-gray-400 mt-0.5">Use "Hold (F1)" to park a customer's order and serve next.</p>
                </div>
            `;
            return;
        }

        listDiv.innerHTML = '';
        heldOrders.forEach((ho, index) => {
            const el = document.createElement('div');
            el.className = 'p-3 rounded-2xl bg-gray-50 border border-gray-200 flex items-center justify-between gap-3 hover:bg-gray-100/70 transition';
            const itemsCount = ho.cart.reduce((sum, item) => sum + item.qty, 0);
            
            el.innerHTML = `
                <div>
                    <div class="flex items-center gap-2">
                        <strong class="text-xs text-gray-900">${ho.tableNo ? 'Table ' + ho.tableNo : 'Order #' + (index + 1)}</strong>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold ${ho.orderType === 'takeaway' ? 'bg-amber-100 text-amber-800' : 'bg-blue-100 text-blue-800'}">
                            ${ho.orderType === 'takeaway' ? 'Takeaway' : 'Dine In'}
                        </span>
                        <span class="text-[10px] text-gray-400">⏱️ ${ho.time}</span>
                    </div>
                    <p class="text-[11px] text-gray-500 mt-0.5">${itemsCount} items · Total: <strong class="text-[#08784b]">Rs. ${ho.total.toLocaleString()}</strong></p>
                </div>

                <div class="flex items-center gap-1.5">
                    <button type="button" onclick="recallHeldOrder(${index})" class="px-3 py-1.5 rounded-xl bg-[#08784b] hover:bg-[#06633e] text-white text-xs font-bold transition active:scale-95 shadow-2xs">
                        Resume ↵
                    </button>
                    <button type="button" onclick="deleteHeldOrder(${index})" class="w-8 h-8 rounded-xl bg-gray-200 hover:bg-red-100 text-gray-600 hover:text-red-600 text-xs font-bold transition flex items-center justify-center">
                        ✕
                    </button>
                </div>
            `;
            listDiv.appendChild(el);
        });
    }

    function recallHeldOrder(index) {
        if (cart.length > 0 && !confirm('Active order has items. Replace with parked order?')) {
            return;
        }
        const ho = heldOrders[index];
        cart = JSON.parse(JSON.stringify(ho.cart));
        orderType = ho.orderType || 'dine_in';
        discountAmount = ho.discountAmount || 0;
        discountPercent = ho.discountPercent || 0;
        currentOrderGeneralNote = ho.generalNote || '';
        document.getElementById('orderTableNo').value = ho.tableNo || '';
        document.getElementById('orderNoteStatus').innerText = currentOrderGeneralNote ? 'Note ✓' : 'Note';

        heldOrders.splice(index, 1);
        localStorage.setItem('5rose_pos_held_orders', JSON.stringify(heldOrders));
        updateHeldOrdersBadge();
        toggleHeldOrdersModal();
        setOrderType(orderType);
        renderCart();
        playSound('add');
    }

    function deleteHeldOrder(index) {
        if (confirm('Discard this parked order?')) {
            heldOrders.splice(index, 1);
            localStorage.setItem('5rose_pos_held_orders', JSON.stringify(heldOrders));
            updateHeldOrdersBadge();
            renderHeldOrdersList();
        }
    }

    // --- CUSTOM / OPEN ITEM MODAL (F8) ---
    function openCustomItemModal() {
        const modal = document.getElementById('customItemModal');
        const content = document.getElementById('customItemModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        activeModal = 'customItem';
        document.getElementById('customItemName').value = '';
        document.getElementById('customItemPrice').value = '';
        document.getElementById('customItemQty').value = '1';
        document.getElementById('customItemNotes').value = '';
        setTimeout(() => document.getElementById('customItemName').focus(), 150);
    }

    function closeCustomItemModal() {
        const modal = document.getElementById('customItemModal');
        const content = document.getElementById('customItemModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
    }

    function addCustomItemToCart(e) {
        e.preventDefault();
        const name = document.getElementById('customItemName').value.trim();
        const price = parseFloat(document.getElementById('customItemPrice').value);
        const qty = parseInt(document.getElementById('customItemQty').value) || 1;
        const notes = document.getElementById('customItemNotes').value.trim();

        if (!name || isNaN(price) || price <= 0) {
            alert('Please enter valid item name and price');
            return;
        }

        const customId = 'custom_' + Date.now();
        cart.push({
            id: customId,
            name: name,
            price: price,
            qty: qty,
            img: null,
            notes: notes
        });

        closeCustomItemModal();
        playSound('add');
        renderCart();
    }

    // --- ITEM NOTE MODAL ---
    function openItemNoteModal(index) {
        currentEditingItemIndex = index;
        const item = cart[index];
        if (!item) return;

        document.getElementById('noteItemName').innerText = item.name;
        document.getElementById('itemNoteInput').value = item.notes || '';
        
        const modal = document.getElementById('itemNoteModal');
        const content = document.getElementById('itemNoteModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        activeModal = 'itemNote';
        setTimeout(() => document.getElementById('itemNoteInput').focus(), 150);
    }

    function closeItemNoteModal() {
        const modal = document.getElementById('itemNoteModal');
        const content = document.getElementById('itemNoteModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
        currentEditingItemIndex = null;
    }

    function appendItemNote(text) {
        const input = document.getElementById('itemNoteInput');
        if (input.value.trim().length > 0) {
            input.value += ', ' + text;
        } else {
            input.value = text;
        }
    }

    function clearItemNote() {
        document.getElementById('itemNoteInput').value = '';
    }

    function saveItemNote() {
        if (currentEditingItemIndex !== null && cart[currentEditingItemIndex]) {
            cart[currentEditingItemIndex].notes = document.getElementById('itemNoteInput').value.trim();
            renderCart();
        }
        closeItemNoteModal();
    }

    // --- ORDER GENERAL NOTE MODAL ---
    function openOrderNotesModal() {
        document.getElementById('orderGeneralNoteInput').value = currentOrderGeneralNote;
        const modal = document.getElementById('orderNoteModal');
        const content = document.getElementById('orderNoteModalContent');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        activeModal = 'orderNote';
        setTimeout(() => document.getElementById('orderGeneralNoteInput').focus(), 150);
    }

    function closeOrderNotesModal() {
        const modal = document.getElementById('orderNoteModal');
        const content = document.getElementById('orderNoteModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
    }

    function saveOrderNote(val) {
        currentOrderGeneralNote = (val || '').trim();
        document.getElementById('orderNoteStatus').innerText = currentOrderGeneralNote ? 'Note ✓' : 'Note';
        closeOrderNotesModal();
    }

    // --- CHECKOUT & TOUCH NUMPAD ---
    let finalPayableTotal = 0;

    function openCheckout() {
        if (cart.length === 0) return;
        
        const totals = renderTotals();
        finalPayableTotal = totals.total;

        const totalItems = cart.reduce((sum, item) => sum + item.qty, 0);
        document.getElementById('modalTotal').innerText = finalPayableTotal.toLocaleString();
        document.getElementById('modalItemsSummary').innerText = `${totalItems} item${totalItems === 1 ? '' : 's'}`;
        
        const table = document.getElementById('orderTableNo').value.trim();
        document.getElementById('modalOrderTypeSummary').innerText = `${orderType === 'takeaway' ? 'Takeaway' : 'Dine In'}${table ? ' · ' + table : ''}`;
        
        document.getElementById('amtReceived').value = finalPayableTotal;
        calculateChange();
        
        setPaymentMethod('cash');
        
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        activeModal = 'checkout';
        
        setTimeout(() => document.getElementById('amtReceived').select(), 150);
    }

    function closeCheckout() {
        const modal = document.getElementById('checkoutModal');
        const content = document.getElementById('checkoutModalContent');
        
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
        document.getElementById('customerSuggestions').classList.add('hidden');
    }

    function setPaymentMethod(method) {
        paymentMethod = method;
        const btns = {
            'cash': document.getElementById('payCash'),
            'card': document.getElementById('payCard'),
            'upi': document.getElementById('payUpi')
        };
        
        Object.values(btns).forEach(b => {
            b.className = "rounded-xl py-2.5 text-xs font-black transition flex flex-col items-center gap-1 bg-white text-gray-700 border-2 border-gray-200 hover:bg-gray-50";
        });
        
        btns[method].className = "rounded-xl py-2.5 text-xs font-black transition flex flex-col items-center gap-1 bg-[#08784b] text-white border-2 border-[#08784b] shadow-xs";
        
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

    function addNumpadTender(val) {
        const amtInput = document.getElementById('amtReceived');
        const current = parseFloat(amtInput.value) || 0;
        amtInput.value = current + val;
        calculateChange();
    }

    function pressNumpad(key) {
        const input = document.getElementById('amtReceived');
        let current = input.value || '';
        
        if (key === 'clear') {
            input.value = '';
        } else if (key === 'backspace') {
            input.value = current.slice(0, -1);
        } else if (key === '.') {
            if (!current.includes('.')) {
                input.value = current + '.';
            }
        } else {
            input.value = current + key;
        }
        calculateChange();
    }

    function calculateChange() {
        if (paymentMethod !== 'cash') return;
        
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

    // --- CUSTOMER AUTOCOMPLETE SEARCH ---
    let searchDebounceTimeout = null;
    function handleCustomerPhoneInput(val) {
        clearTimeout(searchDebounceTimeout);
        const query = val.trim();
        const suggestionsDiv = document.getElementById('customerSuggestions');
        
        if (query.length < 3) {
            suggestionsDiv.classList.add('hidden');
            return;
        }

        searchDebounceTimeout = setTimeout(async () => {
            try {
                const res = await fetch(`/admin/pos/customers/search?q=${encodeURIComponent(query)}`);
                const data = await res.json();
                
                if (data.length > 0) {
                    suggestionsDiv.innerHTML = data.map(c => `
                        <div 
                            onclick="selectCustomer('${c.name || ''}', '${c.phone}')" 
                            class="p-2.5 hover:bg-emerald-50 cursor-pointer flex justify-between items-center transition"
                        >
                            <span class="text-xs font-bold text-gray-800">${c.name || 'Customer'}</span>
                            <span class="text-xs font-mono font-bold text-emerald-700">${c.phone}</span>
                        </div>
                    `).join('');
                    suggestionsDiv.classList.remove('hidden');
                } else {
                    suggestionsDiv.classList.add('hidden');
                }
            } catch (err) {
                console.error(err);
            }
        }, 300);
    }

    function selectCustomer(name, phone) {
        document.getElementById('custPhone').value = phone;
        if (name) {
            document.getElementById('custName').value = name;
        }
        document.getElementById('customerSuggestions').classList.add('hidden');
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
            table_no: document.getElementById('orderTableNo').value.trim() || null,
            notes: currentOrderGeneralNote || null,
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
                playSound('success');

                // Update Header Live Stats
                if (data.today_sales_total !== undefined) {
                    const hdrSales = document.getElementById('hdrTodaySales');
                    const hdrCount = document.getElementById('hdrTodayCount');
                    if (hdrSales) hdrSales.innerText = Number(data.today_sales_total).toLocaleString();
                    if (hdrCount) hdrCount.innerText = data.today_orders_count;
                }

                // Clear cart state
                cart = [];
                discountAmount = 0;
                discountPercent = 0;
                currentOrderGeneralNote = '';
                document.getElementById('orderTableNo').value = '';
                document.getElementById('orderNoteStatus').innerText = 'Note';
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
        activeModal = 'success';

        // Auto popup thermal receipt window for immediate printing
        window.open('/admin/pos/receipt/' + orderData.order_id, 'Receipt', 'width=400,height=600');
    }

    function closeSuccessModal() {
        const modal = document.getElementById('orderSuccessModal');
        const content = document.getElementById('orderSuccessModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
        currentSuccessOrderId = null;
    }

    function printSuccessReceipt() {
        if (currentSuccessOrderId) {
            window.open('/admin/pos/receipt/' + currentSuccessOrderId, 'Receipt', 'width=400,height=600');
        }
    }

    // --- RECENT ORDERS MODAL (F6) ---
    function toggleRecentOrdersModal() {
        const modal = document.getElementById('recentOrdersModal');
        const content = document.getElementById('recentOrdersModalContent');
        if (activeModal === 'recent') {
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.add('scale-95');
            activeModal = null;
        } else {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            activeModal = 'recent';
        }
    }

    // --- DAILY SALES REGISTER SUMMARY (F9) ---
    async function openDailySummary() {
        const modal = document.getElementById('dailySummaryModal');
        const content = document.getElementById('dailySummaryModalContent');
        
        try {
            const res = await fetch('{{ route('admin.pos.daily_summary') }}');
            const data = await res.json();
            
            document.getElementById('summaryTotalSales').innerText = Number(data.total_sales || 0).toLocaleString();
            document.getElementById('summaryTotalOrders').innerText = data.total_orders || 0;
            document.getElementById('summaryTotalItems').innerText = data.total_items_sold || 0;
            document.getElementById('summaryCashSales').innerText = Number(data.cash_sales || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
            document.getElementById('summaryCardSales').innerText = Number(data.card_sales || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
            document.getElementById('summaryUpiSales').innerText = Number(data.upi_sales || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
            document.getElementById('summaryDiscount').innerText = Number(data.total_discount || 0).toLocaleString(undefined, { minimumFractionDigits: 2 });
            document.getElementById('summaryDineInCount').innerText = data.dine_in_count || 0;
            document.getElementById('summaryTakeawayCount').innerText = data.takeaway_count || 0;
            document.getElementById('summaryModalDate').innerText = data.date || '';

            // Also sync header
            const hdrSales = document.getElementById('hdrTodaySales');
            const hdrCount = document.getElementById('hdrTodayCount');
            if (hdrSales) hdrSales.innerText = Number(data.total_sales || 0).toLocaleString();
            if (hdrCount) hdrCount.innerText = data.total_orders || 0;
        } catch (e) {
            console.error('Failed to refresh daily summary:', e);
        }

        modal.classList.remove('opacity-0', 'pointer-events-none');
        content.classList.remove('scale-95');
        activeModal = 'dailySummary';
    }

    function closeDailySummary() {
        const modal = document.getElementById('dailySummaryModal');
        const content = document.getElementById('dailySummaryModalContent');
        modal.classList.add('opacity-0', 'pointer-events-none');
        content.classList.add('scale-95');
        activeModal = null;
    }

    // --- SHORTCUTS CHEAT SHEET MODAL ---
    function toggleShortcutsModal() {
        const modal = document.getElementById('shortcutsModal');
        const content = document.getElementById('shortcutsModalContent');
        if (activeModal === 'shortcuts') {
            modal.classList.add('opacity-0', 'pointer-events-none');
            content.classList.add('scale-95');
            activeModal = null;
        } else {
            modal.classList.remove('opacity-0', 'pointer-events-none');
            content.classList.remove('scale-95');
            activeModal = 'shortcuts';
        }
    }

    // --- KEYBOARD SHORTCUTS CONTROLLER ---
    document.addEventListener('keydown', (e) => {
        // F1: Hold Order
        if (e.key === 'F1') {
            e.preventDefault();
            holdCurrentOrder();
        }
        
        // F2: Focus Search
        if (e.key === 'F2') {
            e.preventDefault();
            if (!activeModal) {
                searchInput.focus();
                searchInput.select();
            }
        }

        // F3: Parked / Held Orders List
        if (e.key === 'F3') {
            e.preventDefault();
            toggleHeldOrdersModal();
        }

        // F4: Charge / Checkout
        if (e.key === 'F4') {
            e.preventDefault();
            if (activeModal === 'success') {
                closeSuccessModal();
            } else if (!checkoutBtn.disabled && !activeModal) {
                openCheckout();
            }
        }

        // F6: Recent Orders
        if (e.key === 'F6') {
            e.preventDefault();
            toggleRecentOrdersModal();
        }

        // F8: Custom / Open Item
        if (e.key === 'F8') {
            e.preventDefault();
            if (!activeModal) {
                openCustomItemModal();
            }
        }

        // F9: Daily Summary
        if (e.key === 'F9') {
            e.preventDefault();
            if (activeModal === 'dailySummary') {
                closeDailySummary();
            } else {
                openDailySummary();
            }
        }
        
        // Escape: Close any open modal
        if (e.key === 'Escape') {
            if (activeModal === 'success') closeSuccessModal();
            else if (activeModal === 'checkout') closeCheckout();
            else if (activeModal === 'customItem') closeCustomItemModal();
            else if (activeModal === 'itemNote') closeItemNoteModal();
            else if (activeModal === 'orderNote') closeOrderNotesModal();
            else if (activeModal === 'held') toggleHeldOrdersModal();
            else if (activeModal === 'recent') toggleRecentOrdersModal();
            else if (activeModal === 'dailySummary') closeDailySummary();
            else if (activeModal === 'shortcuts') toggleShortcutsModal();
            else if (searchInput.value) clearSearch();
        }

        // Enter key inside checkout modal to confirm order
        if (e.key === 'Enter' && activeModal === 'checkout' && !e.target.matches('textarea')) {
            e.preventDefault();
            submitOrder();
        }
    });

</script>
@endpush
