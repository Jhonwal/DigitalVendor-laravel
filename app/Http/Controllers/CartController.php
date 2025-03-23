<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display the user's cart.
     */
    public function index()
    {
        $cartItems = $this->getCartItems();
        $total = $this->calculateCartTotal($cartItems);
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function addToCart(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        
        // Get the user ID or generate a session ID for guests
        $userId = Auth::id();
        $sessionId = $userId ? null : $this->getSessionId();
        
        // Check if product is already in cart
        $cartItem = CartItem::where('product_id', $product->id)
            ->where(function ($query) use ($userId, $sessionId) {
                if ($userId) {
                    $query->where('user_id', $userId);
                } else {
                    $query->where('session_id', $sessionId);
                }
            })->first();
        
        if ($cartItem) {
            // Update quantity if product is already in cart
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            // Create a new cart item
            CartItem::create([
                'user_id' => $userId,
                'product_id' => $product->id,
                'quantity' => 1,
                'session_id' => $sessionId,
            ]);
        }
        
        return redirect()->back()->with('success', 'Product added to cart.');
    }

    /**
     * Update cart item quantity.
     */
    public function updateQuantity(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);
        
        $cartItem = CartItem::findOrFail($cartItemId);
        
        // Verify cart item belongs to the user
        if (Auth::id() && $cartItem->user_id != Auth::id()) {
            abort(403);
        }
        
        if (!Auth::id() && $cartItem->session_id != $this->getSessionId()) {
            abort(403);
        }
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    /**
     * Remove a cart item.
     */
    public function removeItem($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        
        // Verify cart item belongs to the user
        if (Auth::id() && $cartItem->user_id != Auth::id()) {
            abort(403);
        }
        
        if (!Auth::id() && $cartItem->session_id != $this->getSessionId()) {
            abort(403);
        }
        
        $cartItem->delete();
        
        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart.');
    }

    /**
     * Clear all items from the cart.
     */
    public function clearCart()
    {
        if (Auth::id()) {
            CartItem::where('user_id', Auth::id())->delete();
        } else {
            CartItem::where('session_id', $this->getSessionId())->delete();
        }
        
        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully.');
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
            return CartItem::where('session_id', $this->getSessionId())
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
     * Get or create a session ID for guest users.
     */
    private function getSessionId()
    {
        if (!session()->has('cart_session_id')) {
            session(['cart_session_id' => Str::uuid()->toString()]);
        }
        
        return session('cart_session_id');
    }
}