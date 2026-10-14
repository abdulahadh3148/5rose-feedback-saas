<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        
        $products = Product::with('category')
            ->where('is_available', true)
            ->where('show_on_pos', true)
            ->orderBy('sort_order')
            ->get();

        return view('admin.pos.index', compact('categories', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'order_type' => 'required|string|in:dine_in,takeaway',
            'payment_method' => 'required|string|in:cash,card,upi',
            'amount_received' => 'nullable|numeric|min:0',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'discount' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            $customerId = null;
            if (!empty($validated['customer_phone'])) {
                $customer = Customer::firstOrCreate(
                    ['phone' => $validated['customer_phone']],
                    ['name' => $validated['customer_name'] ?? null]
                );
                if (!empty($validated['customer_name']) && $customer->name !== $validated['customer_name']) {
                    $customer->update(['name' => $validated['customer_name']]);
                }
                $customerId = $customer->id;
            }

            $subtotal = 0;
            $takeawayCharge = $validated['order_type'] === 'takeaway' ? 50 : 0; 
            
            $orderItemsData = [];
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['id']);
                $lineTotal = $product->price * $item['qty'];
                $subtotal += $lineTotal;
                
                $orderItemsData[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'unit_price' => $product->price,
                    'quantity' => $item['qty'],
                    'line_total' => $lineTotal,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $discount = floatval($validated['discount'] ?? 0);
            $total = max(0, $subtotal + $takeawayCharge - $discount);
            $amountReceived = $validated['amount_received'] ?: $total;
            $balance = max(0, $amountReceived - $total);

            $order = Order::create([
                'receipt_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'customer_id' => $customerId,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'takeaway_charge' => $takeawayCharge,
                'total' => $total,
                'amount_received' => $amountReceived,
                'balance' => $balance,
                'payment_method' => $validated['payment_method'],
                'order_type' => $validated['order_type'],
                'status' => 'completed',
            ]);

            foreach ($orderItemsData as &$itemData) {
                $itemData['order_id'] = $order->id;
            }
            OrderItem::insert($orderItemsData);

            DB::commit();

            $order->load(['items', 'customer', 'user']);

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'receipt_number' => $order->receipt_number,
                'total' => $order->total,
                'whatsapp_url' => $order->getWhatsAppUrl(),
                'customer_phone' => $order->customer?->phone,
                'customer_name' => $order->customer?->name,
                'message' => 'Order created successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order: ' . $e->getMessage()
            ], 500);
        }
    }

    public function receipt(Order $order)
    {
        $order->load(['items', 'customer', 'user']);
        return view('admin.pos.receipt', compact('order'));
    }
}
