document.addEventListener('DOMContentLoaded', () => {

    const form =
        document.getElementById('feedbackForm');

    if (!form) return;


    const stars =
        [...document.querySelectorAll('.premium-star')];

    const ratingInput =
        document.getElementById('rating');

    const ratingResult =
        document.getElementById('ratingResult');

    const ratingError =
        document.getElementById('ratingError');

    const comment =
        document.getElementById('comment');

    const charCount =
        document.getElementById('charCount');

    const commentError =
        document.getElementById('commentError');

    const submitButton =
        document.getElementById('feedbackSubmit');

    const submitText =
        document.getElementById('submitText');

    const submitStatus =
        document.getElementById('submitStatus');

    const formView =
        document.getElementById('feedbackFormView');

    const successView =
        document.getElementById('feedbackSuccess');

    const networkBadge =
        document.getElementById('networkBadge');

    const product =
        document.getElementById('product');

    const customerName =
        document.getElementById('customerName');


    const ratingLabels = {
        1: 'We are sorry — tell us what went wrong',
        2: 'Thank you — we can do better',
        3: 'Good — thank you for your feedback',
        4: 'Very good — glad you enjoyed it',
        5: 'Excellent — thank you! ❤️',
    };


    function updateNetwork() {

        if (!networkBadge) return;

        const online =
            navigator.onLine;

        networkBadge.classList.toggle(
            'offline',
            !online
        );

        const label =
            networkBadge.querySelector(
                '[data-network-label]'
            );

        if (label) {
            label.textContent =
                online
                    ? 'Online'
                    : 'Offline';
        }

    }


    updateNetwork();

    window.addEventListener(
        'online',
        updateNetwork
    );

    window.addEventListener(
        'offline',
        updateNetwork
    );


    stars.forEach(star => {

        star.addEventListener(
            'click',
            () => {

                const value =
                    Number(
                        star.dataset.value
                    );

                ratingInput.value =
                    String(value);


                stars.forEach(item => {

                    const itemValue =
                        Number(
                            item.dataset.value
                        );

                    item.classList.toggle(
                        'selected',
                        itemValue <= value
                    );

                    item.setAttribute(
                        'aria-pressed',
                        String(
                            itemValue === value
                        )
                    );

                });


                ratingResult.textContent =
                    ratingLabels[value];


                ratingError.textContent =
                    '';

            }
        );

    });


    comment.addEventListener(
        'input',
        () => {

            const length =
                comment.value.length;

            charCount.textContent =
                length;

            commentError.textContent =
                '';

            comment.classList.remove(
                'is-invalid'
            );

            if (length >= 5) {

                comment.classList.add(
                    'is-valid'
                );

            } else {

                comment.classList.remove(
                    'is-valid'
                );

            }

        }
    );


    form.addEventListener(
        'submit',
        async event => {

            event.preventDefault();


            const rating =
                Number(
                    ratingInput.value
                );

            const feedbackText =
                comment.value.trim();


            let valid = true;


            if (
                rating < 1 ||
                rating > 5
            ) {

                ratingError.textContent =
                    'Please choose your rating.';

                valid = false;

            }


            if (
                feedbackText.length < 5
            ) {

                commentError.textContent =
                    'Please tell us a little more about your experience.';

                comment.classList.add(
                    'is-invalid'
                );

                valid = false;

            } else {

                comment.classList.remove(
                    'is-invalid'
                );

                comment.classList.add(
                    'is-valid'
                );

            }


            if (!valid) {

                if (!rating) {

                    stars[0]?.focus();

                } else {

                    comment.focus();

                }

                return;

            }


            if (!navigator.onLine) {

                alert(
                    'Internet connection is unavailable. Please try again when you are online.'
                );

                return;

            }


            submitButton.disabled =
                true;


            submitText.textContent =
                'Sending...';

            submitButton.setAttribute(
                'aria-busy',
                'true'
            );


            submitStatus.innerHTML =
                '<span class="feedback-spinner"></span>';


            try {

                const formData =
                    new FormData(form);


                const response =
                    await fetch(
                        form.action,
                        {
                            method: 'POST',

                            body: formData,

                            headers: {
                                'X-Requested-With':
                                    'XMLHttpRequest',

                                'Accept':
                                    'application/json',
                            },
                        }
                    );


                if (!response.ok) {

                    if (
                        response.status === 422
                    ) {

                        const data =
                            await response.json();

                        const errors =
                            data.errors || {};


                        if (
                            errors.rating?.[0]
                        ) {

                            ratingError.textContent =
                                errors.rating[0];

                        }


                        if (
                            errors.comment?.[0]
                        ) {

                            commentError.textContent =
                                errors.comment[0];

                        }

                    }


                    throw new Error(
                        'Feedback request failed'
                    );

                }


                submitButton.removeAttribute(
                    'aria-busy'
                );

                formView.hidden = true;

                successView.hidden = false;


                window.scrollTo({
                    top: 0,
                    behavior: 'smooth',
                });


            } catch (error) {

                console.error(error);


                submitButton.removeAttribute(
                    'aria-busy'
                );

                submitButton.disabled =
                    false;


                submitText.textContent =
                    'Send My Feedback';


                submitStatus.innerHTML =
                    '↗';


                if (
                    !ratingError.textContent &&
                    !commentError.textContent
                ) {

                    alert(
                        'We could not save your feedback. Please try again.'
                    );

                }

            }

        }
    );

});
