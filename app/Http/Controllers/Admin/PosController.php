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

        $todayOrdersCount = Order::whereDate('created_at', today())->count();
        $todaySalesTotal = (float) Order::whereDate('created_at', today())
            ->where('status', 'completed')
            ->sum('total');

        $recentOrders = Order::with(['customer', 'items'])
            ->whereDate('created_at', today())
            ->orderBy('id', 'desc')
            ->take(15)
            ->get();

        $todaySummary = $this->getTodaySummaryData();

        return view('admin.pos.index', compact(
            'categories',
            'products',
            'todayOrdersCount',
            'todaySalesTotal',
            'recentOrders',
            'todaySummary'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable',
            'items.*.name' => 'nullable|string|max:255',
            'items.*.price' => 'nullable|numeric|min:0',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:255',
            'order_type' => 'required|string|in:dine_in,takeaway',
            'table_no' => 'nullable|string|max:50',
            'notes' => 'nullable|string|max:500',
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
                if (!empty($item['id']) && is_numeric($item['id'])) {
                    $product = Product::find($item['id']);
                    if ($product) {
                        $productName = $product->name;
                        $unitPrice = (float) $product->price;
                        $productId = $product->id;
                    } else {
                        $productName = $item['name'] ?? 'Custom Item';
                        $unitPrice = floatval($item['price'] ?? 0);
                        $productId = null;
                    }
                } else {
                    $productName = $item['name'] ?? 'Custom Item';
                    $unitPrice = floatval($item['price'] ?? 0);
                    $productId = null;
                }

                $qty = intval($item['qty']);
                $lineTotal = $unitPrice * $qty;
                $subtotal += $lineTotal;
                
                $orderItemsData[] = [
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'unit_price' => $unitPrice,
                    'quantity' => $qty,
                    'line_total' => $lineTotal,
                    'notes' => !empty($item['notes']) ? trim($item['notes']) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $discount = floatval($validated['discount'] ?? 0);
            $total = max(0, $subtotal + $takeawayCharge - $discount);
            $amountReceived = !empty($validated['amount_received']) ? floatval($validated['amount_received']) : $total;
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
                'table_no' => $validated['table_no'] ?? null,
                'notes' => $validated['notes'] ?? null,
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
                'order_type' => $order->order_type,
                'table_no' => $order->table_no,
                'payment_method' => $order->payment_method,
                'whatsapp_url' => $order->getWhatsAppUrl(),
                'customer_phone' => $order->customer?->phone,
                'customer_name' => $order->customer?->name,
                'created_at' => $order->created_at->format('h:i A'),
                'items_count' => count($orderItemsData),
                'today_orders_count' => Order::whereDate('created_at', today())->count(),
                'today_sales_total' => (float) Order::whereDate('created_at', today())->where('status', 'completed')->sum('total'),
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

    public function searchCustomer(Request $request)
    {
        $query = trim($request->get('q', ''));
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $customers = Customer::where('phone', 'like', "%{$query}%")
            ->orWhere('name', 'like', "%{$query}%")
            ->orderBy('id', 'desc')
            ->take(5)
            ->get(['id', 'name', 'phone']);

        return response()->json($customers);
    }

    public function dailySummary()
    {
        return response()->json($this->getTodaySummaryData());
    }

    private function getTodaySummaryData(): array
    {
        $today = today();
        $orders = Order::whereDate('created_at', $today)->where('status', 'completed')->get();

        return [
            'date' => now()->format('d M Y'),
            'total_sales' => (float) $orders->sum('total'),
            'total_orders' => $orders->count(),
            'cash_sales' => (float) $orders->where('payment_method', 'cash')->sum('total'),
            'card_sales' => (float) $orders->where('payment_method', 'card')->sum('total'),
            'upi_sales' => (float) $orders->where('payment_method', 'upi')->sum('total'),
            'total_discount' => (float) $orders->sum('discount'),
            'dine_in_count' => $orders->where('order_type', 'dine_in')->count(),
            'takeaway_count' => $orders->where('order_type', 'takeaway')->count(),
            'total_items_sold' => (int) OrderItem::whereHas('order', function ($q) use ($today) {
                $q->whereDate('created_at', $today)->where('status', 'completed');
            })->sum('quantity'),
        ];
    }
}
