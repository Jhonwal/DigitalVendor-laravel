@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container py-5">
        <!-- Breadcrumb Navigation -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
                @if($product->category)
                    <li class="breadcrumb-item"><a href="{{ route('products.category', $product->category->slug) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                @endif
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <!-- Product Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-lg mb-4 shadow-sm" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <strong>{{ session('success') }}</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Product Image Gallery -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm rounded-lg overflow-hidden">
                    <div class="product-gallery">
                        <!-- Main Product Image -->
                        <div class="main-image position-relative">
                            <img src="{{ $product->thumbnailUrl }}" class="img-fluid w-100" alt="{{ $product->name }}" id="mainProductImage" style="height: 400px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">
                                <button type="button" class="btn btn-light rounded-circle shadow-sm" data-bs-toggle="modal" data-bs-target="#imageModal" title="Zoom">
                                    <i class="bi bi-zoom-in"></i>
                                </button>
                                <button type="button" class="btn btn-light rounded-circle shadow-sm" title="Share">
                                    <i class="bi bi-share"></i>
                                </button>
                            </div>
                            <div class="position-absolute bottom-0 start-0 p-3">
                                <span class="badge bg-primary rounded-pill px-3 py-2 shadow">{{ $product->formattedPrice() }}</span>
                            </div>
                        </div>
                        
                        <!-- Thumbnail Navigation (if there are preview images) -->
                        <div class="thumbnail-nav d-flex mt-3 gap-2 justify-content-center">
                            <div class="thumb-item active" data-img="{{ $product->thumbnailUrl }}">
                                <img src="{{ $product->thumbnailUrl }}" class="img-fluid rounded" alt="{{ $product->name }}" style="height: 70px; width: 70px; object-fit: cover; cursor: pointer;">
                            </div>
                            <!-- For demo purposes only, in real implementation you would loop through preview images -->
                            <div class="thumb-item" data-img="{{ $product->thumbnailUrl }}">
                                <img src="{{ $product->thumbnailUrl }}" class="img-fluid rounded" alt="{{ $product->name }}" style="height: 70px; width: 70px; object-fit: cover; cursor: pointer; filter: brightness(0.8);">
                            </div>
                            <div class="thumb-item" data-img="{{ $product->thumbnailUrl }}">
                                <img src="{{ $product->thumbnailUrl }}" class="img-fluid rounded" alt="{{ $product->name }}" style="height: 70px; width: 70px; object-fit: cover; cursor: pointer; filter: brightness(0.8);">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Mobile Action Button (Visible only on mobile) -->
                <div class="d-block d-lg-none mt-4">
                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg shadow">
                                <i class="bi bi-cart-plus me-2"></i> Add to Cart - {{ $product->formattedPrice() }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm rounded-lg h-100">
                    <div class="card-body p-4">
                        <div class="mb-3 d-flex justify-content-between align-items-start">
                            <div>
                                @if($product->category)
                                    <a href="{{ route('products.category', $product->category->slug) }}" class="text-decoration-none">
                                        <span class="badge bg-light text-primary mb-2">{{ $product->category->name }}</span>
                                    </a>
                                @endif
                                <h1 class="product-title display-6 fw-bold mb-0">{{ $product->name }}</h1>
                            </div>
                            <div class="product-status">
                                @if($product->status == 'published')
                                    <span class="badge bg-success">Published</span>
                                @elseif($product->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending Review</span>
                                @else
                                    <span class="badge bg-danger">Not Available</span>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex align-items-center mb-4">
                            <div class="me-auto">
                                @if($product->user)
                                    <div class="d-flex align-items-center">
                                        <div class="seller-avatar me-2">
                                            <!-- You can add a proper avatar in production -->
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <span>{{ substr($product->user->name, 0, 1) }}</span>
                                            </div>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted">By <a href="#" class="text-decoration-none fw-medium">{{ $product->user->name }}</a></p>
                                            <div class="seller-rating">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-half text-warning"></i>
                                                <span class="text-muted small ms-1">({{ $product->sales_count ?? 0 }} sales)</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <h2 class="product-price text-primary fw-bold mb-0">{{ $product->formattedPrice() }}</h2>
                        </div>

                        <div class="product-description mb-4 pb-3 border-bottom">
                            <h5 class="fw-bold mb-3">About this product</h5>
                            <div class="description-content">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>

                        <!-- Product Features -->
                        <div class="product-features mb-4 pb-3 border-bottom">
                            <h5 class="fw-bold mb-3">Features</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> 
                                    Instant digital download after purchase
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> 
                                    Full documentation included
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> 
                                    Regular updates and improvements
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i> 
                                    6 months of support included
                                </li>
                            </ul>
                        </div>

                        <!-- Desktop Add to Cart Form (Hidden on mobile) -->
                        <div class="d-none d-lg-block">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mb-4">
                                @csrf
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="bi bi-cart-plus me-2"></i> Add to Cart
                                    </button>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('products.index') }}" class="btn btn-outline-secondary flex-grow-1">
                                            <i class="bi bi-arrow-left me-2"></i> Continue Shopping
                                        </a>
                                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary flex-grow-1">
                                            <i class="bi bi-cart me-2"></i> View Cart
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Product Information Cards -->
                        <div class="row row-cols-2 g-3 mt-2">
                            <div class="col">
                                <div class="card h-100 border-0 bg-light rounded-lg">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-file-earmark-arrow-down text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Digital Product</h6>
                                        <small class="text-muted">Instant download</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light rounded-lg">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-shield-check text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Secure Payment</h6>
                                        <small class="text-muted">SSL encryption</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light rounded-lg">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-credit-card text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Payment Options</h6>
                                        <small class="text-muted">Credit card, PayPal</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="card h-100 border-0 bg-light rounded-lg">
                                    <div class="card-body p-3 text-center">
                                        <i class="bi bi-headset text-primary fs-3 mb-2"></i>
                                        <h6 class="mb-0 fw-bold">Support</h6>
                                        <small class="text-muted">24/7 available</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Tabs (Description, Reviews, etc.) -->
        <div class="card border-0 shadow-sm rounded-lg mb-5">
            <div class="card-header bg-white border-bottom-0 py-3">
                <ul class="nav nav-tabs card-header-tabs" id="productTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-medium" id="description-tab" data-bs-toggle="tab" data-bs-target="#description" type="button" role="tab" aria-controls="description" aria-selected="true">
                            Detailed Description
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-medium" id="specifications-tab" data-bs-toggle="tab" data-bs-target="#specifications" type="button" role="tab" aria-controls="specifications" aria-selected="false">
                            Specifications
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-medium" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab" aria-controls="reviews" aria-selected="false">
                            Reviews
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body p-4">
                <div class="tab-content" id="productTabContent">
                    <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <h4 class="mb-4">About {{ $product->name }}</h4>
                        <div class="row">
                            <div class="col-md-8">
                                <p class="lead">{{ $product->description }}</p>
                                <p>This premium digital product is designed to help you achieve professional results with minimal effort. Whether you're a beginner or experienced professional, you'll find this product intuitive and powerful.</p>
                                <p>After purchasing, you'll receive instant access to download all included files and detailed documentation to get started right away.</p>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0 rounded-lg">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">What's Included</h5>
                                        <ul class="list-group list-group-flush bg-transparent">
                                            <li class="list-group-item bg-transparent border-0 px-0 py-2">
                                                <i class="bi bi-file-earmark-zip me-2 text-primary"></i> Main download package
                                            </li>
                                            <li class="list-group-item bg-transparent border-0 px-0 py-2">
                                                <i class="bi bi-file-earmark-text me-2 text-primary"></i> Documentation PDF
                                            </li>
                                            <li class="list-group-item bg-transparent border-0 px-0 py-2">
                                                <i class="bi bi-file-earmark-code me-2 text-primary"></i> Source files
                                            </li>
                                            <li class="list-group-item bg-transparent border-0 px-0 py-2">
                                                <i class="bi bi-file-earmark-ruled me-2 text-primary"></i> License certificate
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="specifications" role="tabpanel" aria-labelledby="specifications-tab">
                        <h4 class="mb-4">Technical Details</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th scope="row" width="30%">File format</th>
                                        <td>ZIP</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Last updated</th>
                                        <td>{{ $product->updated_at->format('F j, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Created by</th>
                                        <td>{{ $product->user->name ?? 'Unknown' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Category</th>
                                        <td>{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Compatible with</th>
                                        <td>Multiple platforms</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">License type</th>
                                        <td>Standard license</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="mb-0">Customer Reviews</h4>
                            <button class="btn btn-primary" type="button">
                                <i class="bi bi-star me-2"></i> Write a Review
                            </button>
                        </div>
                        <div class="review-summary mb-4">
                            <div class="row align-items-center">
                                <div class="col-md-3 text-center">
                                    <div class="display-3 fw-bold text-primary">4.5</div>
                                    <div class="rating-stars mb-2">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-half text-warning"></i>
                                    </div>
                                    <div class="text-muted">Based on 24 reviews</div>
                                </div>
                                <div class="col-md-9">
                                    <div class="rating-bars">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-label me-2">5 <i class="bi bi-star-fill text-warning small"></i></div>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 65%;" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="rating-count ms-2">16</div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-label me-2">4 <i class="bi bi-star-fill text-warning small"></i></div>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="rating-count ms-2">6</div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-label me-2">3 <i class="bi bi-star-fill text-warning small"></i></div>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-warning" role="progressbar" style="width: 5%;" aria-valuenow="5" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="rating-count ms-2">1</div>
                                        </div>
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="rating-label me-2">2 <i class="bi bi-star-fill text-warning small"></i></div>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 4%;" aria-valuenow="4" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="rating-count ms-2">1</div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="rating-label me-2">1 <i class="bi bi-star-fill text-warning small"></i></div>
                                            <div class="progress flex-grow-1" style="height: 10px;">
                                                <div class="progress-bar bg-danger" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <div class="rating-count ms-2">0</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sample Reviews - In production, this would be dynamically generated -->
                        <div class="reviews-list">
                            <div class="card border-0 shadow-sm rounded-lg mb-3">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar bg-primary rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <span>JD</span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <div class="d-flex align-items-center mb-1">
                                                <h5 class="card-title mb-0 me-auto">John Doe</h5>
                                                <small class="text-muted">3 days ago</small>
                                            </div>
                                            <div class="rating-stars mb-2">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                            </div>
                                            <p class="card-text">Excellent product, exceeded my expectations! Very easy to use and the documentation is comprehensive.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card border-0 shadow-sm rounded-lg">
                                <div class="card-body">
                                    <div class="d-flex mb-3">
                                        <div class="flex-shrink-0">
                                            <div class="avatar bg-success rounded-circle text-white d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                                <span>AS</span>
                                            </div>
                                        </div>
                                        <div class="ms-3">
                                            <div class="d-flex align-items-center mb-1">
                                                <h5 class="card-title mb-0 me-auto">Alice Smith</h5>
                                                <small class="text-muted">1 week ago</small>
                                            </div>
                                            <div class="rating-stars mb-2">
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star-fill text-warning"></i>
                                                <i class="bi bi-star text-warning"></i>
                                            </div>
                                            <p class="card-text">Great value for money. Would definitely recommend to others looking for a similar solution.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && $relatedProducts->count() > 0)
            <h3 class="mb-4">You May Also Like</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4 mb-5">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm rounded-lg product-card">
                            <div class="position-relative">
                                <img src="{{ $relatedProduct->thumbnailUrl }}" class="card-img-top" alt="{{ $relatedProduct->name }}"
                                     style="height: 180px; object-fit: cover;">
                                <div class="position-absolute top-0 end-0 p-2">
                                    <span class="badge bg-primary rounded-pill px-3 py-2 shadow-sm">
                                        {{ $relatedProduct->formattedPrice() }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body p-3">
                                <h5 class="card-title mb-2">{{ Str::limit($relatedProduct->name, 40) }}</h5>
                                <p class="card-text text-muted small mb-3">{{ Str::limit($relatedProduct->description, 80) }}</p>
                                <div class="d-grid">
                                    <a href="{{ route('products.show', $relatedProduct->slug) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye me-2"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Call to Action Section -->
        <div class="card border-0 bg-gradient-primary text-white shadow-lg rounded-lg mb-5">
            <div class="card-body p-5 text-center">
                <h2 class="display-6 fw-bold mb-3">Ready to Sell Your Digital Products?</h2>
                <p class="lead mb-4">Join our marketplace today and reach customers around the world. No setup fees, just a simple commission structure.</p>
                <div class="d-flex justify-content-center gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg px-5">
                            <i class="bi bi-person-plus me-2"></i> Register as a Seller
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
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

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="imageModalLabel">{{ $product->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ $product->thumbnailUrl }}" class="img-fluid" alt="{{ $product->name }}" style="max-height: 70vh;">
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
    
    /* Thumbnail navigation */
    .thumb-item {
        opacity: 0.7;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }
    
    .thumb-item.active, .thumb-item:hover {
        opacity: 1;
        border-color: var(--bs-primary);
    }
    
    /* Tabs styling */
    .nav-tabs .nav-link {
        color: #495057;
        border: none;
        border-bottom: 2px solid transparent;
        padding: 0.75rem 1rem;
        margin-right: 0.5rem;
        border-radius: 0;
    }
    
    .nav-tabs .nav-link:hover {
        border-color: transparent;
        color: var(--bs-primary);
    }
    
    .nav-tabs .nav-link.active {
        color: var(--bs-primary);
        border-bottom: 2px solid var(--bs-primary);
        background-color: transparent;
    }
    
    /* Background gradient utility */
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--bs-primary) 0%, #4a6bdb 100%);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Thumbnail navigation
        const thumbItems = document.querySelectorAll('.thumb-item');
        const mainImage = document.getElementById('mainProductImage');
        
        thumbItems.forEach(item => {
            item.addEventListener('click', function() {
                // Update main image
                mainImage.src = this.getAttribute('data-img');
                
                // Update active state
                thumbItems.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endsection