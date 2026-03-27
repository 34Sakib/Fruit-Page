@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/header.css') }}">
<link rel="stylesheet" href="{{ asset('frontend/css/privacy-policy.css') }}">
@endpush

@section('content')
@if(!$privacyPolicy)
    <div class="alert alert-warning text-center m-5">
        <h3>Privacy Policy Not Available</h3>
        <p>The privacy policy is currently being updated. Please check back later.</p>
    </div>
@else
<div class="privacy-policy-page">
<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center hero-content">
                <div class="hero-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h1 class="hero-title animate__animated animate__fadeInDown">
                    {{ $privacyPolicy->hero_title }}
                </h1>
                <p class="hero-subtitle animate__animated animate__fadeInUp">
                    {{ $privacyPolicy->hero_subtitle }}
                </p>
            </div>
        </div>
    </div>
    
    <!-- Floating Elements -->
    <div class="floating-element shield-1">
        <i class="fas fa-shield-alt"></i>
    </div>
    <div class="floating-element shield-2">
        <i class="fas fa-lock"></i>
    </div>
    <div class="floating-element shield-3">
        <i class="fas fa-user-shield"></i>
    </div>
</section>

<!-- Main Content -->
<div class="privacy-container">
    <div class="container">
        <div class="privacy-content">
            <!-- Last Updated -->
            <div class="last-updated">
                <p><strong>Last Updated:</strong> {{ date('F j, Y') }}</p>
            </div>

            <!-- Introduction -->
            <section class="privacy-section">
                <h2>Introduction</h2>
                <p>
                    {!! $privacyPolicy->introduction !!}
                </p>
            </section>

            <!-- Information We Collect -->
            @if($privacyPolicy->personal_info || $privacyPolicy->auto_collected_info)
            <section class="privacy-section">
                <h2>Information We Collect</h2>
                
                @if($privacyPolicy->personal_info)
                <h3>Personal Information</h3>
                <ul>
                    {!! $privacyPolicy->personal_info !!}
                </ul>
                @endif

                @if($privacyPolicy->auto_collected_info)
                <h3>Automatically Collected Information</h3>
                <ul>
                    {!! $privacyPolicy->auto_collected_info !!}
                </ul>
                @endif
            </section>
            @endif

            <!-- How We Use Your Information -->
            @if($privacyPolicy->information_usage)
            <section class="privacy-section">
                <h2>How We Use Your Information</h2>
                <ul>
                    {!! $privacyPolicy->information_usage !!}
                </ul>
            </section>
            @endif

            <!-- Data Sharing and Disclosure -->
            @if($privacyPolicy->data_sharing)
            <section class="privacy-section">
                <h2>Data Sharing and Disclosure</h2>
                <ul>
                    {!! $privacyPolicy->data_sharing !!}
                </ul>
            </section>
            @endif

            <!-- Data Security -->
            @if($privacyPolicy->data_security)
            <section class="privacy-section">
                <h2>Data Security</h2>
                <p>
                    {!! $privacyPolicy->data_security !!}
                </p>
            </section>
            @endif

            <!-- Cookies and Tracking -->
            @if($privacyPolicy->cookies_tracking)
            <section class="privacy-section">
                <h2>Cookies and Tracking Technologies</h2>
                <p>
                    {!! $privacyPolicy->cookies_tracking !!}
                </p>
            </section>
            @endif

            <!-- Your Rights -->
            @if($privacyPolicy->privacy_rights)
            <section class="privacy-section">
                <h2>Your Privacy Rights</h2>
                <ul>
                    {!! $privacyPolicy->privacy_rights !!}
                </ul>
            
            </section>
            @endif

            <!-- Third-Party Links -->
            @if($privacyPolicy->third_party_links)
            <section class="privacy-section">
                <h2>Third-Party Websites</h2>
                <p>
                    {!! $privacyPolicy->third_party_links !!}
                </p>
            </section>
            @endif

            <!-- Children's Privacy -->
            @if($privacyPolicy->children_privacy)
            <section class="privacy-section">
                <h2>Children's Privacy</h2>
                <p>
                    {!! $privacyPolicy->children_privacy !!}
                </p>
            </section>
            @endif

            <!-- Changes to This Policy -->
            @if($privacyPolicy->policy_changes)
            <section class="privacy-section">
                <h2>Changes to This Privacy Policy</h2>
                <p>
                    {!! $privacyPolicy->policy_changes !!}
                </p>
            </section>
            @endif

            <!-- Contact Information -->
            @if($privacyPolicy->contact_email || $privacyPolicy->contact_phone || $privacyPolicy->contact_address)
            <section class="privacy-section contact-section">
                <h2>Contact Us</h2>
                <div class="contact-info">
                    @if($privacyPolicy->contact_email)
                    <div class="contact-item">
                        <i class="fas fa-envelope"></i>
                        <span>Email: {{ $privacyPolicy->contact_email }}</span>
                    </div>
                    @endif
                    @if($privacyPolicy->contact_phone)
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <span>Phone: {{ $privacyPolicy->contact_phone }}</span>
                    </div>
                    @endif
                    @if($privacyPolicy->contact_address)
                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>Address: {{ $privacyPolicy->contact_address }}</span>
                    </div>
                    @endif
                </div>
            </section>
            @endif
        </div>
    </div>
    </div>
</div>

<!-- Back to Top Button -->
<button class="back-to-top" id="backToTop" aria-label="Back to top">
    <i class="fas fa-arrow-up"></i>
</button>
</div>
@endif
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
function printPrivacyPolicy() {
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

// Observe all privacy sections
document.addEventListener('DOMContentLoaded', () => {
    const sections = document.querySelectorAll('.privacy-section');
    sections.forEach((section, index) => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(30px)';
        section.style.transition = `all 0.6s ease ${index * 0.1}s`;
        observer.observe(section);
    });
});
</script>
@endpush
