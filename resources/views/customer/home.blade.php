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

                    <span class="rose-trust-icon">
                        ✦
                    </span>

                    <span>
                        Fresh drinks · Great taste · Happy people
                    </span>

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
    <section id="reviews" class="rose-reviews">
        <div class="rose-container">
            <div class="rose-section-head text-center">
                <span class="rose-section-badge">★ TESTIMONIALS</span>
                <h2 class="rose-section-title">Loved by <em>Kurunegala</em></h2>
                <p class="rose-section-subtitle">Real experiences shared by our valued customers who visit us for their daily refreshment.</p>
            </div>

            <div class="rose-reviews-grid">
                <div class="rose-review-card">
                    <div class="rose-review-stars">★★★★★</div>
                    <p class="rose-review-text">“The Royal Rose Falooda here is hands down the best in the area! The layers of ice cream, basil seeds and jelly are perfectly balanced.”</p>
                    <div class="rose-review-author">
                        <div class="rose-avatar">AF</div>
                        <div>
                            <strong>Ahamed Farhan</strong>
                            <span>Regular Visitor</span>
                        </div>
                    </div>
                </div>

                <div class="rose-review-card">
                    <div class="rose-review-stars">★★★★★</div>
                    <p class="rose-review-text">“Fresh Papaya juice and hot crispy egg rolls are my daily evening stop after work. Always clean, fast, and welcoming staff.”</p>
                    <div class="rose-review-author">
                        <div class="rose-avatar">NP</div>
                        <div>
                            <strong>Nadeesha Perera</strong>
                            <span>Local Foodie</span>
                        </div>
                    </div>
                </div>

                <div class="rose-review-card">
                    <div class="rose-review-stars">★★★★★</div>
                    <p class="rose-review-text">“The Fruit Salad with Ice Cream is loaded with fresh, crisp fruit cubes and heavenly honey syrup. My kids absolutely love it!”</p>
                    <div class="rose-review-author">
                        <div class="rose-avatar">KS</div>
                        <div>
                            <strong>Kavinda Silva</strong>
                            <span>Family Diners</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rose-feedback-prompt">
                <div class="rose-feedback-prompt-content">
                    <h3>Have you visited 5Rose Cool Bar recently?</h3>
                    <p>We cherish your feedback and use it to craft even better experiences for you.</p>
                </div>
                <a href="{{ route('customer.feedback') }}" class="rose-main-button">
                    <span>Share Your Review</span>
                    <span class="rose-button-arrow">↗</span>
                </a>
            </div>
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
                    <div class="rose-brand-text">
                        <strong style="color: white; font-size: 24px;">5Rose Cool Bar</strong>
                        <span style="color: var(--rose-muted);">GOOD FOOD. BRIGHTER DAYS.</span>
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
                </div>

                <div class="rose-footer-cta">
                    <h4>Your Thoughts Matter</h4>
                    <p>Help us serve you better by dropping a quick review.</p>
                    <a href="{{ route('customer.feedback') }}" class="rose-header-feedback" style="display: inline-flex; width: fit-content;">
                        Leave Feedback <span>↗</span>
                    </a>
                </div>
            </div>

            <div class="rose-footer-bottom">
                <p>&copy; {{ date('Y') }} 5Rose Cool Bar. All rights reserved.</p>
            </div>
        </div>
    </footer>

</div>
