<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Digital Marketplace'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=poppins:400,500,600,700&display=swap" rel="stylesheet" />
        
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <style>
            :root {
                --primary: #FF5722;
                --secondary: #2196F3;
                --success: #4CAF50;
                --danger: #F44336;
                --warning: #FFC107;
                --info: #00BCD4;
                --light: #F5F5F5;
                --dark: #333333;
            }
            
            body {
                font-family: 'Poppins', sans-serif;
                background-color: #F5F5F5;
                color: #333333;
            }
            
            .navbar-brand {
                font-weight: 600;
            }
            
            .btn-primary {
                background-color: var(--primary);
                border-color: var(--primary);
            }
            
            .btn-primary:hover {
                background-color: #E64A19;
                border-color: #E64A19;
            }
            
            .bg-primary {
                background-color: var(--primary) !important;
            }
            
            .card {
                border-radius: 8px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            
            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
            
            .card-img-top {
                height: 200px;
                object-fit: cover;
            }
            
            footer {
                background-color: #333333;
                color: white;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <i class="bi bi-shop me-2 text-primary"></i>
                    {{ config('app.name', 'Digital Marketplace') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('products.index') }}">Products</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Categories
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @php
                                    $categories = \App\Models\Category::all();
                                @endphp
                                @foreach($categories as $category)
                                    <li><a class="dropdown-item" href="{{ route('products.category', $category->slug) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                    <form class="d-flex me-3" action="{{ route('products.search') }}" method="GET">
                        <input class="form-control me-2" type="search" name="query" placeholder="Search products..." aria-label="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </form>
                    <div class="d-flex align-items-center">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary position-relative me-2">
                            <i class="bi bi-cart"></i>
                            @auth
                                @php
                                    $cartCount = \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity');
                                @endphp
                                @if($cartCount > 0)
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                        {{ $cartCount }}
                                    </span>
                                @endif
                            @endauth
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-sm btn-primary me-2">Login</a>
                            <a href="{{ route('register') }}" class="btn btn-sm btn-outline-primary">Register</a>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li><a class="dropdown-item" href="{{ route('orders.index') }}">My Orders</a></li>
                                    <li><a class="dropdown-item" href="{{ route('products.create') }}">Sell Product</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div id="app">
            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="py-5 mt-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 mb-4 mb-md-0">
                        <h5 class="mb-3">About Us</h5>
                        <p class="text-white-50">Digital Marketplace is a platform for buying and selling digital products. Find everything from software and e-books to templates and creative assets.</p>
                    </div>
                    <div class="col-md-2 mb-4 mb-md-0">
                        <h5 class="mb-3">Quick Links</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Home</a></li>
                            <li class="mb-2"><a href="{{ route('products.index') }}" class="text-white-50 text-decoration-none">Products</a></li>
                            <li class="mb-2"><a href="{{ route('dashboard') }}" class="text-white-50 text-decoration-none">Dashboard</a></li>
                        </ul>
                    </div>
                    <div class="col-md-2 mb-4 mb-md-0">
                        <h5 class="mb-3">Categories</h5>
                        <ul class="list-unstyled">
                            @foreach($categories->take(4) as $category)
                                <li class="mb-2"><a href="{{ route('products.category', $category->slug) }}" class="text-white-50 text-decoration-none">{{ $category->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h5 class="mb-3">Stay Updated</h5>
                        <p class="text-white-50">Subscribe to our newsletter for the latest products and offers.</p>
                        <form class="mb-3">
                            <div class="input-group">
                                <input type="email" class="form-control" placeholder="Your email address">
                                <button class="btn btn-primary" type="submit">Subscribe</button>
                            </div>
                        </form>
                        <div class="d-flex gap-2">
                            <a href="#" class="text-white-50 fs-5"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="text-white-50 fs-5"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="text-white-50 fs-5"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="text-white-50 fs-5"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                <hr class="my-4 border-secondary">
                <div class="row align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="mb-0 text-white-50">&copy; {{ date('Y') }} Digital Marketplace. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        <div class="d-flex justify-content-center justify-content-md-end gap-3">
                            <a href="#" class="text-white-50 text-decoration-none">Privacy Policy</a>
                            <a href="#" class="text-white-50 text-decoration-none">Terms of Service</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
