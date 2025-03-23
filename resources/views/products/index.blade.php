@extends('layouts.app')

@section('title', 'Digital Products Marketplace')

@section('content')
<div class="container py-5">
    <!-- Hero Banner -->
    <div class="card border-0 bg-gradient-primary text-white shadow-lg rounded-lg mb-5">
        <div class="card-body p-5">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 fw-bold mb-3">Find Premium Digital Products</h1>
                    <p class="lead mb-4">Discover high-quality digital products created by talented designers and developers around the world.</p>
                    <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                        <input type="text" name="query" class="form-control form-control-lg" placeholder="Search for templates, software, e-books..." aria-label="Search">
                        <button type="submit" class="btn btn-light btn-lg ms-2 px-4">
                            <i class="bi bi-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="bi bi-box text-white" style="font-size: 8rem; opacity: 0.8;"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Filters -->
        <div class="col-lg-3 mb-4">
            <div class="card border-0 shadow-sm rounded-lg sticky-top" style="top: 20px; z-index: 1;">
                <div class="card-header bg-white border-0 pt-4 pb-0">
                    <h4 class="mb-0">Shop by</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.index') }}" method="GET">
                        <!-- Category Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-uppercase text-primary">Categories</h6>
                            @foreach($categories as $category)
                                <div class="form-check d-flex align-items-center mb-3">
                                    <input class="form-check-input" type="radio" name="category" 
                                           id="category-{{ $category->id }}" value="{{ $category->id }}"
                                           {{ request('category') == $category->id ? 'checked' : '' }}>
                                    <label class="form-check-label ms-2 d-flex justify-content-between w-100" for="category-{{ $category->id }}">
                                        <span>{{ $category->name }}</span>
                                        <span class="badge bg-light text-dark rounded-pill">{{ $category->products_count ?? 0 }}</span>
                                    </label>
                                </div>
                            @endforeach
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="category" 
                                       id="category-all" value=""
                                       {{ request('category') == '' ? 'checked' : '' }}>
                                <label class="form-check-label ms-2" for="category-all">
                                    All Categories
                                </label>
                            </div>
                        </div>

                        <!-- Price Range Filter -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3 text-uppercase text-primary">Price Range</h6>
                            <div class="range-slider mb-3">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-0">$</span>
                                            <input type="number" class="form-control border-0 bg-light" name="min_price" placeholder="Min" 
                                                   value="{{ request('min_price') }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text bg-light border-0">$</span>
                                            <input type="number" class="form-control border-0 bg-light" name="max_price" placeholder="Max" 
                                                   value="{{ request('max_price') }}" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-funnel-fill me-2"></i> Apply Filters
                            </button>
                            @if(request('category') || request('min_price') || request('max_price'))
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-2"></i> Clear Filters
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="mb-1">All Products</h2>
                    <p class="text-muted mb-0">{{ $products->total() ?? 0 }} products found</p>
                </div>
                <div class="d-flex align-items-center">
                    <div class="btn-group me-2 d-none d-md-flex">
                        <a href="{{ route('products.index', ['view' => 'grid'] + request()->except('view', 'page')) }}" 
                           class="btn btn-sm {{ request('view', 'grid') == 'grid' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-grid-3x3-gap-fill"></i>
                        </a>
                        <a href="{{ route('products.index', ['view' => 'list'] + request()->except('view', 'page')) }}" 
                           class="btn btn-sm {{ request('view') == 'list' ? 'btn-primary' : 'btn-outline-primary' }}">
                            <i class="bi bi-list"></i>
                        </a>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-primary dropdown-toggle" type="button" id="sortDropdown" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-sort-down me-1"></i> Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="sortDropdown">
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'newest' ? 'active' : '' }}" 
                                   href="{{ route('products.index', ['sort' => 'newest'] + request()->except('sort', 'page')) }}">
                                    <i class="bi bi-calendar-date me-2"></i> Newest
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'price-low-high' ? 'active' : '' }}" 
                                   href="{{ route('products.index', ['sort' => 'price-low-high'] + request()->except('sort', 'page')) }}">
                                    <i class="bi bi-sort-numeric-down me-2"></i> Price: Low to High
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'price-high-low' ? 'active' : '' }}" 
                                   href="{{ route('products.index', ['sort' => 'price-high-low'] + request()->except('sort', 'page')) }}">
                                    <i class="bi bi-sort-numeric-up me-2"></i> Price: High to Low
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ request('sort') == 'popularity' ? 'active' : '' }}" 
                                   href="{{ route('products.index', ['sort' => 'popularity'] + request()->except('sort', 'page')) }}">
                                    <i class="bi bi-graph-up me-2"></i> Most Popular
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($products->count() > 0)
                @if(request('view') == 'list')
                    <!-- List View -->
                    <div class="card border-0 shadow-sm rounded-lg overflow-hidden mb-4">
                        <div class="list-group list-group-flush">
                            @foreach($products as $product)
                                <div class="list-group-item p-0">
                                    <div class="row g-0">
                                        <div class="col-md-3">
                                            <img src="{{ $product->thumbnailUrl }}" class="img-fluid rounded-start h-100" alt="{{ $product->name }}" style="object-fit: cover;">
                                        </div>
                                        <div class="col-md-9">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between mb-2">
                                                    <h5 class="card-title mb-0">{{ $product->name }}</h5>
                                                    <span class="badge bg-primary">{{ $product->category->name ?? 'Uncategorized' }}</span>
                                                </div>
                                                <p class="card-text mb-3">{{ Str::limit($product->description, 150) }}</p>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h4 class="text-primary mb-0">{{ $product->formattedPrice() }}</h4>
                                                        <small class="text-muted">{{ $product->sales_count ?? 0 }} sales</small>
                                                    </div>
                                                    <div class="d-flex gap-2">
                                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary">
                                                            <i class="bi bi-eye me-md-2"></i><span class="d-none d-md-inline">Details</span>
                                                        </a>
                                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                            @csrf
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-cart-plus me-md-2"></i><span class="d-none d-md-inline">Add to Cart</span>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <!-- Grid View (Default) -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm rounded-lg product-card">
                                    <div class="position-relative">
                                        <img src="{{ $product->thumbnailUrl }}" class="card-img-top" alt="{{ $product->name }}"
                                             style="height: 200px; object-fit: cover;">
                                        <div class="position-absolute top-0 end-0 p-2">
                                            <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                                {{ $product->formattedPrice() }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="card-body p-4">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h5 class="card-title mb-0 product-title">{{ Str::limit($product->name, 40) }}</h5>
                                        </div>
                                        <p class="text-muted small mb-2">
                                            <i class="bi bi-tag-fill me-1"></i> {{ $product->category->name ?? 'Uncategorized' }}
                                        </p>
                                        <p class="card-text product-description">{{ Str::limit($product->description, 100) }}</p>
                                    </div>
                                    <div class="card-footer bg-white border-0 p-4 pt-0">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-outline-primary">
                                                <i class="bi bi-eye me-2"></i> View Details
                                            </a>
                                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary w-100">
                                                    <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-5">
                    {{ $products->appends(request()->except('page'))->links() }}
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-body p-5 text-center">
                        <div class="py-5">
                            <i class="bi bi-search text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-4">No products found</h3>
                            <p class="text-muted mb-4">We couldn't find any products matching your criteria. Try adjusting your filters or search query.</p>
                            <a href="{{ route('products.index') }}" class="btn btn-primary">
                                <i class="bi bi-arrow-left me-2"></i> View All Products
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Featured Categories -->
            <div class="mt-5 pt-3">
                <h3 class="mb-4">Browse by Category</h3>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
                    @foreach($categories->take(4) as $category)
                        <div class="col">
                            <a href="{{ route('products.category', $category->slug) }}" class="text-decoration-none">
                                <div class="card bg-light border-0 shadow-sm h-100 category-card">
                                    <div class="card-body p-4 text-center">
                                        <div class="icon-wrapper mb-3">
                                            @if($loop->iteration == 1)
                                                <i class="bi bi-laptop text-primary" style="font-size: 2.5rem;"></i>
                                            @elseif($loop->iteration == 2)
                                                <i class="bi bi-book text-primary" style="font-size: 2.5rem;"></i>
                                            @elseif($loop->iteration == 3)
                                                <i class="bi bi-brush text-primary" style="font-size: 2.5rem;"></i>
                                            @else
                                                <i class="bi bi-camera text-primary" style="font-size: 2.5rem;"></i>
                                            @endif
                                        </div>
                                        <h5 class="mb-2">{{ $category->name }}</h5>
                                        <p class="text-muted mb-0">{{ $category->products_count ?? 0 }} products</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Call to Action -->
    <div class="card border-0 bg-gradient-primary text-white shadow-lg rounded-lg mt-5">
        <div class="card-body p-5 text-center">
            <h2 class="display-6 fw-bold mb-3">Ready to Sell Your Digital Products?</h2>
            <p class="lead mb-4">Join our marketplace today and reach customers around the world.</p>
            <div class="d-flex justify-content-center">
                @guest
                    <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5 me-3">
                        <i class="bi bi-person-plus me-2"></i> Register as a Seller
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                        <i class="bi bi-box-arrow-in-right me-2"></i> Login
                    </a>
                @else
                    <a href="{{ route('products.create') }}" class="btn btn-light btn-lg px-5">
                        <i class="bi bi-cloud-upload me-2"></i> Start Selling Now
                    </a>
                @endguest
            </div>
        </div>
    </div>
</div>

<style>
    /* Enhanced product cards */
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }
    
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
    
    .product-card .card-img-top {
        transition: transform 0.5s ease;
    }
    
    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }
    
    .product-title {
        font-weight: 600;
        color: #333;
    }
    
    .product-description {
        font-size: 0.9rem;
        color: #666;
    }
    
    /* Category cards */
    .category-card {
        transition: all 0.3s ease;
    }
    
    .category-card:hover {
        transform: translateY(-5px);
        background: linear-gradient(to bottom right, #f8f9fa, #e9ecef) !important;
    }
    
    .category-card .icon-wrapper {
        height: 80px;
        width: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        background-color: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .category-card:hover .icon-wrapper {
        background-color: rgba(var(--bs-primary-rgb), 0.2);
        transform: scale(1.1);
    }
    
    /* Background gradient utility */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #4a6bdb 100%);
    }
</style>
@endsection