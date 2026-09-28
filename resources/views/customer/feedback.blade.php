@extends('layouts.customer')

@section('title', 'Share Your Experience | 5Rose Coolspot')

@section('hideCustomerChrome', '1')


@push('styles')
    @vite('resources/css/feedback-premium.css')
@endpush


@push('scripts')
    @vite('resources/js/feedback-premium.js')
@endpush


@section('content')

<div class="feedback-experience">

    <div class="feedback-orb feedback-orb-one"></div>
    <div class="feedback-orb feedback-orb-two"></div>


    {{-- TOP BAR --}}

    <header class="feedback-topbar">

        <a
            href="{{ route('customer.home') }}"
            class="feedback-back"
        >
            <span>←</span>
            <span>Back to 5Rose</span>
        </a>


        <div class="feedback-brand">

            <div class="feedback-brand-logo">
                <img
                    src="{{ asset('images/5rose/logo.png') }}"
                    alt="5Rose Coolspot Logo"
                    style="width: 100%; height: 100%; object-fit: contain; border-radius: 12px;"
                    onerror="this.style.display='none'; this.parentElement.textContent='🌹';"
                >
            </div>

            <div>

                <strong>
                    5Rose Coolspot
                </strong>

                <small>
                    KURUNEGALA
                </small>

            </div>

        </div>


        <div
            class="network-badge"
            id="networkBadge"
        >

            <span class="network-dot"></span>

            <span data-network-label>
                Online
            </span>

        </div>

    </header>



    <main class="feedback-shell">


        {{-- LEFT STORY --}}

        <section
            class="feedback-story feedback-reveal"
        >

            <span class="feedback-kicker">

                <span class="feedback-kicker-dot"></span>

                YOUR EXPERIENCE MATTERS

            </span>


            <h1>
                <span>HELP US MAKE</span>
                <span>EVERY VISIT</span>
                <em>BETTER.</em>
            </h1>


            <p>
                Loved something? Tell us.
                Something didn't feel right? Tell us that too.
                Honest feedback helps us create a better
                5Rose experience for every customer.
            </p>


            <div class="feedback-values">

                <div class="feedback-value">

                    <span class="feedback-value-icon">
                        ✦
                    </span>

                    <span>
                        Good and bad feedback are both welcome
                    </span>

                </div>


                <div class="feedback-value">

                    <span class="feedback-value-icon">
                        ⚡
                    </span>

                    <span>
                        Takes less than a minute
                    </span>

                </div>


                <div class="feedback-value">

                    <span class="feedback-value-icon">
                        ♡
                    </span>

                    <span>
                        Your feedback is reviewed with care
                    </span>

                </div>

            </div>


            <p class="feedback-quote">

                “Better experiences begin by listening.”

                <br>

                — 5Rose Coolspot

            </p>

        </section>



        {{-- FORM CARD --}}

        <section
            class="feedback-panel
                   feedback-reveal
                   feedback-delay-1"
        >


            {{-- FORM VIEW --}}

            <div
                id="feedbackFormView"
                class="feedback-form-view"
            >

                <div class="feedback-panel-top">

                    <div class="feedback-step">

                        <span>
                            SHARE YOUR EXPERIENCE
                        </span>

                        <small>
                            ~ 30 seconds
                        </small>

                    </div>


                    <h2>
                        How was your visit?
                    </h2>


                    <p class="feedback-panel-subtitle">

                        A few words from you can make
                        the next visit even better.

                    </p>

                </div>



                <form
                    id="feedbackForm"
                    action="{{ route('customer.feedback.store') }}"
                    method="POST"
                    novalidate
                >

                    @csrf


                    {{-- RATING --}}

                    <div class="rating-area">

                        <label
                            class="rating-title"
                            id="ratingTitle"
                        >
                            Rate your overall experience
                        </label>


                        <p class="rating-subtitle">
                            Tap the stars below
                        </p>


                        <div
                            class="premium-stars"
                            role="group"
                            aria-labelledby="ratingTitle"
                        >

                            @for ($rating = 1; $rating <= 5; $rating++)

                                <button
                                    type="button"
                                    class="premium-star"
                                    data-value="{{ $rating }}"
                                    aria-label="{{ $rating }} star rating"
                                    aria-pressed="false"
                                >
                                    ★
                                </button>

                            @endfor

                        </div>


                        <input
                            type="hidden"
                            name="rating"
                            id="rating"
                            value=""
                        >


                        <p
                            id="ratingResult"
                            class="rating-result"
                        >
                            Choose your rating
                        </p>


                        <p
                            id="ratingError"
                            class="feedback-error"
                            role="alert"
                        ></p>

                    </div>



                    <div class="feedback-fields">


                        {{-- PRODUCT --}}

                        <div class="feedback-field">

                            <label for="product">
                                What did you order?
                                <span>Optional</span>
                            </label>


                            <select
                                id="product"
                                name="product"
                                class="feedback-input"
                            >

                                <option value="">
                                    Select an item
                                </option>

                                <option value="Avocado Milkshake">
                                    Avocado Milkshake
                                </option>

                                <option value="Falooda">
                                    Falooda
                                </option>

                                <option value="Durian Juice">
                                    Durian Juice
                                </option>

                                <option value="Badham">
                                    Badham
                                </option>

                                <option value="Molisha">
                                    Molisha
                                </option>

                                <option value="Fruit Salad">
                                    Fruit Salad
                                </option>

                                <option value="Submarine Bun">
                                    Submarine Bun
                                </option>

                                <option value="Chicken Samosa">
                                    Chicken Samosa
                                </option>

                                <option value="Masala Tea">
                                    Masala Tea
                                </option>

                                <option value="Other">
                                    Other
                                </option>

                            </select>

                        </div>



                        {{-- COMMENT --}}

                        <div class="feedback-field">

                            <label for="comment">
                                Tell us about your experience
                            </label>


                            <textarea
                                id="comment"
                                name="comment"
                                class="feedback-input"
                                maxlength="300"
                                minlength="5"
                                required
                                placeholder="What did you enjoy? What should we improve?"
                            ></textarea>


                            <div class="feedback-character-row">

                                <span>
                                    Honest feedback is always welcome.
                                </span>

                                <span>
                                    <span id="charCount">0</span>/300
                                </span>

                            </div>


                            <p
                                id="commentError"
                                class="feedback-error"
                                role="alert"
                            ></p>

                        </div>



                        {{-- NAME --}}

                        <div class="feedback-field">

                            <label for="customerName">

                                Your name

                                <span>
                                    Optional
                                </span>

                            </label>


                            <input
                                id="customerName"
                                name="customer_name"
                                type="text"
                                maxlength="80"
                                autocomplete="name"
                                class="feedback-input"
                                placeholder="Enter your name or leave anonymous"
                            >

                        </div>

                    </div>



                    <div class="feedback-privacy">

                        <span class="feedback-privacy-icon">
                            🛡
                        </span>

                        <span>

                            Your feedback is sent directly
                            to 5Rose.

                            Only feedback approved by our team
                            may appear publicly.

                        </span>

                    </div>



                    <button
                        type="submit"
                        class="feedback-submit"
                        id="feedbackSubmit"
                    >

                        <span id="submitText">
                            Send My Feedback
                        </span>

                        <span
                            class="feedback-submit-arrow"
                            id="submitStatus"
                        >
                            ↗
                        </span>

                    </button>

                </form>

            </div>



            {{-- SUCCESS --}}

            <div
                class="feedback-success"
                id="feedbackSuccess"
                hidden
            >

                <div class="feedback-success-inner">

                    <div class="success-ring">

                        <span class="success-check">
                            ✓
                        </span>

                        <span class="success-particle p1"></span>
                        <span class="success-particle p2"></span>
                        <span class="success-particle p3"></span>
                        <span class="success-particle p4"></span>

                    </div>


                    <h2>
                        Thank you for helping
                        us improve.
                    </h2>


                    <p>
                        Your feedback has been received successfully.

                        We truly appreciate you taking a moment
                        to help us create a better 5Rose experience.
                    </p>


                    <a
                        href="{{ route('customer.home') }}"
                        class="success-back"
                    >
                        Back to 5Rose →
                    </a>

                </div>

            </div>

        </section>

    </main>

</div>

@endsection
