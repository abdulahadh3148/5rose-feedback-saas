<?php

namespace Tests\Unit;

use App\Models\Order;
use PHPUnit\Framework\TestCase;

class OrderWhatsAppTest extends TestCase
{
    public function test_format_whatsapp_phone_converts_local_number(): void
    {
        $order = new Order();
        $formatted = $order->formatWhatsAppPhone('0771234567');
        $this->assertEquals('94771234567', $formatted);
    }

    public function test_format_whatsapp_phone_preserves_international_number(): void
    {
        $order = new Order();
        $formatted = $order->formatWhatsAppPhone('+94771234567');
        $this->assertEquals('94771234567', $formatted);
    }

    public function test_format_whatsapp_phone_handles_empty(): void
    {
        $order = new Order();
        $formatted = $order->formatWhatsAppPhone('');
        $this->assertEquals('', $formatted);
    }

    public function test_whatsapp_message_includes_table_and_items(): void
    {
        $order = new Order([
            'receipt_number' => 'ORD-1234',
            'order_type' => 'dine_in',
            'table_no' => 'Table 5',
            'subtotal' => 500,
            'total' => 500,
            'payment_method' => 'cash',
        ]);

        $message = $order->getWhatsAppMessage();
        $this->assertStringContainsString('ORD-1234', $message);
        $this->assertStringContainsString('Table 5', $message);
    }
}
