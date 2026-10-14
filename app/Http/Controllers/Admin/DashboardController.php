<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        $revenueToday = Order::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->sum('total');

        $ordersToday = Order::where('status', 'completed')
            ->whereDate('created_at', $today)
            ->count();

        $pendingFeedback = Feedback::where('status', 'pending')->count();

        $topProducts = OrderItem::select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->whereHas('order', function($q) {
                $q->where('status', 'completed');
            })
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('revenueToday', 'ordersToday', 'pendingFeedback', 'topProducts'));
    }
}
