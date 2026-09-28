document.addEventListener(
    'DOMContentLoaded',
    () => {

        const header =
            document.getElementById(
                'siteHeader'
            );

        const menuToggle =
            document.getElementById(
                'menuToggle'
            );

        const mobileMenu =
            document.getElementById(
                'mobileMenu'
            );

        const heroVisual =
            document.getElementById(
                'heroVisual'
            );

        const reduceMotion =
            window.matchMedia(
                '(prefers-reduced-motion: reduce)'
            ).matches;


        /*
        ==============================
        HEADER
        ==============================
        */

        function updateHeader() {

            if (!header) return;

            header.classList.toggle(
                'is-scrolled',
                window.scrollY > 35
            );

        }


        updateHeader();


        window.addEventListener(
            'scroll',
            updateHeader,
            {
                passive: true
            }
        );



        /*
        ==============================
        HERO ENTRANCE
        ==============================
        */

        const animatedElements =
            document.querySelectorAll(
                '.rose-animate'
            );


        animatedElements.forEach(
            (element) => {

                const delay =
                    Number(
                        element.dataset.delay
                        || 0
                    );

                element.style.animationDelay =
                    `${delay}ms`;

            }
        );


        requestAnimationFrame(
            () => {

                requestAnimationFrame(
                    () => {

                        animatedElements
                            .forEach(
                                element => {

                                    element
                                        .classList
                                        .add(
                                            'is-visible'
                                        );

                                }
                            );

                    }
                );

            }
        );



        /*
        ==============================
        MOBILE MENU
        ==============================
        */

        function closeMenu() {

            if (
                !menuToggle ||
                !mobileMenu
            ) return;


            mobileMenu.hidden = true;


            menuToggle
                .classList
                .remove(
                    'is-open'
                );


            menuToggle
                .setAttribute(
                    'aria-expanded',
                    'false'
                );


            document.body
                .classList
                .remove(
                    'menu-open'
                );

        }



        function openMenu() {

            if (
                !menuToggle ||
                !mobileMenu
            ) return;


            mobileMenu.hidden = false;


            menuToggle
                .classList
                .add(
                    'is-open'
                );


            menuToggle
                .setAttribute(
                    'aria-expanded',
                    'true'
                );


            document.body
                .classList
                .add(
                    'menu-open'
                );

        }



        if (
            menuToggle &&
            mobileMenu
        ) {

            menuToggle.addEventListener(
                'click',
                () => {

                    if (
                        mobileMenu.hidden
                    ) {

                        openMenu();

                    } else {

                        closeMenu();

                    }

                }
            );


            mobileMenu
                .querySelectorAll('a')
                .forEach(
                    link => {

                        link.addEventListener(
                            'click',
                            closeMenu
                        );

                    }
                );

        }



        /*
        ==============================
        SMOOTH SECTION NAVIGATION
        ==============================
        */

        document
            .querySelectorAll(
                'a[href^="#"]'
            )
            .forEach(
                link => {

                    link.addEventListener(
                        'click',
                        event => {

                            const targetId =
                                link.getAttribute(
                                    'href'
                                );


                            if (
                                !targetId ||
                                targetId === '#'
                            ) return;


                            const target =
                                document
                                    .querySelector(
                                        targetId
                                    );


                            if (!target) return;


                            event.preventDefault();


                            target
                                .scrollIntoView(
                                    {
                                        behavior:
                                            reduceMotion
                                            ? 'auto'
                                            : 'smooth',

                                        block:
                                            'start'
                                    }
                                );

                        }
                    );

                }
            );



        /*
        ==============================
        SUBTLE HERO PARALLAX
        Desktop only
        ==============================
        */

        if (
            heroVisual &&
            !reduceMotion
        ) {

            const canHover =
                window.matchMedia(
                    '(hover: hover)'
                ).matches;


            if (canHover) {

                window.addEventListener(
                    'pointermove',
                    event => {

                        if (
                            window.innerWidth
                            < 900
                        ) return;


                        const x =
                            (
                                event.clientX
                                /
                                window.innerWidth
                            ) - 0.5;


                        const y =
                            (
                                event.clientY
                                /
                                window.innerHeight
                            ) - 0.5;


                        heroVisual.style.transform =
                            `
                            translate3d(
                                ${x * 10}px,
                                ${y * 8}px,
                                0
                            )
                            `;

                    },
                    {
                        passive: true
                    }
                );

            }

        }



        /*
        ==============================
        ESCAPE KEY
        ==============================
        */

        document.addEventListener(
            'keydown',
            event => {

                if (
                    event.key === 'Escape'
                ) {

                    closeMenu();

                }

            }
        );

    }
);
