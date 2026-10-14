<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt {{ $order->receipt_number }}</title>
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Courier New', Courier, monospace;
            margin: 0;
            padding: 10px;
            width: 80mm; /* Standard thermal printer width */
            color: #000;
            background: #fff;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .border-bottom { border-bottom: 1px dashed #000; margin-bottom: 5px; padding-bottom: 5px; }
        .border-top { border-top: 1px dashed #000; margin-top: 5px; padding-top: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { text-align: left; padding: 2px 0; }
        .mb-2 { margin-bottom: 10px; }
        .header { margin-bottom: 15px; }
        .footer { margin-top: 15px; font-size: 10px; }

        /* Screen Action Bar */
        .no-print {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 8px;
            margin-bottom: 15px;
            display: flex;
            gap: 6px;
            justify-content: center;
        }
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: bold;
            font-family: system-ui, sans-serif;
            text-decoration: none;
            cursor: pointer;
            border: none;
        }
        .btn-wa {
            background: #25D366;
            color: #fff;
        }
        .btn-wa:hover {
            background: #20bd5a;
        }
        .btn-print {
            background: #092c20;
            color: #fff;
        }
        .btn-print:hover {
            background: #061d15;
        }
        .btn-close {
            background: #e2e8f0;
            color: #475569;
        }

        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body onload="window.print();">
    <div class="no-print">
        <button onclick="window.print()" class="btn-action btn-print">🖨️ Print</button>
        <a href="{{ $order->getWhatsAppUrl() }}" target="_blank" class="btn-action btn-wa">📱 WhatsApp</a>
        <button onclick="window.close()" class="btn-action btn-close">✕</button>
    </div>

    <div class="text-center header border-bottom">
        <h2 style="margin:0; font-size: 18px;">5ROSE COOLSPOT</h2>
        <div>Premium Cafe & Drinks</div>
        <div>Tel: 077 XXXXXXX</div>
    </div>

    <div class="mb-2 border-bottom">
        <div>Receipt: {{ $order->receipt_number }}</div>
        <div>Date: {{ $order->created_at->format('Y-m-d h:i A') }}</div>
        <div>Type: {{ strtoupper(str_replace('_', ' ', $order->order_type)) }}</div>
        @if($order->customer)
            <div>Customer: {{ $order->customer->name ?? $order->customer->phone }}</div>
        @endif
        <div>Cashier: {{ $order->user->name ?? 'Admin' }}</div>
    </div>

    <table class="border-bottom">
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->line_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="border-bottom">
        <table style="width: 100%;">
            <tr>
                <td>Subtotal:</td>
                <td class="text-right">{{ number_format($order->subtotal, 2) }}</td>
            </tr>
            @if($order->discount > 0)
            <tr>
                <td>Discount:</td>
                <td class="text-right">-{{ number_format($order->discount, 2) }}</td>
            </tr>
            @endif
            @if($order->takeaway_charge > 0)
            <tr>
                <td>Takeaway Charge:</td>
                <td class="text-right">{{ number_format($order->takeaway_charge, 2) }}</td>
            </tr>
            @endif
            <tr class="font-bold" style="font-size: 14px;">
                <td>TOTAL:</td>
                <td class="text-right">Rs. {{ number_format($order->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="border-bottom">
        <table style="width: 100%;">
            <tr>
                <td>Paid via {{ strtoupper($order->payment_method) }}:</td>
                <td class="text-right">{{ number_format($order->amount_received, 2) }}</td>
            </tr>
            @if($order->payment_method === 'cash')
            <tr>
                <td>Change:</td>
                <td class="text-right">{{ number_format($order->balance, 2) }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div class="text-center footer">
        <div>Thank you for visiting 5Rose!</div>
        <div>Powered by 5Rose POS</div>
    </div>
</body>
</html>
