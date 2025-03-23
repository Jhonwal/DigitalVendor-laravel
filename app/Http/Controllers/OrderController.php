<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display the checkout page.
     */
    public function checkout()
    {
        // Get cart items
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        
        $total = $this->calculateCartTotal($cartItems);
        
        return view('orders.checkout', compact('cartItems', 'total'));
    }

    /**
     * Process the order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'payment_method' => 'required|in:stripe,paypal',
        ]);
        
        // Get cart items
        $cartItems = $this->getCartItems();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        
        $total = $this->calculateCartTotal($cartItems);
        
        // Create order
        $order = Order::create([
            'user_id' => Auth::id() ?? 1, // Default to admin user if guest
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'total_amount' => $total,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
            'customer_email' => $request->email,
        ]);
        
        // Create order items from cart items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
                'download_token' => Str::uuid()->toString(),
            ]);
        }
        
        // Clear the cart
        $this->clearCart();
        
        // For demo purposes, we'll mark the order as paid immediately
        // In a real application, you would process payment and update order status after payment completion
        $order->status = 'paid';
        $order->payment_id = 'demo_' . Str::random(10);
        $order->save();
        
        return redirect()->route('orders.confirmation', $order->order_number)
            ->with('success', 'Order placed successfully.');
    }

    /**
     * Display the order confirmation page.
     */
    public function confirmation($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('orderItems.product')
            ->firstOrFail();
        
        return view('orders.confirmation', compact('order'));
    }

    /**
     * Display the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }

    /**
     * Display a specific order.
     */
    public function show($orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->where('user_id', Auth::id())
            ->with('orderItems.product')
            ->firstOrFail();
        
        return view('orders.show', compact('order'));
    }

    /**
     * Download a purchased product.
     */
    public function download($orderNumber, $downloadToken)
    {
        $orderItem = OrderItem::where('download_token', $downloadToken)
            ->whereHas('order', function($query) use ($orderNumber) {
                $query->where('order_number', $orderNumber)
                    ->where('status', 'paid');
            })
            ->firstOrFail();
        
        $product = Product::findOrFail($orderItem->product_id);
        
        if (!$product->file_path) {
            abort(404);
        }
        
        return response()->download(storage_path('app/private/' . $product->file_path));
    }

    /**
     * Get cart items for the current user or session.
     */
    private function getCartItems()
    {
        if (Auth::id()) {
            return CartItem::where('user_id', Auth::id())
                ->with('product')
                ->get();
        } else {
            return CartItem::where('session_id', session('cart_session_id'))
                ->with('product')
                ->get();
        }
    }

    /**
     * Calculate the total price of all items in the cart.
     */
    private function calculateCartTotal($cartItems)
    {
        $total = 0;
        
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }
        
        return $total;
    }

    /**
     * Clear the user's cart.
     */
    private function clearCart()
    {
        if (Auth::id()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', session('cart_session_id'))->delete();
        }
    }
}