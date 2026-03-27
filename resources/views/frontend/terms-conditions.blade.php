@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/terms-conditions.css') }}">
@endpush

@section('content')
@if(!$termsConditions)
    <div class="alert alert-warning text-center m-5">
        <h3>Terms & Conditions Not Available</h3>
        <p>The terms and conditions are currently being updated. Please check back later.</p>
    </div>
@else
<div class="terms-conditions-page">
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center hero-content">
                    <div class="hero-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h1 class="hero-title animate__animated animate__fadeInDown">
                        {{ $termsConditions->hero_title }}
                    </h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp">
                        {{ $termsConditions->hero_subtitle }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Floating Elements -->
        <div class="floating-element document-1">
            <i class="fas fa-file-alt"></i>
        </div>
        <div class="floating-element document-2">
            <i class="fas fa-gavel"></i>
        </div>
        <div class="floating-element document-3">
            <i class="fas fa-balance-scale"></i>
        </div>
    </section>

    <!-- Main Content -->
    <div class="terms-container">
        <div class="container">
            <div class="terms-content">

                <!-- Last Updated -->
                <div class="last-updated">
                    <p><strong>Last Updated:</strong> {{ date('F j, Y') }}</p>
                </div>

                <!-- Introduction -->
                @if($termsConditions->introduction)
                    <section class="terms-section">
                        <h2>Introduction</h2>
                        <p>{!! $termsConditions->introduction !!}</p>
                    </section>
                @endif

                <!-- Definitions -->
                @if($termsConditions->definitions)
                    <section class="terms-section">
                        <h2>Definitions</h2>
                        <p>{!! $termsConditions->definitions !!}</p>
                    </section>
                @endif

                <!-- Acceptance of Terms -->
                @if($termsConditions->acceptance_of_terms)
                    <section class="terms-section">
                        <h2>Acceptance of Terms</h2>
                        <p>{!! $termsConditions->acceptance_of_terms !!}</p>
                    </section>
                @endif

                <!-- User Account Section -->
                @if($termsConditions->registration)
                    <section class="terms-section">
                        <h2>User Account</h2>

                        <h3>Registration</h3>
                        <p>{!! $termsConditions->registration !!}</p>
                    </section>
                @endif

                @if($termsConditions->account_termination)
                    <section class="terms-section">
                        <h3>Account Termination</h3>
                        <p>{!! $termsConditions->account_termination !!}</p>
                    </section>
                @endif

                <!-- Products and Services -->
                @if($termsConditions->product_information || $termsConditions->order_processing)
                    <section class="terms-section">
                        <h2>Products and Services</h2>

                        @if($termsConditions->product_information)
                            <h3>Product Information</h3>
                            <p>{!! $termsConditions->product_information !!}</p>
                        @endif

                        @if($termsConditions->order_processing)
                            <h3>Order Processing</h3>
                            <p>{!! $termsConditions->order_processing !!}</p>
                        @endif
                    </section>
                @endif

                <!-- Pricing and Payment -->
                @if($termsConditions->pricing || $termsConditions->payment_methods)
                    <section class="terms-section">
                        <h2>Pricing and Payment</h2>

                        @if($termsConditions->pricing)
                            <h3>Pricing</h3>
                            <p>{!! $termsConditions->pricing !!}</p>
                        @endif

                        @if($termsConditions->payment_methods)
                            <h3>Payment Methods</h3>
                            <p>{!! $termsConditions->payment_methods !!}</p>
                        @endif
                    </section>
                @endif

                <!-- Shipping and Delivery -->
                @if($termsConditions->delivery_areas || $termsConditions->delivery_time || $termsConditions->delivery_charges)
                    <section class="terms-section">
                        <h2>Shipping and Delivery</h2>

                        @if($termsConditions->delivery_areas)
                            <h3>Delivery Areas</h3>
                            <p>{!! $termsConditions->delivery_areas !!}</p>
                        @endif

                        @if($termsConditions->delivery_time)
                            <h3>Delivery Time</h3>
                            <p>{!! $termsConditions->delivery_time !!}</p>
                        @endif

                        @if($termsConditions->delivery_charges)
                            <h3>Delivery Charges</h3>
                            <p>{!! $termsConditions->delivery_charges !!}</p>
                        @endif
                </section>
                @endif

                <!-- Returns and Refunds -->
                @if($termsConditions->return_policy || $termsConditions->refund_process)
                    <section class="terms-section">
                        <h2>Returns and Refunds</h2>

                        @if($termsConditions->return_policy)
                            <h3>Return Policy</h3>
                            <p>{!! $termsConditions->return_policy !!}</p>
                        @endif

                        @if($termsConditions->refund_process)
                            <h3>Refund Process</h3>
                            <p>{!! $termsConditions->refund_process !!}</p>
                        @endif
                    </section>
                @endif

                <!-- Intellectual Property -->
                @if($termsConditions->intellectual_property)
                    <section class="terms-section">
                        <h2>Intellectual Property</h2>
                        <p>{!! $termsConditions->intellectual_property !!}</p>
                    </section>
                @endif

                <!-- User Conduct -->
                @if($termsConditions->user_conduct)
                    <section class="terms-section">
                        <h2>User Conduct</h2>
                        <p>{!! $termsConditions->user_conduct !!}</p>
                    </section>
                @endif

                <!-- Limitation of Liability -->
                @if($termsConditions->limitation_of_liability)
                    <section class="terms-section">
                        <h2>Limitation of Liability</h2>
                        <p>{!! $termsConditions->limitation_of_liability !!}</p>
                    </section>
                @endif

                <!-- Termination -->
                @if($termsConditions->termination)
                    <section class="terms-section">
                        <h2>Termination</h2>
                        <p>{!! $termsConditions->termination !!}</p>
                    </section>
                @endif

                <!-- Changes to Terms -->
                @if($termsConditions->changes_to_terms)
                    <section class="terms-section">
                        <h2>Changes to Terms</h2>
                        <p>{!! $termsConditions->changes_to_terms !!}</p>
                    </section>
                @endif

                <!-- Contact Information -->
                <section class="terms-section contact-section">
                    <h2>Contact Information</h2>
                    <p>If you have any questions about these Terms & Conditions, please contact us:</p>

                    <div class="contact-info">
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>Email: {!! $termsConditions->contact_email !!}</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>Phone: {!! $termsConditions->contact_phone !!}</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Address: {!! $termsConditions->contact_address !!}</span>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button class="back-to-top" id="backToTop" aria-label="Back to top">
        <i class="fas fa-arrow-up"></i>
    </button>
</div>

@endif {{-- ✅ THIS WAS MISSING --}}
@endsection

@push('scripts')
<script>
// Smooth scrolling
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    });
});

// Back to top button
const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) backToTopButton.classList.add('show');
    else backToTopButton.classList.remove('show');
});

backToTopButton?.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
});

// Animation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// ✅ observe each element (fixed)
document.querySelectorAll('.terms-section').forEach(section => {
    observer.observe(section);
});
</script>
@endpush