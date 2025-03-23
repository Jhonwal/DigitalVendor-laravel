<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Digital Marketplace - Your one-stop shop for premium digital products">
    <meta name="keywords" content="digital products, templates, software, e-books, digital marketplace">
    
    <title>{{ config('app.name', 'Digital Marketplace') }} | @yield('title', 'Home')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    
    <!-- Custom Styles -->
    <style>
        :root {
            --primary: #FF5722;
            --primary-dark: #E64A19;
            --primary-light: #FFCCBC;
            --secondary: #2196F3;
            --dark: #212121;
            --light: #F5F5F5;
            --success: #4CAF50;
            --danger: #F44336;
            --warning: #FFC107;
            --info: #00BCD4;
            --bs-primary: var(--primary);
            --bs-primary-rgb: 255, 87, 34;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }
        
        .bg-primary {
            background-color: var(--primary) !important;
        }
        
        .text-primary {
            color: var(--primary) !important;
        }
        
        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--primary-dark) !important;
            border-color: var(--primary-dark) !important;
        }
        
        .btn-outline-primary {
            color: var(--primary);
            border-color: var(--primary);
        }
        
        .btn-outline-primary:hover, .btn-outline-primary:focus, .btn-outline-primary:active {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
            color: white !important;
        }
        
        /* Navbar Styles */
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem !important;
        }
        
        /* Card Styles */
        .card {
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        /* Badge Styles */
        .badge {
            font-weight: 500;
            padding: 0.5em 1em;
        }
        
        /* Button Styles */
        .btn {
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 5px;
        }
        
        /* Footer Styles */
        footer {
            background: #212121;
            color: #fff;
        }
        
        footer a {
            color: #fff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: var(--primary-light);
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        /* Responsive Typography */
        @media (max-width: 768px) {
            h1 {
                font-size: 2rem;
            }
            h2 {
                font-size: 1.7rem;
            }
            h3 {
                font-size: 1.4rem;
            }
        }
        
        /* Background Gradient */
        .bg-gradient-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header class="sticky-top">
        @include('layouts.navigation')
    </header>
    
    <!-- Main Content -->
    <main>
        <!-- Alert Messages -->
        @if (session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-lg" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2 fs-4"></i>
                    <strong>{{ session('success') }}</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        
        @if (session('error'))
        <div class="container mt-4">
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-lg" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                    <strong>{{ session('error') }}</strong>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
        
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="mt-5 pt-5">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <div class="mb-4">
                        <a href="{{ route('home') }}" class="d-inline-flex align-items-center text-white text-decoration-none mb-3">
                            <i class="bi bi-box-seam fs-3 me-2"></i>
                            <span class="fs-4 fw-bold">Digital Marketplace</span>
                        </a>
                        <p class="text-muted mb-4">Your one-stop shop for premium digital products created by talented designers and developers around the world.</p>
                        <div class="social-icons d-flex gap-2">
                            <a href="#" class="me-2"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="me-2"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white fw-bold mb-4">Quick Links</h5>
                    <ul class="list-unstyled footer-links">
                        <li class="mb-2"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Home</a></li>
                        <li class="mb-2"><a href="{{ route('products.index') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Products</a></li>
                        <li class="mb-2"><a href="{{ route('cart.index') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Cart</a></li>
                        @auth
                            <li class="mb-2"><a href="{{ route('dashboard') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Dashboard</a></li>
                            <li class="mb-2"><a href="{{ route('orders.index') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> My Orders</a></li>
                        @else
                            <li class="mb-2"><a href="{{ route('login') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Login</a></li>
                            <li class="mb-2"><a href="{{ route('register') }}" class="text-decoration-none"><i class="bi bi-chevron-right me-1 small"></i> Register</a></li>
                        @endauth
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5 class="text-white fw-bold mb-4">Categories</h5>
                    <ul class="list-unstyled footer-links">
                        @php
                            $footerCategories = \App\Models\Category::take(5)->get();
                        @endphp
                        @foreach($footerCategories as $category)
                            <li class="mb-2">
                                <a href="{{ route('products.category', $category->slug) }}" class="text-decoration-none">
                                    <i class="bi bi-chevron-right me-1 small"></i> {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="text-white fw-bold mb-4">Newsletter</h5>
                    <p class="text-muted mb-4">Subscribe to our newsletter to receive updates on new products, special offers, and promotions.</p>
                    <form action="#" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email address" required>
                            <button class="btn btn-primary" type="submit">Subscribe</button>
                        </div>
                    </form>
                    <div class="contact-info text-muted">
                        <div class="mb-2"><i class="bi bi-envelope me-2"></i> support@digitalmarketplace.com</div>
                        <div class="mb-2"><i class="bi bi-telephone me-2"></i> (123) 456-7890</div>
                        <div><i class="bi bi-geo-alt me-2"></i> 123 Market Street, Suite 456, San Francisco, CA 94103</div>
                    </div>
                </div>
            </div>
            
            <hr class="mt-4 mb-3 border-secondary">
            
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Digital Marketplace. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="payment-methods">
                        <i class="bi bi-credit-card fs-4 me-2 text-muted"></i>
                        <i class="bi bi-paypal fs-4 me-2 text-muted"></i>
                        <i class="bi bi-stripe fs-4 me-2 text-muted"></i>
                        <i class="bi bi-wallet2 fs-4 me-2 text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <a href="#" class="btn btn-primary rounded-circle shadow position-fixed bottom-0 end-0 m-4" id="back-to-top" style="display: none;">
        <i class="bi bi-arrow-up"></i>
    </a>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const backToTopButton = document.getElementById('back-to-top');
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 300) {
                    backToTopButton.style.display = 'block';
                } else {
                    backToTopButton.style.display = 'none';
                }
            });
            
            backToTopButton.addEventListener('click', function(e) {
                e.preventDefault();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
            
            // Tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>