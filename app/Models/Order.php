<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['receipt_number', 'user_id', 'customer_id', 'subtotal', 'discount', 'takeaway_charge', 'total', 'amount_received', 'balance', 'payment_method', 'order_type', 'status'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formatWhatsAppPhone(?string $phone = null): string
    {
        $phone = $phone ?? $this->customer?->phone ?? '';
        $digits = preg_replace('/[^0-9]/', '', $phone);
        if (empty($digits)) {
            return '';
        }
        // If starting with 0 and 10 digits (common in Sri Lanka), prefix with country code 94
        if (str_starts_with($digits, '0') && strlen($digits) === 10) {
            $digits = '94' . substr($digits, 1);
        }
        return $digits;
    }

    public function getWhatsAppMessage(): string
    {
        $this->loadMissing(['items', 'customer', 'user']);

        $lines = [];
        $lines[] = "🧾 *5ROSE COOLSPOT - OFFICIAL RECEIPT*";
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "*Receipt #:* " . $this->receipt_number;
        $lines[] = "*Date:* " . ($this->created_at ? $this->created_at->format('d M Y, h:i A') : now()->format('d M Y, h:i A'));
        $lines[] = "*Order Type:* " . strtoupper(str_replace('_', ' ', $this->order_type ?? 'dine_in'));
        if ($this->customer) {
            $custName = $this->customer->name ?? $this->customer->phone;
            if ($custName) {
                $lines[] = "*Customer:* " . $custName;
            }
        }
        if ($this->user) {
            $lines[] = "*Cashier:* " . $this->user->name;
        }
        $lines[] = "------------------------------------";
        $lines[] = "*Items Ordered:*";
        foreach ($this->items as $item) {
            $lines[] = "• " . $item->quantity . "x " . $item->product_name . " — Rs. " . number_format($item->line_total, 2);
        }
        $lines[] = "------------------------------------";
        $lines[] = "*Subtotal:* Rs. " . number_format($this->subtotal, 2);
        if ($this->takeaway_charge > 0) {
            $lines[] = "*Takeaway Charge:* Rs. " . number_format($this->takeaway_charge, 2);
        }
        $lines[] = "*TOTAL:* *Rs. " . number_format($this->total, 2) . "*";
        $lines[] = "*Payment:* " . strtoupper($this->payment_method ?? 'cash');
        if ($this->payment_method === 'cash' && $this->amount_received > 0) {
            $lines[] = "  (Paid: Rs. " . number_format($this->amount_received, 2) . " | Change: Rs. " . number_format($this->balance, 2) . ")";
        }
        $lines[] = "━━━━━━━━━━━━━━━━━━━━";
        $lines[] = "Thank you for visiting *5Rose Coolspot*! 🌸";
        $lines[] = "We'd love your feedback: " . url('/feedback');

        return implode("\n", $lines);
    }

    public function getWhatsAppUrl(?string $phone = null): string
    {
        $formattedPhone = $this->formatWhatsAppPhone($phone);
        $encodedMessage = rawurlencode($this->getWhatsAppMessage());

        if (!empty($formattedPhone)) {
            return "https://wa.me/{$formattedPhone}?text={$encodedMessage}";
        }

        return "https://wa.me/?text={$encodedMessage}";
    }
}

