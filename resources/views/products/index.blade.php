@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <div class="container">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">Filters</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('products.index') }}" method="GET">
                            <!-- Category Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Categories</h6>
                                @foreach($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="category" 
                                               id="category-{{ $category->id }}" value="{{ $category->id }}"
                                               {{ request('category') == $category->id ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-{{ $category->id }}">
                                            {{ $category->name }} ({{ $category->products_count }})
                                        </label>
                                    </div>
                                @endforeach
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="category" 
                                           id="category-all" value=""
                                           {{ request('category') == '' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="category-all">
                                        All Categories
                                    </label>
                                </div>
                            </div>

                            <!-- Price Range Filter -->
                            <div class="mb-4">
                                <h6 class="fw-bold mb-3">Price Range</h6>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="min_price" placeholder="Min" 
                                                   value="{{ request('min_price') }}" min="0">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text">$</span>
                                            <input type="number" class="form-control" name="max_price" placeholder="Max" 
                                                   value="{{ request('max_price') }}" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
                            @if(request('category') || request('min_price') || request('max_price'))
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary w-100 mt-2">
                                    Clear Filters
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>All Products</h1>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="sortDropdown" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                            Sort By
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="sortDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'newest'] + request()->except('sort', 'page')) }}">
                                    Newest
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price-low-high'] + request()->except('sort', 'page')) }}">
                                    Price: Low to High
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('products.index', ['sort' => 'price-high-low'] + request()->except('sort', 'page')) }}">
                                    Price: High to Low
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                @if($products->count() > 0)
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
                        @foreach($products as $product)
                            <div class="col">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="{{ $product->thumbnailUrl }}" class="card-img-top" alt="{{ $product->name }}"
                                         style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h5 class="card-title mb-0">{{ Str::limit($product->name, 40) }}</h5>
                                            <span class="badge bg-primary rounded-pill">{{ $product->category->name }}</span>
                                        </div>
                                        <p class="card-text text-muted mb-3">{{ Str::limit($product->description, 100) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="fw-bold fs-5">{{ $product->formattedPrice() }}</span>
                                            <div>
                                                <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">Details</a>
                                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-primary">
                                                        <i class="bi bi-cart-plus"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $products->appends(request()->except('page'))->links() }}
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i> No products found matching your criteria.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection