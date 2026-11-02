<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PosSystemTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private Product $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);

        $category = Category::create([
            'name' => 'Cold Drinks',
            'slug' => 'cold-drinks',
            'icon' => '🥤',
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->product = Product::create([
            'category_id' => $category->id,
            'name' => 'Avocado Shake',
            'slug' => 'avocado-shake',
            'price' => 350.00,
            'is_available' => true,
            'show_on_pos' => true,
            'sort_order' => 1,
        ]);
    }

    public function test_admin_can_access_pos_screen(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.pos.index'));

        $response->assertStatus(200);
        $response->assertSee('5Rose POS');
        $response->assertSee('Avocado Shake');
    }

    public function test_pos_checkout_creates_order_with_product_and_custom_item(): void
    {
        $payload = [
            'items' => [
                [
                    'id' => $this->product->id,
                    'qty' => 2,
                    'notes' => 'Less ice',
                ],
                [
                    'id' => 'custom_123',
                    'name' => 'Special Ice Cream Scoop',
                    'price' => 120.00,
                    'qty' => 1,
                    'notes' => 'Chocolate syrup',
                ]
            ],
            'order_type' => 'dine_in',
            'table_no' => 'Table 4',
            'notes' => 'Serve fast',
            'payment_method' => 'cash',
            'amount_received' => 1000.00,
            'customer_name' => 'Mohamed',
            'customer_phone' => '0771234567',
            'discount' => 20.00,
        ];

        $response = $this->actingAs($this->admin)->postJson(route('admin.pos.store'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'table_no' => 'Table 4',
            'payment_method' => 'cash',
        ]);

        $this->assertDatabaseHas('orders', [
            'order_type' => 'dine_in',
            'table_no' => 'Table 4',
            'notes' => 'Serve fast',
            'subtotal' => 820.00, // 350*2 + 120*1 = 820
            'discount' => 20.00,
            'total' => 800.00,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_name' => 'Avocado Shake',
            'quantity' => 2,
            'notes' => 'Less ice',
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_name' => 'Special Ice Cream Scoop',
            'quantity' => 1,
            'notes' => 'Chocolate syrup',
        ]);
    }

    public function test_customer_search_returns_suggestions(): void
    {
        Customer::create([
            'name' => 'Abdul Wahab',
            'phone' => '0779988776',
        ]);

        $response = $this->actingAs($this->admin)->getJson(route('admin.pos.customers.search', ['q' => '07799']));

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'name' => 'Abdul Wahab',
            'phone' => '0779988776',
        ]);
    }

    public function test_daily_summary_endpoint(): void
    {
        $response = $this->actingAs($this->admin)->getJson(route('admin.pos.daily_summary'));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'date',
            'total_sales',
            'total_orders',
            'cash_sales',
            'card_sales',
            'upi_sales',
            'total_discount',
            'dine_in_count',
            'takeaway_count',
            'total_items_sold',
        ]);
    }
}
