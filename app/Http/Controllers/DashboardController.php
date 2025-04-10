<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard with orders and products.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get recent orders using query builder instead of Eloquent methods
        $recentOrders = DB::table('orders')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get user's products using query builder
        $products = DB::table('products')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Calculate total sales and earnings (for sellers)
        $totalSales = 0;
        $totalEarnings = 0;
        
        $userProducts = DB::table('products')
            ->where('user_id', $user->id)
            ->pluck('id');
        
        if (count($userProducts) > 0) {
            $totalSales = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->whereIn('order_items.product_id', $userProducts)
                ->distinct('orders.id')
                ->count('orders.id');
            
            $totalEarnings = DB::table('order_items')
                ->whereIn('product_id', $userProducts)
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.status', 'paid')
                ->sum(DB::raw('order_items.price * order_items.quantity'));
        }
        
        return view('dashboard', compact(
            'recentOrders',
            'products',
            'totalSales',
            'totalEarnings'
        ));
    }
}