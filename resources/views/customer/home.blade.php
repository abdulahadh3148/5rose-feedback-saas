@extends('layouts.customer')

@section('title', '5Rose Cool Bar | Good Food. Brighter Days.')

@push('styles')
    @vite('resources/css/customer-home.css')
@endpush

@push('scripts')
    @vite('resources/js/customer-home.js')
@endpush

@section('content')

<div class="rose-site">

    {{-- =========================
         HEADER
    ========================== --}}

    <header class="rose-header" id="siteHeader">

        <div class="rose-container rose-nav">

            <a
                href="{{ route('customer.home') }}"
                class="rose-brand"
                aria-label="5Rose Cool Bar home"
            >

                <div class="rose-logo-shell">

                    <img
                        src="{{ asset('images/5rose/logo.png') }}"
                        alt="5Rose Cool Bar"
                        class="rose-logo"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                    >

                    <span class="rose-logo-fallback">
                        🌹
                    </span>

                </div>

                <div class="rose-brand-text">

                    <strong>5Rose</strong>

                    <span>COOL BAR</span>

                </div>

            </a>


            <nav
                class="rose-desktop-nav"
                aria-label="Main navigation"
            >

                <a href="#home">Home</a>
                <a href="#discover">Discover</a>
                <a href="#reviews">Reviews</a>
                <a href="#gallery">Gallery</a>
                <a href="#connect">Connect</a>

            </nav>


            <a
                href="{{ route('customer.feedback') }}"
                class="rose-header-feedback"
            >

                Share Feedback

                <span>↗</span>

            </a>


            <button
                id="menuToggle"
                class="rose-menu-button"
                type="button"
                aria-label="Open navigation"
                aria-expanded="false"
            >

                <span></span>
                <span></span>

            </button>

        </div>


        {{-- MOBILE MENU --}}

        <nav
            id="mobileMenu"
            class="rose-mobile-menu"
            aria-label="Mobile navigation"
            hidden
        >

            <a href="#home">Home</a>

            <a href="#discover">
                Discover Our Menu
            </a>

            <a href="#reviews">
                Customer Reviews
            </a>

            <a href="#gallery">
                Gallery
            </a>

            <a href="#connect">
                Stay Connected
            </a>

            <a
                href="{{ route('customer.feedback') }}"
                class="rose-mobile-review"
            >

                Write a Review

                <span>↗</span>

            </a>

        </nav>

    </header>



    {{-- =========================
         HERO
    ========================== --}}

    <section
        id="home"
        class="rose-hero"
    >

        <div class="rose-noise"></div>

        <div class="rose-orb rose-orb-one"></div>
        <div class="rose-orb rose-orb-two"></div>

        <div class="rose-container rose-hero-grid">

            {{-- HERO COPY --}}

            <div class="rose-hero-copy">

                <div
                    class="rose-eyebrow rose-animate"
                    data-delay="0"
                >

                    <span class="rose-status-dot"></span>

                    FRESH MOMENTS START HERE

                </div>


                <h1
                    class="rose-hero-heading rose-animate"
                    data-delay="100"
                >

                    GOOD FOOD.

                    <span>
                        BRIGHTER
                        <em>DAYS.</em>
                    </span>

                </h1>


                <p
                    class="rose-hero-description rose-animate"
                    data-delay="180"
                >

                    More than just a drink.

                    Discover refreshing flavours,
                    delicious food and happy moments
                    made with care at 5Rose Cool Bar.

                </p>


                <div
                    class="rose-hero-actions rose-animate"
                    data-delay="260"
                >

                    <a
                        href="{{ route('customer.feedback') }}"
                        class="rose-main-button"
                    >

                        <span>
                            Share Your Experience
                        </span>

                        <span class="rose-button-arrow">
                            ↗
                        </span>

                    </a>


                    <a
                        href="#discover"
                        class="rose-secondary-link"
                    >

                        Explore 5Rose

                        <span>↓</span>

                    </a>

                </div>


                <div
                    class="rose-trust-row rose-animate"
                    data-delay="340"
                >

                    @if ($reviewCount > 0)

                        <div class="flex items-center gap-3">

                            <strong
                                class="text-4xl font-black
                                       text-white"
                            >
                                {{ number_format($averageRating, 1) }}
                            </strong>

                            <div>

                                <div
                                    class="tracking-[2px]
                                           text-[#ffb400]"
                                >
                                    @for ($i = 1; $i <= 5; $i++)

                                        <span>
                                            {{ $i <= round($averageRating) ? '★' : '☆' }}
                                        </span>

                                    @endfor
                                </div>

                                <p
                                    class="mt-1 text-xs
                                           text-white/60"
                                >
                                    Based on
                                    {{ $reviewCount }}
                                    approved
                                    {{ Str::plural('review', $reviewCount) }}
                                </p>

                            </div>

                        </div>

                    @else

                        <p class="text-sm text-white/60">
                            Be the first customer to share your experience.
                        </p>

                    @endif

                </div>

            </div>


            {{-- HERO VISUAL --}}

            <div
                class="rose-hero-visual rose-animate"
                data-delay="170"
                id="heroVisual"
            >

                <div class="rose-visual-ring"></div>

                <div class="rose-image-frame">

                    <img
                        src="{{ asset('images/5rose/rose-falooda.jpg') }}"
                        alt="5Rose Cool Bar Royal Rose Falooda"
                        class="rose-hero-image"
                        id="heroImage"
                        onerror="this.style.display='none';"
                    >

                    <div class="rose-image-fallback">

                        <span class="rose-fallback-small">
                            5ROSE
                        </span>

                        <strong>
                            FRESH
                        </strong>

                        <span>
                            GOOD VIBES
                        </span>

                    </div>

                    <div class="rose-image-shade"></div>

                </div>


                <div
                    class="rose-float-card rose-float-top"
                >

                    <span class="rose-float-icon">
                        ✦
                    </span>

                    <div>

                        <strong>
                            Freshly Made
                        </strong>

                        <span>
                            Prepared with care
                        </span>

                    </div>

                </div>


                <div
                    class="rose-float-card rose-float-bottom"
                >

                    <span class="rose-float-icon">
                        ♡
                    </span>

                    <div>

                        <strong>
                            Happy Moments
                        </strong>

                        <span>
                            Made at 5Rose
                        </span>

                    </div>

                </div>


                <div class="rose-vertical-word">
                    COOL BAR · KURUNEGALA
                </div>

            </div>

        </div>


        <a
            href="#discover"
            class="rose-scroll-indicator"
        >

            <span>
                SCROLL TO DISCOVER
            </span>

            <div class="rose-scroll-line">

                <span></span>

            </div>

        </a>

    </section>



    {{-- =========================
         DISCOVER MENU
    ========================== --}}
    <section id="discover" class="rose-discover">
        <div class="rose-container">
            <div class="rose-section-head text-center">
                <span class="rose-section-badge">✦ HANDCRAFTED FRESH DAILY</span>
                <h2 class="rose-section-title">Discover Our <em>Signature Taste</em></h2>
                <p class="rose-section-subtitle">
                    Crafted with genuine passion, premium ingredients, and the authentic flavours that make every sip and bite unforgettable.
                </p>
            </div>

            <div class="rose-categories-grid">
                {{-- Category 1: Fresh Juices & Milkshakes --}}
                <div class="rose-category-card">
                    <div class="rose-category-banner">
                        <img src="{{ asset('images/5rose/juices-milkshakes-banner.jpg') }}" alt="Fresh Juices and Milkshakes at 5Rose" loading="lazy">
                        <div class="rose-category-banner-overlay">
                            <span class="rose-category-pill">🥤 Fresh Juices &amp; Shakes</span>
                            <h3>Pure Fruits &amp; Chilled Milkshakes</h3>
                        </div>
                    </div>
                    <div class="rose-category-items">
                        <div class="rose-spotlight-item">
                            <div class="rose-spotlight-img-wrap">
                                <img src="{{ asset('images/5rose/rose-falooda.jpg') }}" alt="Royal Rose Falooda" loading="lazy">
                                <span class="rose-spotlight-badge">Signature</span>
                            </div>
                            <div class="rose-spotlight-info">
                                <div class="rose-spotlight-title-row">
                                    <h4>Royal Rose Falooda</h4>
                                    <span class="rose-item-tag">Top Seller</span>
                                </div>
                                <p>Chilled rose milk, sweet basil seeds, silky vermicelli, topped with premium vanilla ice cream &amp; chopped nuts.</p>
                            </div>
                        </div>

                        <div class="rose-spotlight-item">
                            <div class="rose-spotlight-img-wrap">
                                <img src="{{ asset('images/5rose/papaya-juice.jpg') }}" alt="Tropical Fresh Papaya Juice" loading="lazy">
                                <span class="rose-spotlight-badge">Healthy</span>
                            </div>
                            <div class="rose-spotlight-info">
                                <div class="rose-spotlight-title-row">
                                    <h4>Tropical Papaya Juice</h4>
                                    <span class="rose-item-tag">100% Pure</span>
                                </div>
                                <p>Freshly pressed sun-ripened papaya, rich in natural vitamins and served refreshingly ice-cold.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Category 2: Snacks & Desserts --}}
                <div class="rose-category-card">
                    <div class="rose-category-banner">
                        <img src="{{ asset('images/5rose/snacks-desserts-banner.jpg') }}" alt="5Rose Snacks and Desserts" loading="lazy">
                        <div class="rose-category-banner-overlay">
                            <span class="rose-category-pill">🍰 Snacks &amp; Desserts</span>
                            <h3>Sweet Indulgence &amp; Savoury Bites</h3>
                        </div>
                    </div>
                    <div class="rose-category-items">
                        <div class="rose-spotlight-item">
                            <div class="rose-spotlight-img-wrap">
                                <img src="{{ asset('images/5rose/fruit-salad.jpg') }}" alt="Special Fruit Salad with Ice Cream" loading="lazy">
                                <span class="rose-spotlight-badge">Dessert</span>
                            </div>
                            <div class="rose-spotlight-info">
                                <div class="rose-spotlight-title-row">
                                    <h4>Fruit Salad Sundae</h4>
                                    <span class="rose-item-tag">Must Try</span>
                                </div>
                                <p>Fresh seasonal fruit medley tossed with sweet raisins, honey drizzle, and crowned with rich vanilla ice cream.</p>
                            </div>
                        </div>

                        <div class="rose-spotlight-item">
                            <div class="rose-spotlight-img-wrap">
                                <img src="{{ asset('images/5rose/snacks-desserts-banner.jpg') }}" alt="Hot Savoury Snacks" loading="lazy" style="object-position: center bottom;">
                                <span class="rose-spotlight-badge">Hot</span>
                            </div>
                            <div class="rose-spotlight-info">
                                <div class="rose-spotlight-title-row">
                                    <h4>Crispy Savoury Bites</h4>
                                    <span class="rose-item-tag">Freshly Fried</span>
                                </div>
                                <p>Golden vegetable samosas, spicy egg rolls, crumbed cutlets, and savoury wraps prepared fresh daily.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================
         CUSTOMER REVIEWS
    ========================== --}}
    <section id="reviews" class="rose-reviews mt-12">
        <div class="rose-container">

            <div
                class="mb-6 flex items-end
                       justify-between gap-4"
            >

                <div>

                    <span
                        class="text-[10px]
                               font-extrabold
                               tracking-[.18em]
                               text-[#0b8152]"
                    >
                        CUSTOMER EXPERIENCES
                    </span>

                    <h2
                        class="mt-2 text-2xl
                               font-black
                               tracking-[-.04em]
                               text-[#173b2c]"
                    >
                        What customers are saying
                    </h2>

                </div>


                @if ($reviewCount > 0)

                    <div class="text-right">

                        <strong
                            class="block text-2xl
                                   font-black
                                   text-[#173b2c]"
                        >
                            {{ number_format($averageRating, 1) }}
                        </strong>

                        <span
                            class="text-xs text-[#ffb400]"
                        >
                            ★★★★★
                        </span>

                    </div>

                @endif

            </div>



            @if ($approvedReviews->isNotEmpty())

                <div
                    class="grid gap-4
                           md:grid-cols-2"
                >

                    @foreach ($approvedReviews as $review)

                        <article
                            class="group rounded-[22px]
                                   border border-[#e6ece7]
                                   bg-white p-5
                                   shadow-[0_6px_25px_rgba(7,91,58,.04)]
                                   transition duration-300
                                   hover:-translate-y-1
                                   hover:shadow-[0_15px_35px_rgba(7,91,58,.09)]"
                        >

                            <div
                                class="flex items-start
                                       justify-between gap-4"
                            >

                                <div
                                    class="flex items-center gap-3"
                                >

                                    <div
                                        class="grid h-10 w-10
                                               place-items-center
                                               rounded-full
                                               bg-[#e6f1e9]
                                               text-xs font-black
                                               text-[#08784b]"
                                    >
                                        {{ strtoupper(
                                            substr(
                                                $review->customer_name
                                                ?: 'A',
                                                0,
                                                1
                                            )
                                        ) }}
                                    </div>


                                    <div>

                                        <strong
                                            class="block text-sm
                                                   text-[#173b2c]"
                                        >
                                            {{ $review->customer_name
                                                ?: 'Anonymous Customer'
                                            }}
                                        </strong>

                                        <span
                                            class="mt-1 block
                                                   text-[10px]
                                                   text-gray-400"
                                        >
                                            {{ $review->approved_at
                                                ?->diffForHumans()
                                                ?? $review->created_at->diffForHumans()
                                            }}
                                        </span>

                                    </div>

                                </div>


                                @if ($review->product)

                                    <span
                                        class="rounded-full
                                               bg-[#edf6f0]
                                               px-3 py-1
                                               text-[9px]
                                               font-extrabold
                                               text-[#08784b]"
                                    >
                                        {{ $review->product }}
                                    </span>

                                @endif

                            </div>


                            <div
                                class="mt-4 tracking-[2px]"
                                aria-label="{{ $review->rating }} out of 5 stars"
                            >

                                @for ($i = 1; $i <= 5; $i++)

                                    <span
                                        class="{{ $i <= $review->rating
                                            ? 'text-[#ffb400]'
                                            : 'text-gray-200'
                                        }}"
                                    >
                                        ★
                                    </span>

                                @endfor

                            </div>


                            <p
                                class="mt-4 text-sm
                                       leading-7
                                       text-[#53645a]"
                            >
                                “{{ $review->comment }}”
                            </p>

                        </article>

                    @endforeach

                </div>


                <div
                    class="mt-5 flex flex-wrap
                           items-center
                           justify-between
                           gap-4 rounded-[18px]
                           bg-[#edf6f0]
                           px-5 py-4"
                >

                    <div>

                        <strong
                            class="block text-sm
                                   text-[#173b2c]"
                        >
                            {{ $reviewCount }}
                            approved
                            {{ Str::plural('review', $reviewCount) }}
                        </strong>

                        <span
                            class="text-[11px]
                                   text-[#718078]"
                        >
                            Based on verified customer feedback.
                        </span>

                    </div>


                    <a
                        href="{{ route('customer.feedback') }}"
                        class="rounded-full
                               bg-[#08784b]
                               px-5 py-3
                               text-xs font-extrabold
                               text-white
                               transition
                               hover:bg-[#06643e]"
                    >
                        Share Your Experience →
                    </a>

                </div>

            @else

                <div
                    class="rounded-[24px]
                           border border-dashed
                           border-[#d8e3db]
                           bg-white
                           px-6 py-12
                           text-center"
                >

                    <div
                        class="mx-auto grid
                               h-14 w-14
                               place-items-center
                               rounded-full
                               bg-[#edf6f0]
                               text-2xl"
                    >
                        ✦
                    </div>

                    <h3
                        class="mt-4 text-lg
                               font-black
                               text-[#173b2c]"
                    >
                        Be the first to share your experience.
                    </h3>

                    <p
                        class="mx-auto mt-2
                               max-w-sm
                               text-sm leading-6
                               text-gray-500"
                    >
                        Your honest feedback helps us
                        improve every visit.
                    </p>

                    <a
                        href="{{ route('customer.feedback') }}"
                        class="mt-5 inline-flex
                               rounded-full
                               bg-[#08784b]
                               px-6 py-3
                               text-xs font-extrabold
                               text-white"
                    >
                        Write a Review →
                    </a>

                </div>

            @endif

        </div>
    </section>

    {{-- =========================
         GALLERY
    ========================== --}}
    <section id="gallery" class="rose-gallery">
        <div class="rose-container">
            <div class="rose-section-head text-center">
                <span class="rose-section-badge">📸 VISUAL TREATS</span>
                <h2 class="rose-section-title">A Feast for <em>the Eyes</em></h2>
                <p class="rose-section-subtitle">A glimpse into our freshly crafted drinks, vibrant bowls, and tempting savoury selections.</p>
            </div>

            <div class="rose-gallery-grid">
                <div class="rose-gallery-item rose-gallery-wide">
                    <img src="{{ asset('images/5rose/juices-milkshakes-banner.jpg') }}" alt="Fresh Juices and Milkshakes Spread" loading="lazy">
                    <div class="rose-gallery-overlay">
                        <span>Signature Lineup</span>
                        <h4>Fresh Juices &amp; Milkshakes</h4>
                    </div>
                </div>

                <div class="rose-gallery-item">
                    <img src="{{ asset('images/5rose/rose-falooda.jpg') }}" alt="Signature Royal Rose Falooda" loading="lazy">
                    <div class="rose-gallery-overlay">
                        <span>Cold Delicacy</span>
                        <h4>Royal Rose Falooda</h4>
                    </div>
                </div>

                <div class="rose-gallery-item">
                    <img src="{{ asset('images/5rose/fruit-salad.jpg') }}" alt="Tropical Fruit Salad Sundae" loading="lazy">
                    <div class="rose-gallery-overlay">
                        <span>Sweet Craving</span>
                        <h4>Fruit Salad Sundae</h4>
                    </div>
                </div>

                <div class="rose-gallery-item">
                    <img src="{{ asset('images/5rose/papaya-juice.jpg') }}" alt="Fresh Papaya Juice" loading="lazy">
                    <div class="rose-gallery-overlay">
                        <span>100% Natural</span>
                        <h4>Fresh Papaya Juice</h4>
                    </div>
                </div>

                <div class="rose-gallery-item rose-gallery-wide">
                    <img src="{{ asset('images/5rose/snacks-desserts-banner.jpg') }}" alt="5Rose Snacks &amp; Desserts Spread" loading="lazy">
                    <div class="rose-gallery-overlay">
                        <span>Hot &amp; Savoury</span>
                        <h4>Snacks, Samosas &amp; Desserts</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- =========================
         CONNECT / FOOTER
    ========================== --}}
    <footer id="connect" class="rose-footer">
        <div class="rose-container">
            <div class="rose-footer-grid">
                <div class="rose-footer-brand">
                    <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 12px;">
                        <img
                            src="{{ asset('images/5rose/logo.png') }}"
                            alt="5Rose Logo"
                            style="width: 44px; height: 44px; object-fit: contain; border-radius: 12px; background: rgba(255,255,255,0.08); padding: 4px; border: 1px solid rgba(255,255,255,0.15);"
                            onerror="this.style.display='none';"
                        >
                        <div class="rose-brand-text">
                            <strong style="color: white; font-size: 24px;">5Rose Cool Bar</strong>
                            <span style="color: var(--rose-muted);">GOOD FOOD. BRIGHTER DAYS.</span>
                        </div>
                    </div>
                    <p class="rose-footer-tagline">
                        Your go-to cool spot in Kurunegala for refreshing pure fruit juices, decadent milkshakes, mouthwatering desserts, and hot savoury snacks.
                    </p>
                </div>

                <div class="rose-footer-info">
                    <h4>Visit Us</h4>
                    <p>Kurunegala, Sri Lanka</p>
                    <p>Open Daily · 9:00 AM – 11:00 PM</p>
                </div>

                <div class="rose-footer-links">
                    <h4>Quick Links</h4>
                    <a href="#home">Home</a>
                    <a href="#discover">Discover Menu</a>
                    <a href="#reviews">Customer Reviews</a>
                    <a href="#gallery">Gallery</a>
                    <a href="{{ route('customer.feedback') }}">Rate &amp; Feedback</a>
                    <a href="{{ route('admin.login') }}">Staff / Admin Login</a>
                </div>

                <div class="rose-footer-cta">
                    <h4>Your Thoughts Matter</h4>
                    <p>Help us serve you better by dropping a quick review.</p>
                    <a href="{{ route('customer.feedback') }}" class="rose-header-feedback" style="display: inline-flex; width: fit-content;">
                        Leave Feedback <span>↗</span>
                    </a>
                </div>
            </div>

            <div class="rose-footer-bottom" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <p>&copy; {{ date('Y') }} 5Rose Cool Bar. All rights reserved.</p>
                <a href="{{ route('admin.login') }}" style="color: var(--rose-muted); font-size: 13px; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 999px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s;" onmouseover="this.style.color='#fff'; this.style.borderColor='rgba(255,255,255,0.25)'" onmouseout="this.style.color='var(--rose-muted)'; this.style.borderColor='rgba(255,255,255,0.1)'">
                    🔒 Admin Login
                </a>
            </div>
        </div>
    </footer>

</div>
