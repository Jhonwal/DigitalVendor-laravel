@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
    <div class="container">
        <h1 class="mb-4">Shopping Cart</h1>

        @if($cartItems->count() > 0)
            <div class="row">
                <!-- Cart Items -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">Cart Items ({{ $cartItems->count() }})</h5>
                                <form action="{{ route('cart.clear') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" 
                                            onclick="return confirm('Are you sure you want to empty your cart?')">
                                        <i class="bi bi-trash me-1"></i> Empty Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" width="50%">Product</th>
                                            <th scope="col" class="text-center">Price</th>
                                            <th scope="col" class="text-center">Quantity</th>
                                            <th scope="col" class="text-center">Subtotal</th>
                                            <th scope="col" class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($cartItems as $item)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $item->product->thumbnailUrl }}" alt="{{ $item->product->name }}" 
                                                             class="me-3" width="60" height="60" style="object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0">
                                                                <a href="{{ route('products.show', $item->product->slug) }}" 
                                                                   class="text-decoration-none text-dark">
                                                                    {{ $item->product->name }}
                                                                </a>
                                                            </h6>
                                                            <small class="text-muted">{{ $item->product->category->name }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center align-middle">{{ $item->product->formattedPrice() }}</td>
                                                <td class="text-center align-middle">
                                                    <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="input-group input-group-sm" style="width: 100px; margin: 0 auto;">
                                                            <button class="btn btn-outline-secondary" type="button" 
                                                                    onclick="if(this.nextElementSibling.value > 1) this.nextElementSibling.value--; this.form.submit();">
                                                                <i class="bi bi-dash"></i>
                                                            </button>
                                                            <input type="number" class="form-control text-center" name="quantity" 
                                                                   value="{{ $item->quantity }}" min="1" max="99"
                                                                   onchange="this.form.submit()">
                                                            <button class="btn btn-outline-secondary" type="button" 
                                                                    onclick="this.previousElementSibling.value++; this.form.submit();">
                                                                <i class="bi bi-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td class="text-center align-middle fw-bold">{{ $item->formattedSubtotal() }}</td>
                                                <td class="text-center align-middle">
                                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Order Summary</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <span>${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tax:</span>
                                <span>$0.00</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <span class="fw-bold">Total:</span>
                                <span class="fw-bold text-primary fs-5">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="d-grid">
                                <a href="{{ route('orders.checkout') }}" class="btn btn-primary">
                                    Proceed to Checkout
                                </a>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary mt-2">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Accepted Payment Methods -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">We Accept</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-3">
                                    <i class="bi bi-credit-card fs-2 text-primary"></i>
                                    <div class="small mt-1">Credit Card</div>
                                </div>
                                <div class="col-3">
                                    <i class="bi bi-paypal fs-2 text-primary"></i>
                                    <div class="small mt-1">PayPal</div>
                                </div>
                                <div class="col-3">
                                    <i class="bi bi-stripe fs-2 text-primary"></i>
                                    <div class="small mt-1">Stripe</div>
                                </div>
                                <div class="col-3">
                                    <i class="bi bi-bank fs-2 text-primary"></i>
                                    <div class="small mt-1">Bank Transfer</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5">
                <div class="display-1 text-muted mb-4">
                    <i class="bi bi-cart"></i>
                </div>
                <h2 class="mb-3">Your cart is empty</h2>
                <p class="text-muted mb-4">Looks like you haven't added any products to your cart yet.</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    Start Shopping
                </a>
            </div>
        @endif

        <!-- You May Also Like Section -->
        <div class="card border-0 shadow-sm my-5">
            <div class="card-header bg-white">
                <h5 class="mb-0">You May Also Like</h5>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @php
                        $recommendedProducts = \App\Models\Product::where('status', 'published')
                            ->inRandomOrder()
                            ->take(4)
                            ->get();
                    @endphp
                    @foreach($recommendedProducts as $product)
                        <div class="col">
                            <div class="card h-100 border-0 shadow-sm">
                                <img src="{{ $product->thumbnailUrl }}" class="card-img-top" alt="{{ $product->name }}" 
                                     style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h5 class="card-title">{{ Str::limit($product->name, 30) }}</h5>
                                    <p class="card-text text-muted mb-2">{{ Str::limit($product->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold">{{ $product->formattedPrice() }}</span>
                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection