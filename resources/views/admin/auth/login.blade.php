<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="theme-color"
        content="#061b14"
    >

    <title>
        Admin Login | 5Rose
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>


<body class="m-0 min-h-screen bg-[#061b14]">

<div
    class="relative min-h-screen overflow-hidden
           bg-[radial-gradient(circle_at_15%_20%,rgba(30,166,106,.20),transparent_30%),radial-gradient(circle_at_90%_90%,rgba(220,190,120,.08),transparent_30%),linear-gradient(135deg,#061912,#08281e,#061b14)]"
>

    <div
        class="absolute -right-32 -top-32
               h-[420px] w-[420px]
               rounded-full bg-emerald-500/10 blur-[100px]"
    ></div>


    <div
        class="relative z-10 mx-auto flex min-h-screen
               max-w-7xl items-center justify-center
               px-5 py-12"
    >

        <div
            class="grid w-full max-w-5xl overflow-hidden
                   rounded-[32px] border border-white/10
                   bg-white/[0.04] shadow-2xl
                   backdrop-blur-xl
                   lg:grid-cols-[1fr_0.9fr]"
        >

            {{-- LEFT --}}

            <section
                class="hidden min-h-[620px]
                       flex-col justify-between
                       p-12 text-white
                       lg:flex"
            >

                <div>

                    <div class="flex items-center gap-3">

                        <div
                            class="h-12 w-12 overflow-hidden
                                   rounded-2xl
                                   border border-white/20
                                   bg-white/10 p-1 flex items-center justify-center shadow-inner"
                        >
                            <img
                                src="{{ asset('images/5rose/logo.png') }}"
                                alt="5Rose Logo"
                                class="h-full w-full object-contain rounded-xl"
                                onerror="this.style.display='none'; this.parentElement.textContent='🌹';"
                            >
                        </div>

                        <div>

                            <strong
                                class="block text-lg font-extrabold"
                            >
                                5Rose
                            </strong>

                            <span
                                class="text-[9px]
                                       font-bold tracking-[.25em]
                                       text-white/45"
                            >
                                BUSINESS PLATFORM
                            </span>

                        </div>

                    </div>


                    <h1
                        class="mt-20 max-w-xl
                               text-6xl font-black
                               leading-[.98]
                               tracking-[-.07em]"
                    >

                        BUILT TO RUN
                        5ROSE

                        <span
                            class="block font-serif
                                   font-normal italic
                                   text-[#e3c77f]"
                        >
                            better.
                        </span>

                    </h1>


                    <p
                        class="mt-7 max-w-md
                               text-sm leading-7
                               text-white/55"
                    >

                        Secure administration for
                        customer experiences,
                        feedback and future
                        5Rose business operations.

                    </p>

                </div>


                <p
                    class="text-xs text-white/35"
                >
                    Authorized staff access only.
                </p>

            </section>



            {{-- LOGIN --}}

            <section
                class="bg-[#f8faf8]
                       px-6 py-10
                       sm:px-10
                       lg:px-12 lg:py-16"
            >

                <div class="mx-auto max-w-md">


                    <div class="lg:hidden">

                        <div
                            class="mb-10 flex
                                   items-center gap-3"
                        >

                            <span
                                class="h-11 w-11 overflow-hidden
                                       rounded-2xl
                                       bg-white border border-[#075b3a]/20 p-1 flex items-center justify-center shadow-sm"
                            >
                                <img
                                    src="{{ asset('images/5rose/logo.png') }}"
                                    alt="5Rose Logo"
                                    class="h-full w-full object-contain rounded-xl"
                                    onerror="this.style.display='none'; this.parentElement.textContent='🌹';"
                                >
                            </span>

                            <strong
                                class="text-lg
                                       text-[#092c20]"
                            >
                                5Rose
                            </strong>

                        </div>

                    </div>


                    <span
                        class="text-[10px]
                               font-extrabold
                               tracking-[.17em]
                               text-[#0b8152]"
                    >
                        SECURE ADMIN ACCESS
                    </span>


                    <h2
                        class="mt-4 text-4xl
                               font-black tracking-[-.05em]
                               text-[#08291d]"
                    >
                        Welcome back.
                    </h2>


                    <p
                        class="mt-3 text-sm
                               leading-6 text-gray-500"
                    >
                        Sign in to manage the
                        5Rose customer experience.
                    </p>



                    @if ($errors->any())

                        <div
                            class="mt-7 rounded-2xl
                                   border border-red-100
                                   bg-red-50
                                   px-4 py-3
                                   text-sm text-red-600"
                        >

                            {{ $errors->first() }}

                        </div>

                    @endif



                    <form
                        method="POST"
                        action="{{ route('admin.login.submit') }}"
                        class="mt-8 space-y-5"
                    >

                        @csrf


                        <div>

                            <label
                                for="email"
                                class="mb-2 block
                                       text-xs font-bold
                                       text-[#183a2d]"
                            >
                                Email address
                            </label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus
                                class="min-h-14 w-full
                                       rounded-2xl
                                       border border-gray-200
                                       bg-white px-4
                                       text-sm
                                       outline-none
                                       transition
                                       focus:border-emerald-500
                                       focus:ring-4
                                       focus:ring-emerald-500/10"
                                placeholder="admin@example.com"
                            >

                        </div>



                        <div>

                            <label
                                for="password"
                                class="mb-2 block
                                       text-xs font-bold
                                       text-[#183a2d]"
                            >
                                Password
                            </label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="current-password"
                                required
                                class="min-h-14 w-full
                                       rounded-2xl
                                       border border-gray-200
                                       bg-white px-4
                                       text-sm
                                       outline-none
                                       transition
                                       focus:border-emerald-500
                                       focus:ring-4
                                       focus:ring-emerald-500/10"
                                placeholder="••••••••••"
                            >

                        </div>



                        <label
                            class="flex cursor-pointer
                                   items-center gap-3
                                   text-xs text-gray-500"
                        >

                            <input
                                name="remember"
                                type="checkbox"
                                value="1"
                                class="h-4 w-4"
                            >

                            Keep me signed in

                        </label>



                        <button
                            type="submit"
                            class="flex min-h-14
                                   w-full items-center
                                   justify-between
                                   rounded-2xl
                                   bg-[#08784b]
                                   px-5
                                   text-sm font-extrabold
                                   text-white
                                   shadow-lg
                                   shadow-emerald-900/10
                                   transition
                                   hover:-translate-y-0.5
                                   hover:bg-[#06643e]"
                        >

                            <span>
                                Sign In Securely
                            </span>

                            <span
                                class="grid h-8 w-8
                                       place-items-center
                                       rounded-full
                                       bg-white/10"
                            >
                                →
                            </span>

                        </button>

                    </form>


                    <div
                        class="mt-8 flex items-start gap-3
                               rounded-2xl bg-[#edf6f0]
                               p-4 text-xs
                               leading-5 text-[#47705d]"
                    >

                        <span>🔒</span>

                        <span>
                            This area is restricted
                            to authorized 5Rose
                            administrators.
                        </span>

                    </div>

                </div>

            </section>

        </div>

    </div>

</div>

</body>
</html>
