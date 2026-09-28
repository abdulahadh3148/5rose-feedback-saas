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
        content="#071d16"
    >

    <title>
        @yield('title', '5Rose Admin')
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>


<body
    class="min-h-screen
           bg-[#f3f6f3]
           text-[#102d22]"
>

<div class="min-h-screen lg:flex">

    {{-- SIDEBAR --}}

    <aside
        class="hidden w-[260px]
               shrink-0 bg-[#071d16]
               text-white
               lg:flex lg:flex-col"
    >

        <div
            class="flex h-24
                   items-center gap-3
                   border-b border-white/10
                   px-7"
        >

            <div
                class="grid h-11 w-11
                       place-items-center
                       rounded-2xl
                       bg-white/10
                       text-xl"
            >
                🌹
            </div>


            <div>

                <strong
                    class="block text-lg font-black"
                >
                    5Rose
                </strong>

                <span
                    class="text-[9px]
                           font-bold
                           tracking-[.18em]
                           text-white/40"
                >
                    ADMIN PLATFORM
                </span>

            </div>

        </div>


        <nav
            class="flex-1 space-y-2 px-4 py-7"
        >

            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center
                       gap-3 rounded-2xl
                       px-4 py-3
                       text-sm font-bold
                       text-white/65
                       transition
                       hover:bg-white/10
                       hover:text-white"
            >
                <span>⌂</span>
                Dashboard
            </a>


            <a
                href="{{ route('admin.feedback.index') }}"
                class="flex items-center
                       gap-3 rounded-2xl
                       bg-white/10
                       px-4 py-3
                       text-sm font-bold
                       text-white"
            >
                <span>✦</span>
                Feedback
            </a>


            <div
                class="pt-6 text-[9px]
                       font-bold
                       tracking-[.17em]
                       text-white/25"
            >
                COMING NEXT
            </div>


            <span
                class="flex items-center
                       gap-3 px-4 py-3
                       text-sm text-white/30"
            >
                Products
            </span>

            <span
                class="flex items-center
                       gap-3 px-4 py-3
                       text-sm text-white/30"
            >
                Gallery
            </span>

            <span
                class="flex items-center
                       gap-3 px-4 py-3
                       text-sm text-white/30"
            >
                POS
            </span>

        </nav>


        <div
            class="border-t border-white/10
                   p-5"
        >

            <div
                class="mb-4 flex
                       items-center gap-3"
            >

                <div
                    class="grid h-9 w-9
                           place-items-center
                           rounded-full
                           bg-emerald-500/15
                           text-xs font-black
                           text-emerald-300"
                >

                    {{ strtoupper(
                        substr(auth()->user()->name, 0, 1)
                    ) }}

                </div>

                <div class="min-w-0">

                    <strong
                        class="block truncate
                               text-xs"
                    >
                        {{ auth()->user()->name }}
                    </strong>

                    <span
                        class="text-[9px]
                               uppercase
                               tracking-widest
                               text-white/35"
                    >
                        {{ auth()->user()->role }}
                    </span>

                </div>

            </div>


            <form
                method="POST"
                action="{{ route('admin.logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="w-full rounded-xl
                           border border-white/10
                           px-4 py-3
                           text-xs font-bold
                           text-white/65
                           transition
                           hover:bg-white/10
                           hover:text-white"
                >
                    Logout
                </button>

            </form>

        </div>

    </aside>



    {{-- MAIN --}}

    <main class="min-w-0 flex-1">

        {{-- MOBILE HEADER --}}

        <header
            class="flex min-h-20
                   items-center
                   justify-between
                   border-b border-gray-200
                   bg-white px-5
                   lg:hidden"
        >

            <div
                class="flex items-center gap-3"
            >

                <span
                    class="grid h-10 w-10
                           place-items-center
                           rounded-xl
                           bg-[#075b3a]
                           text-lg"
                >
                    🌹
                </span>

                <strong>
                    5Rose Admin
                </strong>

            </div>


            <a
                href="{{ route('admin.feedback.index') }}"
                class="rounded-xl
                       bg-[#edf6f0]
                       px-4 py-2
                       text-xs font-bold
                       text-[#08784b]"
            >
                Feedback
            </a>

        </header>


        @yield('content')

    </main>

</div>

</body>

</html>
