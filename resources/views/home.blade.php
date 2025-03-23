@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <!-- Hero Section -->
    <section class="py-5 text-center container">
        <div class="row py-lg-5">
            <div class="col-lg-8 col-md-10 mx-auto">
                <h1 class="fw-bold">Digital Marketplace</h1>
                <p class="lead text-muted">
                    Discover, buy, and sell digital products. From software and e-books to templates and creative assets, 
                    find everything you need for your digital life.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('products.index') }}" class="btn btn-primary">Browse Products</a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary">Start Selling</a>
                    @else
                        <a href="{{ route('products.create') }}" class="btn btn-outline-secondary">Start Selling</a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <h2 class="mb-4">Featured Products</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                @foreach($featuredProducts as $product)
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <img src="{{ $product->thumbnailUrl }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-primary rounded-pill">{{ $product->category->name }}</span>
                                    <span class="fw-bold">{{ $product->formattedPrice() }}</span>
                                </div>
                            </div>
                            <div class="card-footer bg-transparent d-flex justify-content-between">
                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">View Details</a>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-4">
                <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="mb-4">Shop by Category</h2>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @foreach($categories as $category)
                    <div class="col">
                        <a href="{{ route('products.category', $category->slug) }}" class="text-decoration-none">
                            <div class="card h-100 bg-dark text-white">
                                @if($category->image)
                                    <img src="{{ $category->imageUrl }}" class="card-img opacity-50" alt="{{ $category->name }}">
                                @endif
                                <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                                    <h3 class="card-title fw-bold">{{ $category->name }}</h3>
                                    <p class="card-text">{{ $category->products_count }} Products</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Seller Section -->
    <section class="py-5 bg-primary text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="fw-bold">Start Selling Your Digital Products Today</h2>
                    <p class="lead">Join our marketplace and reach customers worldwide. No setup fees, just a simple commission structure.</p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Easy product uploads</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Secure payment processing</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Automatic file delivery</li>
                        <li class="mb-2"><i class="bi bi-check-circle-fill me-2"></i> Sales analytics</li>
                    </ul>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Register as a Seller</a>
                    @else
                        <a href="{{ route('products.create') }}" class="btn btn-light btn-lg">Upload Your First Product</a>
                    @endguest
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <img src="{{ asset('images/seller-illustration.svg') }}" alt="Seller Illustration" class="img-fluid">
                </div>
            </div>
        </div>
    </section>
@endsection