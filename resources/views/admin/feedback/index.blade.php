@extends('layouts.admin')

@section('title', 'Customer Feedback | 5Rose Admin')


@section('content')

<div
    class="mx-auto max-w-[1500px]
           px-4 py-7
           sm:px-6
           lg:px-9 lg:py-9"
>

    {{-- HEADER --}}

    <div
        class="flex flex-col
               justify-between gap-6
               xl:flex-row
               xl:items-end"
    >

        <div>

            <span
                class="text-[10px]
                       font-extrabold
                       tracking-[.18em]
                       text-[#0b8152]"
            >
                CUSTOMER EXPERIENCE
            </span>


            <h1
                class="mt-3 text-4xl
                       font-black
                       tracking-[-.055em]
                       text-[#092c20]
                       sm:text-5xl"
            >
                Feedback Moderation
            </h1>


            <p
                class="mt-3 max-w-xl
                       text-sm leading-7
                       text-gray-500"
            >
                Review every customer experience
                before deciding what should appear
                publicly on the 5Rose website.
            </p>

        </div>


        <form
            method="GET"
            action="{{ route('admin.feedback.index') }}"
            class="flex w-full
                   max-w-md gap-2"
        >

            <input
                type="hidden"
                name="status"
                value="{{ $status }}"
            >

            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search customer, product or feedback..."
                class="min-h-12 min-w-0
                       flex-1 rounded-2xl
                       border border-gray-200
                       bg-white px-4
                       text-sm outline-none
                       transition
                       focus:border-emerald-500
                       focus:ring-4
                       focus:ring-emerald-500/10"
            >

            <button
                type="submit"
                class="min-h-12
                       rounded-2xl
                       bg-[#092c20]
                       px-5
                       text-xs font-extrabold
                       text-white"
            >
                Search
            </button>

        </form>

    </div>



    {{-- TOAST --}}

    @if (session('success'))

        <div
            class="mt-7 flex
                   items-center gap-3
                   rounded-2xl
                   border border-emerald-100
                   bg-emerald-50
                   px-5 py-4
                   text-sm font-semibold
                   text-emerald-800"
        >

            <span
                class="grid h-8 w-8
                       place-items-center
                       rounded-full
                       bg-emerald-100"
            >
                ✓
            </span>

            {{ session('success') }}

        </div>

    @endif



    {{-- STATS --}}

    <div
        class="mt-8 grid
               gap-4
               sm:grid-cols-3"
    >

        <a
            href="{{ route(
                'admin.feedback.index',
                ['status' => 'pending']
            ) }}"
            class="group rounded-[24px]
                   border
                   {{ $status === 'pending'
                        ? 'border-amber-200 bg-amber-50'
                        : 'border-gray-200 bg-white'
                   }}
                   p-5 shadow-sm
                   transition
                   hover:-translate-y-1
                   hover:shadow-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <span
                    class="text-xs font-extrabold
                           uppercase tracking-widest
                           text-gray-500"
                >
                    Pending
                </span>

                <span
                    class="grid h-10 w-10
                           place-items-center
                           rounded-2xl
                           bg-amber-100"
                >
                    ◷
                </span>

            </div>


            <strong
                class="mt-5 block
                       text-4xl font-black
                       tracking-[-.05em]
                       text-[#092c20]"
            >
                {{ $counts['pending'] }}
            </strong>

            <span
                class="mt-2 block
                       text-xs text-gray-500"
            >
                Waiting for review
            </span>

        </a>



        <a
            href="{{ route(
                'admin.feedback.index',
                ['status' => 'approved']
            ) }}"
            class="group rounded-[24px]
                   border
                   {{ $status === 'approved'
                        ? 'border-emerald-200 bg-emerald-50'
                        : 'border-gray-200 bg-white'
                   }}
                   p-5 shadow-sm
                   transition
                   hover:-translate-y-1
                   hover:shadow-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <span
                    class="text-xs font-extrabold
                           uppercase tracking-widest
                           text-gray-500"
                >
                    Approved
                </span>

                <span
                    class="grid h-10 w-10
                           place-items-center
                           rounded-2xl
                           bg-emerald-100"
                >
                    ✓
                </span>

            </div>


            <strong
                class="mt-5 block
                       text-4xl font-black
                       tracking-[-.05em]
                       text-[#092c20]"
            >
                {{ $counts['approved'] }}
            </strong>

            <span
                class="mt-2 block
                       text-xs text-gray-500"
            >
                Ready for public display
            </span>

        </a>



        <a
            href="{{ route(
                'admin.feedback.index',
                ['status' => 'rejected']
            ) }}"
            class="group rounded-[24px]
                   border
                   {{ $status === 'rejected'
                        ? 'border-red-200 bg-red-50'
                        : 'border-gray-200 bg-white'
                   }}
                   p-5 shadow-sm
                   transition
                   hover:-translate-y-1
                   hover:shadow-lg"
        >

            <div
                class="flex items-center
                       justify-between"
            >

                <span
                    class="text-xs font-extrabold
                           uppercase tracking-widest
                           text-gray-500"
                >
                    Rejected
                </span>

                <span
                    class="grid h-10 w-10
                           place-items-center
                           rounded-2xl
                           bg-red-100"
                >
                    ×
                </span>

            </div>


            <strong
                class="mt-5 block
                       text-4xl font-black
                       tracking-[-.05em]
                       text-[#092c20]"
            >
                {{ $counts['rejected'] }}
            </strong>

            <span
                class="mt-2 block
                       text-xs text-gray-500"
            >
                Hidden from public website
            </span>

        </a>

    </div>



    {{-- LIST --}}

    <div class="mt-8">

        <div
            class="mb-4 flex
                   items-center
                   justify-between"
        >

            <div>

                <h2
                    class="text-xl font-black
                           capitalize
                           tracking-[-.03em]
                           text-[#092c20]"
                >
                    {{ $status }} Feedback
                </h2>

                <p
                    class="mt-1 text-xs
                           text-gray-500"
                >
                    {{ $feedbacks->total() }}
                    record{{ $feedbacks->total() === 1 ? '' : 's' }}
                </p>

            </div>

        </div>



        @if ($feedbacks->count())

            <div class="grid gap-4">

                @foreach ($feedbacks as $feedback)

                    <article
                        class="overflow-hidden
                               rounded-[24px]
                               border border-gray-200
                               bg-white
                               shadow-sm
                               transition
                               hover:shadow-md"
                    >

                        <div
                            class="grid gap-5
                                   p-5
                                   lg:grid-cols-[180px_1fr_auto]
                                   lg:items-center
                                   lg:p-6"
                        >

                            {{-- META --}}

                            <div>

                                <div
                                    class="flex items-center
                                           gap-3"
                                >

                                    <div
                                        class="grid h-11 w-11
                                               place-items-center
                                               rounded-full
                                               bg-[#e8f2eb]
                                               text-xs font-black
                                               text-[#08784b]"
                                    >

                                        {{ strtoupper(
                                            substr(
                                                $feedback->customer_name
                                                ?: 'A',
                                                0,
                                                1
                                            )
                                        ) }}

                                    </div>


                                    <div class="min-w-0">

                                        <strong
                                            class="block truncate
                                                   text-sm
                                                   text-[#102d22]"
                                        >

                                            {{ $feedback->customer_name
                                                ?: 'Anonymous Customer'
                                            }}

                                        </strong>


                                        <span
                                            class="mt-1 block
                                                   text-[10px]
                                                   text-gray-400"
                                        >

                                            {{ $feedback->created_at
                                                ->format('d M Y · h:i A')
                                            }}

                                        </span>

                                    </div>

                                </div>

                            </div>



                            {{-- CONTENT --}}

                            <div>

                                <div
                                    class="flex flex-wrap
                                           items-center gap-3"
                                >

                                    <div
                                        class="tracking-[2px]
                                               text-amber-400"
                                        aria-label="{{ $feedback->rating }} out of 5"
                                    >

                                        @for ($i = 1; $i <= 5; $i++)

                                            <span
                                                class="{{ $i <= $feedback->rating
                                                    ? 'text-amber-400'
                                                    : 'text-gray-200'
                                                }}"
                                            >
                                                ★
                                            </span>

                                        @endfor

                                    </div>


                                    @if ($feedback->product)

                                        <span
                                            class="rounded-full
                                                   bg-[#edf6f0]
                                                   px-3 py-1
                                                   text-[9px]
                                                   font-extrabold
                                                   text-[#08784b]"
                                        >
                                            {{ $feedback->product }}
                                        </span>

                                    @endif

                                </div>


                                <p
                                    class="mt-3
                                           text-sm leading-7
                                           text-gray-600"
                                >

                                    “{{ $feedback->comment }}”

                                </p>

                            </div>



                            {{-- ACTIONS --}}

                            <div
                                class="flex flex-wrap
                                       gap-2
                                       lg:justify-end"
                            >

                                <a
                                    href="{{ route(
                                        'admin.feedback.show',
                                        $feedback
                                    ) }}"
                                    class="inline-flex
                                           min-h-10
                                           items-center
                                           rounded-xl
                                           border border-gray-200
                                           px-4
                                           text-xs font-bold
                                           text-gray-600
                                           transition
                                           hover:bg-gray-50"
                                >
                                    View
                                </a>


                                @if ($feedback->status !== 'approved')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.feedback.approve',
                                            $feedback
                                        ) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="min-h-10
                                                   rounded-xl
                                                   bg-[#08784b]
                                                   px-4
                                                   text-xs font-extrabold
                                                   text-white
                                                   transition
                                                   hover:bg-[#06633e]"
                                        >
                                            ✓ Approve
                                        </button>

                                    </form>

                                @endif


                                @if ($feedback->status !== 'rejected')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.feedback.reject',
                                            $feedback
                                        ) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Reject this feedback?')"
                                            class="min-h-10
                                                   rounded-xl
                                                   bg-red-50
                                                   px-4
                                                   text-xs font-extrabold
                                                   text-red-600
                                                   transition
                                                   hover:bg-red-100"
                                        >
                                            Reject
                                        </button>

                                    </form>

                                @endif


                                @if ($feedback->status !== 'pending')

                                    <form
                                        method="POST"
                                        action="{{ route(
                                            'admin.feedback.pending',
                                            $feedback
                                        ) }}"
                                    >

                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="min-h-10
                                                   rounded-xl
                                                   bg-gray-100
                                                   px-4
                                                   text-xs font-bold
                                                   text-gray-600"
                                        >
                                            Pending
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </div>

                    </article>

                @endforeach

            </div>



            <div class="mt-7">

                {{ $feedbacks->links() }}

            </div>

        @else

            <div
                class="rounded-[28px]
                       border border-dashed
                       border-gray-300
                       bg-white
                       px-6 py-16
                       text-center"
            >

                <div
                    class="mx-auto grid
                           h-16 w-16
                           place-items-center
                           rounded-full
                           bg-[#edf6f0]
                           text-2xl"
                >
                    ✦
                </div>


                <h3
                    class="mt-5 text-xl
                           font-black
                           tracking-[-.03em]
                           text-[#092c20]"
                >
                    Nothing here yet.
                </h3>


                <p
                    class="mx-auto mt-2
                           max-w-sm text-sm
                           leading-6 text-gray-500"
                >

                    There are currently no
                    {{ $status }} customer feedback records.

                </p>

            </div>

        @endif

    </div>

</div>

@endsection
