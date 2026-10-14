@extends('layouts.admin')

@section('title', 'Order ' . $order->receipt_number . ' | 5Rose Admin')

@section('content')
<div class="mx-auto max-w-4xl px-4 py-7 sm:px-6 lg:px-9 lg:py-9">
    <a href="{{ route('admin.orders.index') }}" class="text-xs font-bold text-emerald-700 mb-6 inline-block">← Back to Orders</a>
    
    <div class="flex justify-between items-end mb-8">
        <div>
            <h1 class="text-3xl font-black tracking-[-.04em] text-[#092c20]">
                Order {{ $order->receipt_number }}
            </h1>
            <p class="text-sm font-bold text-gray-500 mt-1">{{ $order->created_at->format('F d, Y h:i A') }}</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ $order->getWhatsAppUrl() }}" target="_blank" class="inline-flex items-center gap-2 rounded-xl bg-[#25D366] px-5 py-2 text-sm font-bold text-white transition hover:bg-[#20bd5a] shadow-sm">
                📱 Send via WhatsApp
            </a>

            <button onclick="window.open('{{ route('admin.pos.receipt', $order) }}', 'Receipt', 'width=400,height=600')" class="rounded-xl border border-gray-200 bg-white px-5 py-2 text-sm font-bold text-gray-600 transition hover:bg-gray-50">
                🖨️ Re-Print
            </button>
            
            @if($order->status === 'completed')
            <form action="{{ route('admin.orders.update', $order) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="cancelled">
                <button type="submit" onclick="return confirm('Are you sure you want to cancel this order? This cannot be undone.')" class="rounded-xl bg-red-50 px-5 py-2 text-sm font-bold text-red-600 transition hover:bg-red-100">
                    Cancel Order
                </button>
            </form>
            @endif
        </div>
    </div>

    @if($order->status === 'cancelled')
        <div class="mb-6 flex items-center gap-3 rounded-2xl border border-red-100 bg-red-50 px-5 py-4 text-sm font-bold text-red-800">
            ⚠️ This order was cancelled.
        </div>
    @endif

    <div class="grid md:grid-cols-3 gap-6">
        <div class="md:col-span-2 space-y-6">
            {{-- ORDER ITEMS --}}
            <div class="overflow-hidden rounded-[24px] border border-gray-200 bg-white shadow-sm">
                <div class="p-5 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-black uppercase tracking-widest text-gray-600">Order Items</h3>
                </div>
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-[#f4f7f4] text-xs font-bold uppercase tracking-wider text-gray-500">
                        <tr>
                            <th class="px-5 py-4">Item</th>
                            <th class="px-5 py-4 text-center">Qty</th>
                            <th class="px-5 py-4 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-5 py-4">
                                <strong class="text-[#092c20] block">{{ $item->product_name }}</strong>
                                <span class="text-xs text-gray-400">Rs. {{ number_format($item->unit_price, 2) }}</span>
                            </td>
                            <td class="px-5 py-4 text-center font-bold">{{ $item->quantity }}</td>
                            <td class="px-5 py-4 text-right font-black text-[#08784b]">Rs. {{ number_format($item->line_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="bg-gray-50 p-5 border-t border-gray-200 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span class="font-bold">Rs. {{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->takeaway_charge > 0)
                    <div class="flex justify-between text-gray-600">
                        <span>Takeaway Charge</span>
                        <span class="font-bold">Rs. {{ number_format($order->takeaway_charge, 2) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200 mt-2">
                        <span class="font-extrabold text-gray-400 uppercase tracking-widest text-xs">Total</span>
                        <span class="text-2xl font-black text-[#08784b]">Rs. {{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            {{-- CUSTOMER INFO --}}
            <div class="rounded-[24px] border border-gray-200 bg-white shadow-sm p-6">
                <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Customer Details</h3>
                @if($order->customer)
                    <div class="font-bold text-[#092c20] text-lg">{{ $order->customer->name ?? 'Unknown Name' }}</div>
                    <div class="text-sm font-bold text-emerald-600 mt-1">{{ $order->customer->phone }}</div>
                @else
                    <div class="text-sm font-bold text-gray-500">Walk-in Customer</div>
                @endif
            </div>

            {{-- PAYMENT INFO --}}
            <div class="rounded-[24px] border border-gray-200 bg-white shadow-sm p-6">
                <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Payment Details</h3>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Method</span>
                        <span class="font-bold uppercase text-[#092c20]">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Order Type</span>
                        <span class="font-bold uppercase text-[#092c20]">{{ str_replace('_', ' ', $order->order_type) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-gray-500">Cash Received</span>
                        <span class="font-bold">Rs. {{ number_format($order->amount_received, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Change Given</span>
                        <span class="font-bold text-red-500">Rs. {{ number_format($order->balance, 2) }}</span>
                    </div>
                    <div class="flex justify-between border-t border-gray-100 pt-3">
                        <span class="text-gray-500">Cashier</span>
                        <span class="font-bold">{{ $order->user->name ?? 'Admin' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
