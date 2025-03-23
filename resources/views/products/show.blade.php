@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug) }}">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Image -->
            <div class="col-md-5 mb-4">
                <div class="card border-0 shadow-sm">
                    <img src="{{ $product->thumbnailUrl }}" class="card-img-top img-fluid" alt="{{ $product->name }}">
                    <div class="card-body text-center py-4">
                        <a href="#" class="btn btn-outline-secondary">
                            <i class="bi bi-zoom-in me-2"></i> View Full Image
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-md-7 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h1 class="card-title mb-2">{{ $product->name }}</h1>
                        <div class="mb-3">
                            <span class="badge bg-primary rounded-pill me-2">{{ $product->category->name }}</span>
                            <span class="text-muted">By {{ $product->user->name }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center mb-4">
                            <h3 class="text-primary mb-0 me-3">{{ $product->formattedPrice() }}</h3>
                        </div>

                        <hr>

                        <h5 class="mb-3">Description</h5>
                        <div class="mb-4">
                            {!! nl2br(e($product->description)) !!}
                        </div>
                        
                        <hr>

                        <!-- Add to Cart Form -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-3">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                </button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-cart me-2"></i> View Cart
                                </a>
                            </div>
                        </form>

                        <!-- Product Information -->
                        <div class="row row-cols-2 g-3 text-center">
                            <div class="col">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body py-3">
                                        <i class="bi bi-file-earmark-arrow-down text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0">Digital Product</h6>
                                        <small class="text-muted">Instant download after purchase</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body py-3">
                                        <i class="bi bi-shield-check text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0">Secure Payment</h6>
                                        <small class="text-muted">SSL encrypted checkout</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body py-3">
                                        <i class="bi bi-credit-card text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0">Multiple Payment Options</h6>
                                        <small class="text-muted">Credit card, PayPal</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light">
                                    <div class="card-body py-3">
                                        <i class="bi bi-headset text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0">Customer Support</h6>
                                        <small class="text-muted">24/7 support available</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if($relatedProducts->count() > 0)
            <div class="card border-0 shadow-sm mb-5">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Related Products</h5>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                        @foreach($relatedProducts as $relatedProduct)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="{{ $relatedProduct->thumbnailUrl }}" class="card-img-top" alt="{{ $relatedProduct->name }}"
                                         style="height: 150px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ Str::limit($relatedProduct->name, 30) }}</h5>
                                        <p class="card-text text-muted">{{ Str::limit($relatedProduct->description, 60) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold">{{ $relatedProduct->formattedPrice() }}</span>
                                            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-sm btn-outline-primary">
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
        @endif

        <!-- Call to Action Section -->
        <div class="card bg-primary text-white border-0 mb-5">
            <div class="card-body p-5 text-center">
                <h2 class="mb-3">Ready to Sell Your Digital Products?</h2>
                <p class="lead mb-4">Join our marketplace today and reach customers around the world. No setup fees, just a simple commission structure.</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">Register as a Seller</a>
                @else
                    <a href="{{ route('products.create') }}" class="btn btn-light btn-lg px-5">Start Selling Now</a>
                @endguest
            </div>
        </div>
    </div>
@endsection