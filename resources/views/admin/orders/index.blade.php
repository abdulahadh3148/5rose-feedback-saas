@extends('layouts.admin')

@section('title', 'Orders & Sales | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-[1500px] px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <div class="flex flex-col justify-between gap-6 xl:flex-row xl:items-end mb-8">
        <div>
            <span class="text-[10px] font-extrabold tracking-[.18em] text-[#0b8152]">SALES HISTORY</span>
            <h1 class="mt-3 text-4xl font-black tracking-[-.055em] text-[#092c20] sm:text-5xl">Orders</h1>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-semibold text-emerald-800">
            ✓ {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex gap-4">
            <input type="search" name="search" value="{{ request('search') }}" placeholder="Search receipt number or customer..." class="min-h-12 w-full max-w-md rounded-2xl border border-gray-200 px-4 text-sm focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none">
            <button type="submit" class="min-h-12 rounded-2xl bg-[#092c20] px-6 font-bold text-white transition hover:bg-[#071d16]">Search</button>
        </form>
    </div>

    <div class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-gray-600">
            <thead class="bg-[#f4f7f4] text-xs font-bold uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-6 py-5">Receipt No</th>
                    <th class="px-6 py-5">Date</th>
                    <th class="px-6 py-5">Customer</th>
                    <th class="px-6 py-5">Total</th>
                    <th class="px-6 py-5">Status</th>
                    <th class="px-6 py-5 text-right">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="transition hover:bg-gray-50 {{ $order->status === 'cancelled' ? 'opacity-50' : '' }}">
                    <td class="px-6 py-4 font-black text-[#092c20]">{{ $order->receipt_number }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold">{{ $order->created_at->format('M d, Y') }}</div>
                        <div class="text-xs text-gray-400">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($order->customer)
                            <div class="font-bold text-[#092c20]">{{ $order->customer->name ?? 'Unknown' }}</div>
                            <div class="text-xs text-gray-400">{{ $order->customer->phone }}</div>
                        @else
                            <span class="text-gray-400 font-bold">Walk-in</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-black text-[#08784b]">Rs. {{ number_format($order->total, 2) }}</td>
                    <td class="px-6 py-4">
                        @if($order->status === 'completed')
                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-[10px] font-bold text-emerald-700 uppercase tracking-widest">Completed</span>
                        @else
                            <span class="rounded-full bg-red-100 px-3 py-1 text-[10px] font-bold text-red-700 uppercase tracking-widest">Cancelled</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ $order->getWhatsAppUrl() }}" target="_blank" title="Send WhatsApp Receipt" class="inline-flex items-center gap-1 rounded-xl bg-emerald-50 px-3 py-2 text-xs font-bold text-emerald-700 hover:bg-emerald-100 transition">
                                📱 WhatsApp
                            </a>
                            <a href="{{ route('admin.orders.show', $order) }}" class="inline-flex items-center rounded-xl border border-gray-200 px-4 py-2 text-xs font-bold text-gray-600 hover:bg-gray-50">View Details</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                        No orders found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
