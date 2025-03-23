<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
        <!-- Brand Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <i class="bi bi-box-seam fs-3 me-2"></i>
            <span class="fw-bold">Digital Marketplace</span>
        </a>
        
        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarContent" aria-controls="navbarContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Main Navigation -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" 
                       href="{{ route('home') }}">
                        <i class="bi bi-house me-1"></i> Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link px-3 {{ request()->routeIs('products.*') && !request()->routeIs('products.category') ? 'active fw-bold' : '' }}" 
                       href="{{ route('products.index') }}">
                        <i class="bi bi-grid me-1"></i> Products
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle px-3 {{ request()->routeIs('products.category') ? 'active fw-bold' : '' }}" 
                       href="#" id="categoriesDropdown" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-tags me-1"></i> Categories
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3 py-2" aria-labelledby="categoriesDropdown">
                        @php
                            try {
                                $categories = \App\Models\Category::take(8)->get();
                            } catch (\Exception $e) {
                                $categories = collect();
                            }
                        @endphp
                        
                        @forelse($categories as $category)
                            <li>
                                <a class="dropdown-item py-2 px-3 {{ request()->is('category/'.$category->slug) ? 'active bg-light' : '' }}" 
                                   href="{{ route('products.category', $category->slug) }}">
                                    <i class="bi bi-tag me-2 text-primary"></i> {{ $category->name }}
                                </a>
                            </li>
                        @empty
                            <li>
                                <span class="dropdown-item py-2 px-3 text-muted">
                                    <i class="bi bi-info-circle me-2"></i> No categories found
                                </span>
                            </li>
                        @endforelse
                        
                        @if($categories->count() > 0)
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <a class="dropdown-item py-2 px-3" href="{{ route('products.index') }}">
                                    <i class="bi bi-grid-3x3-gap me-2 text-primary"></i> View All Categories
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                <li class="nav-item d-none d-lg-block">
                    <a class="nav-link px-3" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="bi bi-search me-1"></i> Search
                    </a>
                </li>
            </ul>
            
            <!-- Search Form (visible on mobile) -->
            <form class="d-lg-none mb-3 mt-2" action="{{ route('products.search') }}" method="GET">
                <div class="input-group">
                    <input type="search" class="form-control" name="query" 
                           placeholder="Search products..." aria-label="Search" required>
                    <button class="btn btn-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
            
            <!-- Right Navigation -->
            <ul class="navbar-nav align-items-center">
                <!-- Cart -->
                <li class="nav-item me-2">
                    <a class="nav-link position-relative px-3 py-2" href="{{ route('cart.index') }}"
                       data-bs-toggle="tooltip" data-bs-placement="bottom" title="Shopping Cart">
                        <i class="bi bi-cart fs-5"></i>
                        @php
                            $cartCount = 0;
                            try {
                                if (auth()->check()) {
                                    $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                                } else {
                                    $cartCount = \App\Models\CartItem::where('session_id', session()->getId())->sum('quantity');
                                }
                            } catch (\Exception $e) {
                                // Silently fail if cart items can't be counted
                            }
                        @endphp
                        
                        @if($cartCount > 0)
                            <span class="position-absolute top-0 end-0 translate-middle badge rounded-pill bg-danger">
                                {{ $cartCount }}
                                <span class="visually-hidden">items in cart</span>
                            </span>
                        @endif
                    </a>
                </li>
                
                <!-- User Account -->
                @guest
                    <li class="nav-item">
                        <a class="nav-link px-3" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-light ms-lg-2" href="{{ route('register') }}">
                            <i class="bi bi-person-plus me-1"></i> Register
                        </a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" 
                           id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <!-- Avatar (replace with user's actual avatar if available) -->
                            <div class="avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                 style="width: 32px; height: 32px; font-size: 16px;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                            <span class="d-none d-md-inline">{{ Str::limit(Auth::user()->name, 15) }}</span>
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3 py-2" 
                            aria-labelledby="userDropdown">
                            <li class="dropdown-header d-md-none px-3">
                                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </li>
                            <li class="d-md-none"><hr class="dropdown-divider"></li>
                            
                            <li>
                                <a class="dropdown-item py-2 px-3" href="{{ route('dashboard') }}">
                                    <i class="bi bi-speedometer2 me-2 text-primary"></i> Dashboard
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 px-3" href="{{ route('user.products') }}">
                                    <i class="bi bi-grid me-2 text-primary"></i> My Products
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 px-3" href="{{ route('orders.index') }}">
                                    <i class="bi bi-bag me-2 text-primary"></i> My Orders
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2 px-3" href="{{ route('products.create') }}">
                                    <i class="bi bi-cloud-upload me-2 text-primary"></i> Sell a Product
                                </a>
                            </li>
                            
                            @if(Auth::user()->is_admin ?? false)
                                <li><hr class="dropdown-divider my-2"></li>
                                <li>
                                    <a class="dropdown-item py-2 px-3" href="{{ route('admin.products.index') }}">
                                        <i class="bi bi-gear me-2 text-primary"></i> Admin Panel
                                    </a>
                                </li>
                            @endif
                            
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <a class="dropdown-item py-2 px-3 text-danger" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Sell Button (only visible if logged in) -->
                    <li class="nav-item ms-lg-2">
                        <a href="{{ route('products.create') }}" class="btn btn-light">
                            <i class="bi bi-cloud-upload me-1"></i> Sell
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="searchModalLabel">Search Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.search') }}" method="GET">
                    <div class="input-group">
                        <input type="search" class="form-control form-control-lg" name="query" 
                               placeholder="Search for software, templates, e-books..." aria-label="Search" required 
                               autofocus>
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search me-1"></i> Search
                        </button>
                    </div>
                    <div class="form-text mt-2">
                        <i class="bi bi-info-circle me-1"></i> Search by product name, description, or category
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>