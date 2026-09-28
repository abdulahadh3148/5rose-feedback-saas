<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        Admin | 5Rose
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])

</head>


<body class="min-h-screen bg-[#f4f7f4]">

<div
    class="mx-auto max-w-6xl px-5 py-10"
>

    <div
        class="flex flex-wrap
               items-center
               justify-between
               gap-5"
    >

        <div>

            <span
                class="text-xs font-extrabold
                       tracking-[.15em]
                       text-emerald-700"
            >
                5ROSE ADMIN
            </span>

            <h1
                class="mt-2 text-4xl
                       font-black
                       tracking-[-.05em]
                       text-[#08291d]"
            >
                Admin access is ready.
            </h1>

        </div>


        <form
            method="POST"
            action="{{ route('admin.logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="rounded-xl
                       bg-[#08291d]
                       px-5 py-3
                       text-sm font-bold
                       text-white"
            >
                Logout
            </button>

        </form>

    </div>


    <div
        class="mt-10 rounded-[28px]
               border border-gray-200
               bg-white p-10
               shadow-sm"
    >

        <div class="text-5xl">
            ✓
        </div>

        <h2
            class="mt-5 text-2xl
                   font-extrabold
                   text-[#08291d]"
        >
            Secure admin authentication works.
        </h2>

        <p
            class="mt-3 text-sm
                   leading-7 text-gray-500"
        >
            Next we will replace this temporary
            screen with the premium Feedback
            Moderation Dashboard.
        </p>

        <a
            href="{{ route('admin.feedback.index') }}"
            class="mt-6 inline-flex
                   rounded-xl bg-[#08784b]
                   px-6 py-3
                   text-sm font-bold text-white"
        >
            Manage Customer Feedback →
        </a>

    </div>

</div>

</body>
</html>
