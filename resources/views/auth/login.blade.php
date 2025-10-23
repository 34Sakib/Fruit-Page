@extends('auth.master')

@section('title', 'Fruitsmart - Login')

@section('content')
<div class="auth-container">
    <div class="row g-0">
        <!-- Left Side - Branding & Info -->
        <div class="col-lg-6 auth-left">
            <h2>Welcome to Fruitsmart</h2>
            <p>Your one-stop destination for fresh, organic fruits delivered to your doorstep.</p>
            
            <ul class="feature-list">
                <li>
                    <i class="fas fa-shipping-fast"></i>
                    <span>Free delivery for orders above $30</span>
                </li>
                <li>
                    <i class="fas fa-award"></i>
                    <span>Quality and freshness guaranteed</span>
                </li>
                <li>
                    <i class="fas fa-leaf"></i>
                    <span>100% organic and pesticide-free</span>
                </li>
                <li>
                    <i class="fas fa-clock"></i>
                    <span>Same day delivery available</span>
                </li>
            </ul>
            
            <div class="fruit-decoration">
                <span class="fruit-icon">🍎</span>
                <span class="fruit-icon">🍊</span>
                <span class="fruit-icon">🍌</span>
                <span class="fruit-icon">🍇</span>
            </div>
        </div>
        
        <!-- Right Side - Login Form -->
        <div class="col-lg-6 auth-right">
            <div class="brand-logo">
                <i class="fas fa-apple-alt"></i>Fruitsmart
            </div>
            
            <h1 class="auth-title">Welcome Back</h1>
            <p class="auth-subtitle">Sign in to your account to continue</p>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                           name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                               name="password" required autocomplete="current-password">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('Remember Me') }}
                        </label>
                    </div>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-decoration-none">
                            {{ __('Forgot Password?') }}
                        </a>
                    @endif
                </div>
                
                <button type="submit" class="btn btn-auth">
                    {{ __('Login') }}
                </button>
                
                <p class="auth-links">
                    Don't have an account? 
                    <a href="{{ route('register') }}">Sign up</a>
                </p>
            </form>
        </div>
    </div>
</div>
</div>
@endsection