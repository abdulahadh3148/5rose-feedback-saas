@extends('layouts.customer')

@section('title', 'Share Your Experience | 5Rose Cool Bar')

@section('hideCustomerChrome', '1')

@section('content')

<div class="fb-screen">

    <!-- COMPACT HEADER -->

    <header class="fb-header">

        <a href="{{ route('customer.home') }}"
           class="fb-back"
           aria-label="Back to home">
            ←
        </a>

        <div class="fb-brand">

            <div class="fb-logo">🌹</div>

            <strong>5Rose Cool Bar</strong>

            <span>📍 Kurunegala</span>

        </div>

        <div class="fb-header-space"></div>

    </header>


    <main class="fb-main">

        <!-- FORM VIEW -->

        <section id="formView">

            <div class="feedback-heading">

                <h1>Share your experience</h1>

                <p>It only takes a few seconds.</p>

            </div>

            <form id="feedbackForm" novalidate>

                <!-- RATING CARD -->

                <div class="feedback-card fb-rating-card">

                    <label class="field-label"
                           id="ratingLabel">

                        How was your experience today?

                    </label>

                    <div class="fb-stars"
                         role="group"
                         aria-labelledby="ratingLabel">

                        <button type="button"
                                class="fb-star"
                                data-value="1"
                                aria-label="1 star"
                                aria-pressed="false">★</button>

                        <button type="button"
                                class="fb-star"
                                data-value="2"
                                aria-label="2 stars"
                                aria-pressed="false">★</button>

                        <button type="button"
                                class="fb-star"
                                data-value="3"
                                aria-label="3 stars"
                                aria-pressed="false">★</button>

                        <button type="button"
                                class="fb-star"
                                data-value="4"
                                aria-label="4 stars"
                                aria-pressed="false">★</button>

                        <button type="button"
                                class="fb-star"
                                data-value="5"
                                aria-label="5 stars"
                                aria-pressed="false">★</button>

                    </div>

                    <input type="hidden"
                           name="rating"
                           id="rating"
                           value="">

                    <p id="ratingText"
                       class="rating-description"
                       aria-live="polite">

                        Select your rating

                    </p>

                    <p id="ratingError"
                       class="fb-error"
                       role="alert"></p>

                </div>


                <!-- FEEDBACK DETAILS CARD -->

                <div class="feedback-card">

                    <div class="form-field">

                        <label for="product"
                               class="field-label">

                            What did you order?

                        </label>

                        <select id="product"
                                name="product"
                                class="form-control">

                            <option value="">
                                Select an item (optional)
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

                            <option value="Fruit Salad">
                                Fruit Salad
                            </option>

                            <option value="Submarine Bun">
                                Submarine Bun
                            </option>

                            <option value="Masala Tea">
                                Masala Tea
                            </option>

                            <option value="Other">
                                Other
                            </option>

                        </select>

                    </div>


                    <!-- COMMENT -->

                    <div class="form-field">

                        <label for="comment"
                               class="field-label">

                            Your feedback

                        </label>

                        <textarea id="comment"
                                  name="comment"
                                  class="form-control"
                                  rows="4"
                                  minlength="5"
                                  maxlength="300"
                                  placeholder="What did you like or what could we improve?"
                                  aria-describedby="commentError"
                                  required></textarea>

                        <div class="character-count">

                            <span id="charCount">0</span>/300

                        </div>

                        <p id="commentError"
                           class="fb-error"
                           role="alert"></p>

                    </div>


                    <!-- CUSTOMER NAME -->

                    <div class="form-field">

                        <label for="customerName"
                               class="field-label">

                            Your name (optional)

                        </label>

                        <input type="text"
                               id="customerName"
                               name="customer_name"
                               class="form-control"
                               maxlength="80"
                               placeholder="Enter your name">

                        <p class="fb-help">

                            Leave blank to submit anonymously.

                        </p>

                    </div>


                    <!-- SUBMIT BUTTON -->

                    <button type="submit"
                            id="submitButton"
                            class="primary-button">

                        <span id="buttonText">
                            ➤ &nbsp; Submit Feedback
                        </span>

                        <span id="buttonLoading"
                              class="fb-loading"
                              hidden>

                            <span class="fb-spinner"></span>

                            Submitting...

                        </span>

                    </button>

                </div>

            </form>


            <!-- BOTTOM MESSAGE -->

            <div class="fb-bottom-note">

                <span>🛡️</span>

                <p>
                    Your feedback helps us serve you better!
                </p>

            </div>

        </section>


        <!-- SUCCESS VIEW -->

        <section id="successView"
                 class="success-card"
                 hidden>

            <div class="success-icon">✓</div>

            <h2>
                Thank you for helping us improve!
            </h2>

            <p>
                This is a UI preview.
                Your feedback has not been saved yet.
            </p>

            <a href="{{ route('customer.home') }}"
               class="primary-button">

                Back to Home →

            </a>

        </section>

    </main>

</div>


<!-- PAGE-SPECIFIC STYLING -->

<style>

.fb-screen {
    max-width: 480px;
    min-height: 100vh;
    margin: 0 auto;
    background: #fff;
}

.fb-header {
    min-height: 90px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 18px;
    background: #fff;
}

.fb-back {
    font-size: 25px;
    font-weight: 600;
    color: #173b2c;
}

.fb-brand {
    text-align: center;
}

.fb-logo {
    font-size: 26px;
}

.fb-brand strong {
    display: block;
    font-size: 15px;
    color: #075b3a;
}

.fb-brand span {
    display: block;
    margin-top: 3px;
    font-size: 10px;
    color: #708477;
}

.fb-header-space {
    width: 20px;
}

.fb-main {
    padding: 12px 18px 40px;
}

.fb-rating-card {
    text-align: center;
}

.fb-stars {
    display: flex;
    justify-content: center;
    gap: 2px;
    margin-top: 15px;
}

.fb-star {
    display: flex;
    align-items: center;
    justify-content: center;

    width: 46px;
    height: 50px;

    padding: 0;
    border: none;

    background: transparent;
    color: #d5d8d6;

    font-size: 42px;
    line-height: 1;

    transition:
        color 0.2s ease,
        transform 0.2s ease;
}

.fb-star.selected {
    color: #ffb400;
}

.fb-star:active {
    transform: scale(1.15);
}

.fb-star:focus-visible {
    outline: 2px solid #075b3a;
    outline-offset: 2px;
    border-radius: 8px;
}

.fb-error {
    margin-top: 8px;
    color: #e5484d;
    font-size: 12px;
}

.fb-error:empty {
    display: none;
}

.fb-help {
    margin-top: 8px;
    font-size: 11px;
    color: #77857c;
}

.fb-bottom-note {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    margin-top: 15px;
    padding: 20px;

    border-radius: 16px;
    background: #f0f8f3;

    color: #075b3a;
    font-size: 12px;
}

.fb-bottom-note span {
    font-size: 23px;
}

.fb-loading {
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.fb-loading[hidden],
#successView[hidden],
#formView[hidden] {
    display: none !important;
}

.fb-spinner {
    width: 18px;
    height: 18px;

    border: 2px solid rgba(255,255,255,0.4);
    border-top-color: #fff;
    border-radius: 50%;

    animation: fb-spin 0.7s linear infinite;
}

@keyframes fb-spin {
    to {
        transform: rotate(360deg);
    }
}

.success-card {
    margin-top: 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.04);
}

@media (min-width: 768px) {
    .fb-screen {
        margin: 30px auto;
        border: 1px solid #e8eeea;
        border-radius: 25px;
        box-shadow: 0 15px 50px rgba(0,0,0,0.05);
        overflow: hidden;
    }
}

@media (max-width: 360px) {
    .fb-main {
        padding: 12px 12px 35px;
    }

    .fb-star {
        width: 42px;
        font-size: 37px;
    }
}

@media (prefers-reduced-motion: reduce) {
    .fb-star {
        transition: none;
    }

    .fb-spinner {
        animation: none;
    }
}

</style>


<!-- INTERACTIVE UI LOGIC -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    const stars = document.querySelectorAll('.fb-star');

    const ratingInput =
        document.getElementById('rating');

    const ratingText =
        document.getElementById('ratingText');

    const ratingError =
        document.getElementById('ratingError');

    const comment =
        document.getElementById('comment');

    const commentError =
        document.getElementById('commentError');

    const charCount =
        document.getElementById('charCount');

    const form =
        document.getElementById('feedbackForm');

    const formView =
        document.getElementById('formView');

    const successView =
        document.getElementById('successView');

    const submitButton =
        document.getElementById('submitButton');

    const buttonText =
        document.getElementById('buttonText');

    const buttonLoading =
        document.getElementById('buttonLoading');


    const ratingLabels = {
        1: 'Poor',
        2: 'Fair',
        3: 'Good',
        4: 'Very Good',
        5: 'Excellent'
    };


    // STAR RATING

    stars.forEach(function (star) {

        star.addEventListener('click', function () {

            const value = Number(star.dataset.value);

            ratingInput.value = value;

            stars.forEach(function (item) {

                const itemValue =
                    Number(item.dataset.value);

                item.classList.toggle(
                    'selected',
                    itemValue <= value
                );

                item.setAttribute(
                    'aria-pressed',
                    String(itemValue === value)
                );

            });

            ratingText.textContent =
                ratingLabels[value];

            ratingError.textContent = '';

        });

    });


    // CHARACTER COUNTER

    comment.addEventListener('input', function () {

        charCount.textContent = comment.value.length;

        commentError.textContent = '';

        comment.removeAttribute('aria-invalid');

    });


    // FORM VALIDATION AND UI PREVIEW

    form.addEventListener('submit', function (event) {

        event.preventDefault();

        const rating = Number(ratingInput.value);

        const feedback = comment.value.trim();

        let isValid = true;


        if (rating < 1 || rating > 5) {

            ratingError.textContent =
                'Please select a rating.';

            isValid = false;

        } else {

            ratingError.textContent = '';

        }


        if (feedback.length < 5) {

            commentError.textContent =
                'Please enter at least 5 characters.';

            comment.setAttribute('aria-invalid', 'true');

            isValid = false;

        } else {

            commentError.textContent = '';

            comment.removeAttribute('aria-invalid');

        }


        if (!isValid) {

            if (rating < 1 || rating > 5) {
                stars[0].focus();
            } else {
                comment.focus();
            }

            return;

        }


        // Send feedback to Laravel
        submitButton.disabled = true;
        buttonText.hidden = true;
        buttonLoading.hidden = false;

        const formData = new FormData(form);

        fetch("{{ route('customer.feedback.store') }}", {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Validation failed or server error');
            return response.json();
        })
        .then(data => {
            // Update success message text to be genuine
            const successText = document.querySelector('#successView p');
            successText.textContent = "Your feedback has been saved. We truly appreciate your input!";

            formView.hidden = true;
            successView.hidden = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        })
        .catch(error => {
            console.error(error);
            alert("Something went wrong saving your feedback. Please try again.");
            submitButton.disabled = false;
            buttonText.hidden = false;
            buttonLoading.hidden = true;
        });

    });

});

</script>

@endsection
