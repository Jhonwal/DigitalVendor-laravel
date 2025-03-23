<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with orders and products.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get recent orders
        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Get user's products (for sellers)
        $products = Product::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();
        
        // Calculate total sales and earnings (for sellers)
        $totalSales = 0;
        $totalEarnings = 0;
        
        $userProducts = Product::where('user_id', $user->id)->pluck('id');
        
        if ($userProducts->count() > 0) {
            $totalSales = Order::whereHas('orderItems', function($query) use ($userProducts) {
                $query->whereIn('product_id', $userProducts);
            })->count();
            
            $totalEarnings = \DB::table('order_items')
                ->whereIn('product_id', $userProducts)
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'paid')
                ->sum(\DB::raw('order_items.price * order_items.quantity'));
        }
        
        return view('dashboard', compact(
            'recentOrders',
            'products',
            'totalSales',
            'totalEarnings'
        ));
    }
}