@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/shipping-policy.css') }}">
@endpush

@section('content')
@if(!$shippingPolicy)
    <div class="alert alert-warning text-center m-5">
        <h3>Shipping Policy Not Available</h3>
        <p>The shipping policy is currently being updated. Please check back later.</p>
    </div>
@else
<div class="shipping-policy-page">
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center hero-content">
                <div class="hero-icon">
                    <i class="fas fa-truck"></i>
                </div>
                <h1 class="hero-title animate__animated animate__fadeInDown">
                    {{ $shippingPolicy->hero_title }}
                </h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp">
                    {{ $shippingPolicy->hero_subtitle }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="floating-element truck-1">
        <i class="fas fa-shipping-fast"></i>
    </div>
    <div class="floating-element truck-2">
        <i class="fas fa-box"></i>
    </div>
    <div class="floating-element truck-3">
        <i class="fas fa-map-marked-alt"></i>
    </div>
</section>

<!-- Main Content -->
<div class="shipping-container">
    <div class="container">
        <div class="shipping-content">
            <!-- Last Updated -->
            <div class="last-updated">
                <p><strong>Last Updated:</strong> {{ $shippingPolicy->updated_at->format('F j, Y') }}</p>
            </div>

            <!-- Introduction -->
            @if($shippingPolicy->introduction)
                <section class="shipping-section">
                    <h2>Our Shipping Commitment</h2>
                    {!! $shippingPolicy->introduction !!}
                </section>
            @endif

            <!-- Delivery Areas -->
            @if($shippingPolicy->current_coverage || $shippingPolicy->expansion_plans)
                <section class="shipping-section">
                    <h2>Delivery Areas</h2>
                    @if($shippingPolicy->current_coverage)
                        <h3>Current Coverage</h3>
                        {!! $shippingPolicy->current_coverage !!}
                    @endif
                    @if($shippingPolicy->expansion_plans)
                        <h3>Expansion Plans</h3>
                        {!! $shippingPolicy->expansion_plans !!}
                    @endif
                </section>
            @endif

            <!-- Delivery Timeframes -->
            @if($shippingPolicy->standard_delivery_time || $shippingPolicy->express_delivery_time || $shippingPolicy->scheduled_delivery)
                <section class="shipping-section">
                    <h2>Delivery Timeframes</h2>
                    @if($shippingPolicy->standard_delivery_time)
                        <h3>Standard Delivery</h3>
                        {!! $shippingPolicy->standard_delivery_time !!}
                    @endif
                    @if($shippingPolicy->express_delivery_time)
                        <h3>Express Delivery</h3>
                        {!! $shippingPolicy->express_delivery_time !!}
                    @endif
                    @if($shippingPolicy->scheduled_delivery)
                        <h3>Scheduled Delivery</h3>
                        {!! $shippingPolicy->scheduled_delivery !!}
                    @endif
                </section>
            @endif

            <!-- Shipping Charges -->
            @if($shippingPolicy->standard_delivery_rates || $shippingPolicy->additional_services)
                <section class="shipping-section">
                    <h2>Shipping Charges</h2>
                    @if($shippingPolicy->standard_delivery_rates)
                        <h3>Standard Delivery Rates</h3>
                        {!! $shippingPolicy->standard_delivery_rates !!}
                    @endif
                    @if($shippingPolicy->additional_services)
                        <h3>Additional Services</h3>
                        {!! $shippingPolicy->additional_services !!}
                    @endif
                </section>
            @endif

            <!-- Order Processing -->
            @if($shippingPolicy->order_confirmation || $shippingPolicy->quality_assurance || $shippingPolicy->dispatch_process)
                <section class="shipping-section">
                    <h2>Order Processing</h2>
                    @if($shippingPolicy->order_confirmation)
                        <h3>Order Confirmation</h3>
                        {!! $shippingPolicy->order_confirmation !!}
                    @endif
                    @if($shippingPolicy->quality_assurance)
                        <h3>Quality Assurance</h3>
                        {!! $shippingPolicy->quality_assurance !!}
                    @endif
                    @if($shippingPolicy->dispatch_process)
                        <h3>Dispatch Process</h3>
                        {!! $shippingPolicy->dispatch_process !!}
                    @endif
                </section>
            @endif

            <!-- Packaging Standards -->
            @if($shippingPolicy->fresh_produce_packaging || $shippingPolicy->dairy_perishables_packaging || $shippingPolicy->packaged_goods_packaging)
                <section class="shipping-section">
                    <h2>Packaging Standards</h2>
                    @if($shippingPolicy->fresh_produce_packaging)
                        <h3>Fresh Produce</h3>
                        {!! $shippingPolicy->fresh_produce_packaging !!}
                    @endif
                    @if($shippingPolicy->dairy_perishables_packaging)
                        <h3>Dairy & Perishables</h3>
                        {!! $shippingPolicy->dairy_perishables_packaging !!}
                    @endif
                    @if($shippingPolicy->packaged_goods_packaging)
                        <h3>Packaged Goods</h3>
                        {!! $shippingPolicy->packaged_goods_packaging !!}
                    @endif
                </section>
            @endif

            <!-- Delivery Process -->
            @if($shippingPolicy->before_delivery || $shippingPolicy->during_delivery || $shippingPolicy->after_delivery)
                <section class="shipping-section">
                    <h2>Delivery Process</h2>
                    @if($shippingPolicy->before_delivery)
                        <h3>Before Delivery</h3>
                        {!! $shippingPolicy->before_delivery !!}
                    @endif
                    @if($shippingPolicy->during_delivery)
                        <h3>During Delivery</h3>
                        {!! $shippingPolicy->during_delivery !!}
                    @endif
                    @if($shippingPolicy->after_delivery)
                        <h3>After Delivery</h3>
                        {!! $shippingPolicy->after_delivery !!}
                    @endif
                </section>
            @endif

            <!-- Special Circumstances -->
            @if($shippingPolicy->weather_conditions || $shippingPolicy->product_unavailability || $shippingPolicy->failed_delivery_attempts)
                <section class="shipping-section">
                    <h2>Special Circumstances</h2>
                    @if($shippingPolicy->weather_conditions)
                        <h3>Weather Conditions</h3>
                        {!! $shippingPolicy->weather_conditions !!}
                    @endif
                    @if($shippingPolicy->product_unavailability)
                        <h3>Product Unavailability</h3>
                        {!! $shippingPolicy->product_unavailability !!}
                    @endif
                    @if($shippingPolicy->failed_delivery_attempts)
                        <h3>Failed Delivery Attempts</h3>
                        {!! $shippingPolicy->failed_delivery_attempts !!}
                    @endif
                </section>
            @endif

            <!-- International Shipping -->
            @if($shippingPolicy->international_shipping)
                <section class="shipping-section">
                    <h2>International Shipping</h2>
                    {!! $shippingPolicy->international_shipping !!}
                </section>
            @endif

            <!-- Shipping Support -->
            <section class="shipping-section contact-section">
                <h2>Shipping Support</h2>
                <p>Have questions about our shipping policy or need assistance with your delivery? Our shipping support team is here to help:</p>
                <div class="contact-info">
                    @if($shippingPolicy->shipping_hotline)
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>Shipping Hotline: {{ $shippingPolicy->shipping_hotline }}</span>
                        </div>
                    @endif
                    @if($shippingPolicy->shipping_email)
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>Email: {{ $shippingPolicy->shipping_email }}</span>
                        </div>
                    @endif
                    @if($shippingPolicy->support_hours)
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>Support Hours: {{ $shippingPolicy->support_hours }}</span>
                        </div>
                    @endif
                    @if($shippingPolicy->live_chat)
                        <div class="contact-item">
                            <i class="fas fa-headset"></i>
                            <span>Live Chat: {{ $shippingPolicy->live_chat }}</span>
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </div>
</div>
@endif

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>

@endsection

@push('scripts')
<script>
// Add smooth scrolling for better user experience
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Back to top button functionality
const backToTopButton = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
    if (window.pageYOffset > 300) {
        backToTopButton.classList.add('show');
    } else {
        backToTopButton.classList.remove('show');
    }
});

backToTopButton.addEventListener('click', () => {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Add print functionality
function printShippingPolicy() {
    window.print();
}

// Add animation on scroll
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

// Observe all shipping sections
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.shipping-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(section);
    });
});
</script>
@endpush
