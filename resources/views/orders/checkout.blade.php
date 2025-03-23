@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
    <div class="container">
        <h1 class="mb-4">Checkout</h1>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Checkout Form -->
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Contact Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ auth()->user()->email ?? old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">We'll send your receipt and download links to this email.</div>
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0">Payment Method</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="payment-stripe" value="stripe" checked>
                                    <label class="form-check-label" for="payment-stripe">
                                        <i class="bi bi-credit-card me-2"></i> Credit Card (Stripe)
                                    </label>
                                </div>
                                <div id="stripe-payment-form" class="mb-4 p-3 bg-light rounded">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="card-number" class="form-label">Card Number</label>
                                            <input type="text" class="form-control" id="card-number" placeholder="1234 5678 9012 3456">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="card-expiry" class="form-label">Expiry</label>
                                            <input type="text" class="form-control" id="card-expiry" placeholder="MM/YY">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="card-cvc" class="form-label">CVC</label>
                                            <input type="text" class="form-control" id="card-cvc" placeholder="123">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="card-name" class="form-label">Cardholder Name</label>
                                        <input type="text" class="form-control" id="card-name" placeholder="John Doe">
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-lock me-1"></i> Your payment information is securely processed by Stripe. 
                                        We never store your full card details.
                                    </div>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" 
                                           id="payment-paypal" value="paypal">
                                    <label class="form-check-label" for="payment-paypal">
                                        <i class="bi bi-paypal me-2"></i> PayPal
                                    </label>
                                </div>
                                <div id="paypal-payment-form" class="d-none mb-4 p-3 bg-light rounded text-center">
                                    <p class="mb-3">You'll be redirected to PayPal to complete your payment after submitting the order.</p>
                                    <img src="{{ asset('images/paypal-button.png') }}" alt="PayPal" class="img-fluid" style="max-width: 200px;">
                                </div>
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
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                @foreach($cartItems as $item)
                                    <div class="list-group-item d-flex justify-content-between align-items-start py-3">
                                        <div class="ms-2 me-auto">
                                            <div class="fw-bold">{{ $item->product->name }}</div>
                                            <small class="text-muted">Qty: {{ $item->quantity }}</small>
                                        </div>
                                        <span>{{ $item->formattedSubtotal() }}</span>
                                    </div>
                                @endforeach
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
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body">
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" id="terms-agree" required>
                                <label class="form-check-label" for="terms-agree">
                                    I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and 
                                    <a href="#" class="text-decoration-none">Privacy Policy</a>
                                </label>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Complete Purchase</button>
                                <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">Back to Cart</a>
                            </div>
                        </div>
                    </div>

                    <!-- Secure Checkout -->
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <i class="bi bi-shield-lock fs-2 text-success"></i>
                                <h5 class="mt-2">Secure Checkout</h5>
                            </div>
                            <p class="text-muted small mb-0 text-center">
                                Your information is encrypted and securely transmitted. 
                                We never store your payment details on our servers.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const stripeRadio = document.getElementById('payment-stripe');
        const paypalRadio = document.getElementById('payment-paypal');
        const stripeForm = document.getElementById('stripe-payment-form');
        const paypalForm = document.getElementById('paypal-payment-form');

        function togglePaymentForms() {
            if (stripeRadio.checked) {
                stripeForm.classList.remove('d-none');
                paypalForm.classList.add('d-none');
            } else {
                stripeForm.classList.add('d-none');
                paypalForm.classList.remove('d-none');
            }
        }

        stripeRadio.addEventListener('change', togglePaymentForms);
        paypalRadio.addEventListener('change', togglePaymentForms);
        
        // Initial toggle
        togglePaymentForms();
    });
</script>
@endpush