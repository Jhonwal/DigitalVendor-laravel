@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="container">
        <h1 class="mb-4">Dashboard</h1>
        
        <div class="row g-4 mb-5">
            <!-- Dashboard Cards -->
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-primary bg-opacity-10 p-3 rounded me-3">
                                <i class="bi bi-bag fs-4 text-primary"></i>
                            </div>
                            <h5 class="card-title mb-0">Orders</h5>
                        </div>
                        <h3 class="mb-0">{{ $recentOrders->count() }}</h3>
                        <p class="text-muted small">Your recent orders</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary w-100">View All Orders</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-success bg-opacity-10 p-3 rounded me-3">
                                <i class="bi bi-grid fs-4 text-success"></i>
                            </div>
                            <h5 class="card-title mb-0">Products</h5>
                        </div>
                        <h3 class="mb-0">{{ $products->count() }}</h3>
                        <p class="text-muted small">Products you're selling</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-success w-100">Manage Products</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-info bg-opacity-10 p-3 rounded me-3">
                                <i class="bi bi-cart-check fs-4 text-info"></i>
                            </div>
                            <h5 class="card-title mb-0">Sales</h5>
                        </div>
                        <h3 class="mb-0">{{ $totalSales }}</h3>
                        <p class="text-muted small">Total products sold</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-info w-100">View Analytics</a>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-warning bg-opacity-10 p-3 rounded me-3">
                                <i class="bi bi-currency-dollar fs-4 text-warning"></i>
                            </div>
                            <h5 class="card-title mb-0">Earnings</h5>
                        </div>
                        <h3 class="mb-0">${{ number_format($totalEarnings, 2) }}</h3>
                        <p class="text-muted small">Total earnings</p>
                    </div>
                    <div class="card-footer bg-transparent border-0">
                        <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-warning w-100">View Earnings</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Recent Orders -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Orders</h5>
                            <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Order #</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentOrders as $order)
                                        <tr>
                                            <td>
                                                <a href="{{ route('orders.show', $order->order_number) }}" class="text-decoration-none">
                                                    {{ $order->order_number }}
                                                </a>
                                            </td>
                                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                                            <td>{{ $order->formattedTotal() }}</td>
                                            <td>{!! $order->statusBadge !!}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3">No orders found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Your Products -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Your Products</h5>
                            <div>
                                <a href="{{ route('products.create') }}" class="btn btn-sm btn-success me-2">
                                    <i class="bi bi-plus-circle me-1"></i> Add New
                                </a>
                                <a href="{{ route('user.products') }}" class="btn btn-sm btn-outline-primary">View All</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Product</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $product->thumbnailUrl }}" alt="{{ $product->name }}" 
                                                         class="me-2" width="40" height="40" style="object-fit: cover;">
                                                    <div>
                                                        {{ Str::limit($product->name, 30) }}
                                                        <div class="small text-muted">{{ $product->category->name }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $product->formattedPrice() }}</td>
                                            <td>
                                                @if($product->status == 'published')
                                                    <span class="badge bg-success">Published</span>
                                                @elseif($product->status == 'pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @else
                                                    <span class="badge bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-secondary">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    @if($product->status == 'published')
                                                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3">
                                                No products found. 
                                                <a href="{{ route('products.create') }}">Add your first product</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions Section -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <div class="col">
                        <a href="{{ route('products.create') }}" class="card h-100 border-0 bg-light text-center p-4 text-decoration-none">
                            <div class="card-body">
                                <i class="bi bi-upload fs-1 text-primary mb-3"></i>
                                <h5 class="card-title">Upload Product</h5>
                                <p class="card-text text-muted">Add a new digital product to your store</p>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('products.index') }}" class="card h-100 border-0 bg-light text-center p-4 text-decoration-none">
                            <div class="card-body">
                                <i class="bi bi-shop fs-1 text-success mb-3"></i>
                                <h5 class="card-title">Browse Marketplace</h5>
                                <p class="card-text text-muted">Discover new digital products</p>
                            </div>
                        </a>
                    </div>
                    <div class="col">
                        <a href="{{ route('cart.index') }}" class="card h-100 border-0 bg-light text-center p-4 text-decoration-none">
                            <div class="card-body">
                                <i class="bi bi-cart3 fs-1 text-info mb-3"></i>
                                <h5 class="card-title">View Cart</h5>
                                <p class="card-text text-muted">See items in your shopping cart</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection