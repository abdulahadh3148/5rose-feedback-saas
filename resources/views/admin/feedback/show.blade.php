@extends('layouts.admin')

@section('title', 'Feedback Details | 5Rose Admin')


@section('content')

<div
    class="mx-auto max-w-5xl
           px-4 py-8
           sm:px-6 lg:px-9"
>

    <a
        href="{{ url()->previous() }}"
        class="text-xs font-bold
               text-emerald-700"
    >
        ← Back to Feedback
    </a>


    <div
        class="mt-6 overflow-hidden
               rounded-[30px]
               border border-gray-200
               bg-white
               shadow-sm"
    >

        <div
            class="border-b border-gray-100
                   p-6 sm:p-8"
        >

            <div
                class="flex flex-col
                       justify-between gap-5
                       sm:flex-row
                       sm:items-start"
            >

                <div>

                    <span
                        class="text-[10px]
                               font-extrabold
                               tracking-[.16em]
                               text-emerald-700"
                    >
                        CUSTOMER FEEDBACK
                    </span>


                    <h1
                        class="mt-3 text-3xl
                               font-black
                               tracking-[-.04em]
                               text-[#092c20]"
                    >
                        Feedback #{{ $feedback->id }}
                    </h1>

                </div>


                <span
                    class="w-fit rounded-full
                           px-4 py-2
                           text-[10px]
                           font-extrabold
                           uppercase
                           {{ $feedback->status === 'approved'
                               ? 'bg-emerald-100 text-emerald-700'
                               : ($feedback->status === 'rejected'
                                   ? 'bg-red-100 text-red-600'
                                   : 'bg-amber-100 text-amber-700')
                           }}"
                >
                    {{ $feedback->status }}
                </span>

            </div>

        </div>



        <div
            class="grid gap-8 p-6
                   sm:p-8
                   lg:grid-cols-[1fr_280px]"
        >

            <div>

                <div
                    class="text-2xl
                           tracking-[3px]"
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


                <blockquote
                    class="mt-6
                           text-xl font-semibold
                           leading-9
                           text-[#19392c]"
                >
                    “{{ $feedback->comment }}”
                </blockquote>

            </div>



            <aside
                class="rounded-2xl
                       bg-[#f4f7f4]
                       p-5"
            >

                <dl class="space-y-5">

                    <div>

                        <dt
                            class="text-[9px]
                                   font-bold uppercase
                                   tracking-widest
                                   text-gray-400"
                        >
                            Customer
                        </dt>

                        <dd
                            class="mt-1 text-sm
                                   font-bold"
                        >
                            {{ $feedback->customer_name
                                ?: 'Anonymous'
                            }}
                        </dd>

                    </div>


                    <div>

                        <dt
                            class="text-[9px]
                                   font-bold uppercase
                                   tracking-widest
                                   text-gray-400"
                        >
                            Product
                        </dt>

                        <dd
                            class="mt-1 text-sm
                                   font-bold"
                        >
                            {{ $feedback->product
                                ?: 'Not specified'
                            }}
                        </dd>

                    </div>


                    <div>

                        <dt
                            class="text-[9px]
                                   font-bold uppercase
                                   tracking-widest
                                   text-gray-400"
                        >
                            Submitted
                        </dt>

                        <dd
                            class="mt-1 text-sm
                                   font-bold"
                        >
                            {{ $feedback->created_at
                                ->format('d M Y · h:i A')
                            }}
                        </dd>

                    </div>

                </dl>

            </aside>

        </div>



        <div
            class="flex flex-wrap
                   gap-3
                   border-t border-gray-100
                   p-6 sm:p-8"
        >

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
                        class="rounded-xl
                               bg-[#08784b]
                               px-6 py-3
                               text-sm font-extrabold
                               text-white"
                    >
                        ✓ Approve Feedback
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
                        onclick="return confirm('Reject this feedback?')"
                        class="rounded-xl
                               bg-red-50
                               px-6 py-3
                               text-sm font-extrabold
                               text-red-600"
                    >
                        Reject
                    </button>

                </form>

            @endif

        </div>

    </div>

</div>

@endsection
