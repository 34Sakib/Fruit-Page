@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/contact.css') }}">
@endpush

@section('content')
<div class="contact-page">
    <!-- Header Section -->
    <header class="contact-header">
        <div class="header-content">
            <div class="header-icon animate__animated animate__bounce">
                <i class="{{ $contactInfo->header_icon ?? 'fas fa-headset' }}"></i>
            </div>
            <h1 class="header-title animate__animated animate__fadeInDown">
                {{ $contactInfo->header_title ?? 'Get in Touch With Us' }}
            </h1>
            <p class="header-subtitle animate__animated animate__fadeInUp">
                {{ $contactInfo->header_subtitle ?? 'We\'re here to help! Whether you have questions about our organic products, need assistance with an order, or just want to share feedback, our team is ready to assist you.' }}
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="contact-container">
        <!-- Contact Cards Grid -->
        <div class="contact-grid">
            <!-- Email Card -->
            <div class="contact-card animate-fade-in animate-delay-1">
                <div class="card-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <h3 class="card-title">Email Us</h3>
                <p class="card-content">
                    {{ $contactInfo->email_hours ?? 'Send us an email and we\'ll get back to you within 24 hours.' }}
                </p>
                <a href="mailto:{{ $contactInfo->email ?? 'support@fruitspage.com' }}" class="card-link">
                    {{ $contactInfo->email ?? 'support@fruitspage.com' }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Phone Card -->
            <div class="contact-card animate-fade-in animate-delay-2">
                <div class="card-icon">
                    <i class="fas fa-phone"></i>
                </div>
                <h3 class="card-title">Call Us</h3>
                <p class="card-content">
                    {{ $contactInfo->phone_hours ?? 'Available Monday to Saturday from 9 AM to 8 PM.' }}
                </p>
                <a href="tel:{{ $contactInfo->phone ?? '+8801234567890' }}" class="card-link">
                    {{ $contactInfo->phone ?? '+880 1234 567890' }}
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>

            <!-- Location Card -->
            <div class="contact-card animate-fade-in animate-delay-3">
                <div class="card-icon">
                    <i class="fas fa-map-marker-alt"></i>
                </div>
                <h3 class="card-title">Visit Us</h3>
                <p class="card-content">
                    {{ $contactInfo->address ?? '123 Organic Street, Freshville, Dhaka 1205, Bangladesh' }}
                </p>
                <a href="#map" class="card-link">
                    View on Map
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <!-- Contact Form Section -->
        <div class="contact-form-section animate-fade-in animate-delay-1">
            <h2 class="section-title">Send us a Message</h2>
            <p class="section-subtitle">
                Fill out the form below and we'll respond as soon as possible
            </p>
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form action="{{ route('contact.submit') }}" method="POST" id="contactForm">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-user"></i> Full Name *
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" placeholder="Enter your full name" 
                                   value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope"></i> Email Address *
                            </label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" placeholder="your@email.com" 
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone"></i> Phone Number
                            </label>
                            <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" placeholder="+880 1XXX-XXXXXX" 
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="subject" class="form-label">
                                <i class="fas fa-tag"></i> Subject *
                            </label>
                            <select class="form-select @error('subject') is-invalid @enderror" 
                                    id="subject" name="subject" required>
                                <option value="">Select a subject</option>
                                <option value="Order Inquiry" {{ old('subject') == 'Order Inquiry' ? 'selected' : '' }}>Order Inquiry</option>
                                <option value="Product Information" {{ old('subject') == 'Product Information' ? 'selected' : '' }}>Product Information</option>
                                <option value="Delivery Questions" {{ old('subject') == 'Delivery Questions' ? 'selected' : '' }}>Delivery Questions</option>
                                <option value="Quality Concern" {{ old('subject') == 'Quality Concern' ? 'selected' : '' }}>Quality Concern</option>
                                <option value="Feedback & Suggestions" {{ old('subject') == 'Feedback & Suggestions' ? 'selected' : '' }}>Feedback & Suggestions</option>
                                <option value="Other" {{ old('subject') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="message" class="form-label">
                        <i class="fas fa-comment"></i> Your Message *
                    </label>
                    <textarea class="form-control @error('message') is-invalid @enderror" 
                              id="message" name="message" rows="5" 
                              placeholder="How can we help you today?" required>{{ old('message') }}</textarea>
                    @error('message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

        <!-- Map Section -->
        <div class="map-section animate-fade-in animate-delay-2" id="map">
            <h2 class="section-title mb-4">Find Our Location</h2>
            <div class="map-container">
                @if($contactInfo && $contactInfo->map_embed_url)
                    <iframe 
                        src="{{ $contactInfo->map_embed_url }}" 
                        width="100%" 
                        height="450" 
                        style="border:0; border-radius: 8px;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @else
                    <div class="map-placeholder">
                        <i class="fas fa-map-marked-alt"></i>
                        <div class="map-placeholder-text">
                            Interactive Map Loading...
                        </div>
                    </div>
                @endif
            </div>
            <div class="text-center mt-3">
                <p class="text-muted">
                    <i class="fas fa-map-pin text-primary"></i>
                    {{ $contactInfo->map_address ?? $contactInfo->address ?? '123 Organic Street, Freshville, Dhaka 1205, Bangladesh' }}
                </p>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="faq-section animate-fade-in animate-delay-3">
            <h2 class="section-title mb-4">Frequently Asked Questions</h2>
            
            @if($faqs->count() > 0)
                @foreach($faqs as $faq)
                    <div class="faq-item">
                        <div class="faq-question">
                            <span>{{ $faq->question }}</span>
                            <i class="fas fa-plus"></i>
                        </div>
                        <div class="faq-answer">
                            {{ $faq->answer }}
                        </div>
                    </div>
                @endforeach
            @else
                <!-- Default FAQs when no data exists -->
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What are your delivery hours?</span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-answer">
                        We deliver from 8 AM to 10 PM, 7 days a week. Same-day delivery is available for orders placed before 4 PM.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you deliver outside Dhaka?</span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-answer">
                        Yes! We deliver to all major cities in Bangladesh. Delivery charges vary by location and will be calculated at checkout.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>How can I track my order?</span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-answer">
                        Once your order is shipped, you'll receive a tracking link via SMS and email. You can also track your order from your account dashboard.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>What is your return policy?</span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-answer">
                        We accept returns within 24 hours of delivery for quality issues. Fresh produce can be returned if there are freshness or quality concerns.
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <span>Do you offer bulk ordering for events?</span>
                        <i class="fas fa-plus"></i>
                    </div>
                    <div class="faq-answer">
                        Absolutely! We provide special pricing for bulk orders. Contact our sales team at bulk@fruitspage.com for customized quotes.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
@push('scripts')
        <script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush
