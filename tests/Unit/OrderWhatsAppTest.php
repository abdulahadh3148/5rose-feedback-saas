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
}
