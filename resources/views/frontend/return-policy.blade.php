@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/return-policy.css') }}">
@endpush

@section('content')
@if(!$returnPolicy)
    <div class="alert alert-warning text-center m-5">
        <h3>Return Policy Not Available</h3>
        <p>The return policy is currently being updated. Please check back later.</p>
    </div>
@else
<div class="return-policy-page">
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center hero-content">
                <div class="hero-icon">
                    <i class="fas fa-undo"></i>
                </div>
                <h1 class="hero-title animate__animated animate__fadeInDown">
                    {{ $returnPolicy->hero_title }}
                </h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp">
                    {{ $returnPolicy->hero_subtitle }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="floating-element return-1">
        <i class="fas fa-exchange-alt"></i>
    </div>
    <div class="floating-element return-2">
        <i class="fas fa-check-circle"></i>
    </div>
    <div class="floating-element return-3">
        <i class="fas fa-smile"></i>
    </div>
</section>

<!-- Main Content -->
<div class="return-container">
    <div class="container">
        <div class="return-content">
            <!-- Last Updated -->
            <div class="last-updated">
                <p><strong>Last Updated:</strong> {{ $returnPolicy->updated_at->format('F j, Y') }}</p>
            </div>

            <!-- Introduction -->
            @if($returnPolicy->introduction)
                <section class="return-section">
                    <h2>Our Return Promise</h2>
                    {!! $returnPolicy->introduction !!}
                </section>
            @endif

            <!-- Return Eligibility -->
            @if($returnPolicy->fresh_produce_eligibility || $returnPolicy->dairy_perishables_eligibility || $returnPolicy->packaged_foods_eligibility || $returnPolicy->non_returnable_items)
                <section class="return-section">
                    <h2>Return Eligibility</h2>
                    @if($returnPolicy->fresh_produce_eligibility)
                        <h3>Fresh Produce (Fruits & Vegetables)</h3>
                        {!! $returnPolicy->fresh_produce_eligibility !!}
                    @endif
                    @if($returnPolicy->dairy_perishables_eligibility)
                        <h3>Dairy & Perishables</h3>
                        {!! $returnPolicy->dairy_perishables_eligibility !!}
                    @endif
                    @if($returnPolicy->packaged_foods_eligibility)
                        <h3>Packaged & Processed Foods</h3>
                        {!! $returnPolicy->packaged_foods_eligibility !!}
                    @endif
                    @if($returnPolicy->non_returnable_items)
                        <h3>Non-Returnable Items</h3>
                        {!! $returnPolicy->non_returnable_items !!}
                    @endif
                </section>
            @endif

            <!-- Return Process -->
            @if($returnPolicy->contact_customer_service || $returnPolicy->documentation_required || $returnPolicy->return_approval || $returnPolicy->product_return_step)
                <section class="return-section">
                    <h2>Return Process</h2>
                    @if($returnPolicy->contact_customer_service)
                        <h3>Step 1: Contact Customer Service</h3>
                        {!! $returnPolicy->contact_customer_service !!}
                    @endif
                    @if($returnPolicy->documentation_required)
                        <h3>Step 2: Documentation Required</h3>
                        {!! $returnPolicy->documentation_required !!}
                    @endif
                    @if($returnPolicy->return_approval)
                        <h3>Step 3: Return Approval</h3>
                        {!! $returnPolicy->return_approval !!}
                    @endif
                    @if($returnPolicy->product_return_step)
                        <h3>Step 4: Product Return</h3>
                        {!! $returnPolicy->product_return_step !!}
                    @endif
                </section>
            @endif

            <!-- Refund Options -->
            @if($returnPolicy->full_refund || $returnPolicy->store_credit || $returnPolicy->product_exchange)
                <section class="return-section">
                    <h2>Refund Options</h2>
                    @if($returnPolicy->full_refund)
                        <h3>Full Refund</h3>
                        {!! $returnPolicy->full_refund !!}
                    @endif
                    @if($returnPolicy->store_credit)
                        <h3>Store Credit</h3>
                        {!! $returnPolicy->store_credit !!}
                    @endif
                    @if($returnPolicy->product_exchange)
                        <h3>Product Exchange</h3>
                        {!! $returnPolicy->product_exchange !!}
                    @endif
                </section>
            @endif

            <!-- Special Circumstances -->
            @if($returnPolicy->wrong_item_delivered || $returnPolicy->quality_issues || $returnPolicy->delivery_delays)
                <section class="return-section">
                    <h2>Special Circumstances</h2>
                    @if($returnPolicy->wrong_item_delivered)
                        <h3>Wrong Item Delivered</h3>
                        {!! $returnPolicy->wrong_item_delivered !!}
                    @endif
                    @if($returnPolicy->quality_issues)
                        <h3>Quality Issues</h3>
                        {!! $returnPolicy->quality_issues !!}
                    @endif
                    @if($returnPolicy->delivery_delays)
                        <h3>Delivery Delays</h3>
                        {!! $returnPolicy->delivery_delays !!}
                    @endif
                </section>
            @endif

            <!-- Return Timeframes -->
            @if($returnPolicy->fresh_produce_timeframe || $returnPolicy->dairy_timeframe || $returnPolicy->packaged_foods_timeframe || $returnPolicy->wrong_items_timeframe)
                <section class="return-section">
                    <h2>Return Timeframes</h2>
                    <div class="timeframe-table">
                        <div class="timeframe-row header">
                            <div class="timeframe-category">Product Category</div>
                            <div class="timeframe-period">Return Window</div>
                            <div class="timeframe-conditions">Conditions</div>
                        </div>
                        @if($returnPolicy->fresh_produce_timeframe)
                        <div class="timeframe-row">
                            <div class="timeframe-category">Fresh Produce</div>
                            <div class="timeframe-period">{{ $returnPolicy->fresh_produce_timeframe }}</div>
                            <div class="timeframe-conditions">{{ $returnPolicy->fresh_produce_conditions }}</div>
                        </div>
                        @endif
                        @if($returnPolicy->dairy_timeframe)
                        <div class="timeframe-row">
                            <div class="timeframe-category">Dairy & Perishables</div>
                            <div class="timeframe-period">{{ $returnPolicy->dairy_timeframe }}</div>
                            <div class="timeframe-conditions">{{ $returnPolicy->dairy_conditions }}</div>
                        </div>
                        @endif
                        @if($returnPolicy->packaged_foods_timeframe)
                        <div class="timeframe-row">
                            <div class="timeframe-category">Packaged Foods</div>
                            <div class="timeframe-period">{{ $returnPolicy->packaged_foods_timeframe }}</div>
                            <div class="timeframe-conditions">{{ $returnPolicy->packaged_foods_conditions }}</div>
                        </div>
                        @endif
                        @if($returnPolicy->wrong_items_timeframe)
                        <div class="timeframe-row highlight">
                            <div class="timeframe-category">Wrong Items</div>
                            <div class="timeframe-period">{{ $returnPolicy->wrong_items_timeframe }}</div>
                            <div class="timeframe-conditions">{{ $returnPolicy->wrong_items_conditions }}</div>
                        </div>
                        @endif
                    </div>
                </section>
            @endif

            <!-- Customer Responsibilities -->
            @if($returnPolicy->product_inspection || $returnPolicy->return_preparation || $returnPolicy->communication)
                <section class="return-section">
                    <h2>Customer Responsibilities</h2>
                    @if($returnPolicy->product_inspection)
                        <h3>Product Inspection</h3>
                        {!! $returnPolicy->product_inspection !!}
                    @endif
                    @if($returnPolicy->return_preparation)
                        <h3>Return Preparation</h3>
                        {!! $returnPolicy->return_preparation !!}
                    @endif
                    @if($returnPolicy->communication)
                        <h3>Communication</h3>
                        {!! $returnPolicy->communication !!}
                    @endif
                </section>
            @endif

            <!-- Return Support -->
            <section class="return-section contact-section">
                <h2>Return Support</h2>
                <p>Need help with a return? Our dedicated return support team is ready to assist you:</p>
                <div class="contact-info">
                    @if($returnPolicy->return_hotline)
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>Return Hotline: {{ $returnPolicy->return_hotline }}</span>
                        </div>
                    @endif
                    @if($returnPolicy->return_email)
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>Email: {{ $returnPolicy->return_email }}</span>
                        </div>
                    @endif
                    @if($returnPolicy->support_hours)
                        <div class="contact-item">
                            <i class="fas fa-clock"></i>
                            <span>Support Hours: {{ $returnPolicy->support_hours }}</span>
                        </div>
                    @endif
                    @if($returnPolicy->live_chat)
                        <div class="contact-item">
                            <i class="fas fa-comments"></i>
                            <span>Live Chat: {{ $returnPolicy->live_chat }}</span>
                        </div>
                    @endif
                    @if($returnPolicy->whatsapp)
                        <div class="contact-item">
                            <i class="fas fa-mobile-alt"></i>
                            <span>WhatsApp: {{ $returnPolicy->whatsapp }}</span>
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
function printReturnPolicy() {
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

// Observe all return sections
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.return-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(section);
    });
});
</script>
@endpush
