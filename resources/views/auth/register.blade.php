@extends('auth.master')

@section('title', 'Fruitsmart - Create Account')

@section('content')
<div class="auth-container">
    <div class="row g-0">
        <!-- Left Side - Branding & Info -->
        <div class="col-lg-6 auth-left">
            <h2>Join Fruitsmart Today</h2>
            <p>Create an account to enjoy fresh, organic fruits delivered to your doorstep with exclusive member benefits.</p>
            
            <ul class="feature-list">
                <li>
                    <i class="fas fa-truck"></i>
                    <span>Free delivery on orders above $30</span>
                </li>
                <li>
                    <i class="fas fa-percentage"></i>
                    <span>Exclusive member discounts and offers</span>
                </li>
                <li>
                    <i class="fas fa-history"></i>
                    <span>Faster checkout with saved details</span>
                </li>
                <li>
                    <i class="fas fa-gift"></i>
                    <span>Birthday surprises and special treats</span>
                </li>
            </ul>
            
            <div class="fruit-decoration">
                <span class="fruit-icon">🍓</span>
                <span class="fruit-icon">🍍</span>
                <span class="fruit-icon">🥭</span>
                <span class="fruit-icon">🍉</span>
            </div>
        </div>
        
        <!-- Right Side - Registration Form -->
        <div class="col-lg-6 auth-right">
            <div class="brand-logo">
                <i class="fas fa-apple-alt"></i>Fruitsmart
            </div>
            
            <h1 class="auth-title">Create Account</h1>
            <p class="auth-subtitle">Sign up to start your fruitful journey with us</p>
            
            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" name="email" value="{{ old('email') }}" required autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required autocomplete="new-password">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    <div class="password-strength mt-2">
                        <div class="password-strength-bar" id="password-strength-bar"></div>
                    </div>
                    <div class="password-requirements">
                        <div class="requirement" id="length-req">
                            <i class="fas fa-circle"></i>
                            <span>At least 8 characters</span>
                        </div>
                        <div class="requirement" id="upper-req">
                            <i class="fas fa-circle"></i>
                            <span>At least one uppercase letter</span>
                        </div>
                        <div class="requirement" id="lower-req">
                            <i class="fas fa-circle"></i>
                            <span>At least one lowercase letter</span>
                        </div>
                        <div class="requirement" id="number-req">
                            <i class="fas fa-circle"></i>
                            <span>At least one number</span>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password-confirm" 
                               name="password_confirmation" required autocomplete="new-password">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <div id="password-match" class="mt-1"></div>
                </div>
                
                <div class="form-check terms-check mb-4">
                    <input class="form-check-input @error('terms') is-invalid @enderror" 
                           type="checkbox" id="terms" name="terms" required>
                    <label class="form-check-label" for="terms">
                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and 
                        <a href="#" class="text-primary">Privacy Policy</a>
                    </label>
                    @error('terms')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-auth w-100">
                    {{ __('Create Account') }}
                </button>
                
                <p class="auth-links">
                    Already have an account? 
                    <a href="{{ route('login') }}">Sign in</a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection