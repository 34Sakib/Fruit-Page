@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/about.css') }}">
@endpush
@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center hero-content">
                    <div class="hero-icon">
                        <i class="{{ $aboutContent->hero_icon ?? 'fas fa-leaf' }}"></i>
                    </div>
                    <h1 class="hero-title animate__animated animate__fadeInDown">
                        {{ $aboutContent->hero_title ?? 'Our Story: Fresh from Farm to Table' }}
                    </h1>
                    <p class="hero-subtitle animate__animated animate__fadeInUp">
                        {{ $aboutContent->hero_subtitle ?? 'At FruitsPage, we\'re passionate about bringing you the freshest, most nutritious organic produce directly from local farms to your doorstep. Since 2015, we\'ve been committed to healthy living and sustainable farming practices.' }}
                    </p>
                </div>
            </div>
        </div>
        
        <!-- Floating Elements -->
        <div class="floating-element fruit-1">
            <i class="fas fa-apple-alt"></i>
        </div>
        <div class="floating-element fruit-2">
            <i class="fas fa-lemon"></i>
        </div>
        <div class="floating-element fruit-3">
            <i class="fas fa-carrot"></i>
        </div>
        <div class="floating-element fruit-4">
            <i class="fas fa-pepper-hot"></i>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-6 stat-card animate-on-scroll">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $aboutContent->happy_customers ?? 50000 }}">{{ number_format($aboutContent->happy_customers ?? 50000) }}+</div>
                    <div class="stat-label">Happy Customers</div>
                </div>
                <div class="col-md-3 col-6 stat-card animate-on-scroll">
                    <div class="stat-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $aboutContent->deliveries_made ?? 150000 }}">{{ number_format($aboutContent->deliveries_made ?? 150000) }}+</div>
                    <div class="stat-label">Deliveries Made</div>
                </div>
                <div class="col-md-3 col-6 stat-card animate-on-scroll">
                    <div class="stat-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $aboutContent->local_farms ?? 200 }}">{{ number_format($aboutContent->local_farms ?? 200) }}+</div>
                    <div class="stat-label">Local Farms</div>
                </div>
                <div class="col-md-3 col-6 stat-card animate-on-scroll">
                    <div class="stat-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="stat-number" data-count="{{ $aboutContent->years_excellence ?? 8 }}">{{ $aboutContent->years_excellence ?? 8 }}+ Years</div>
                    <div class="stat-label">Of Excellence</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Mission -->
    <section class="content-section">
        <div class="container">
            <div class="row mb-5 animate-on-scroll">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">{{ $aboutContent->mission_title ?? 'Our Mission' }}</h2>
                    <p class="section-subtitle">
                        {{ $aboutContent->mission_subtitle ?? 'To make healthy, organic produce accessible to everyone while supporting sustainable farming practices and local communities.' }}
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                <div class="col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="{{ $aboutContent->feature1_icon ?? 'fas fa-seedling' }}"></i>
                        </div>
                        <h3 class="feature-title">{{ $aboutContent->feature1_title ?? 'Sustainable Farming' }}</h3>
                        <p class="feature-text">
                            {{ $aboutContent->feature1_text ?? 'We partner with local farmers who practice sustainable agriculture, ensuring minimal environmental impact while producing the highest quality organic fruits and vegetables.' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="{{ $aboutContent->feature2_icon ?? 'fas fa-heart' }}"></i>
                        </div>
                        <h3 class="feature-title">{{ $aboutContent->feature2_title ?? 'Health & Wellness' }}</h3>
                        <p class="feature-text">
                            {{ $aboutContent->feature2_text ?? 'We believe in the power of fresh, organic produce to transform lives. Our products are carefully selected for their nutritional value and superior taste.' }}
                        </p>
                    </div>
                </div>
                <div class="col-lg-4 animate-on-scroll">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="{{ $aboutContent->feature3_icon ?? 'fas fa-handshake' }}"></i>
                        </div>
                        <h3 class="feature-title">{{ $aboutContent->feature3_title ?? 'Community Support' }}</h3>
                        <p class="feature-text">
                            {{ $aboutContent->feature3_text ?? 'We\'re committed to supporting local communities by creating fair partnerships with farmers and contributing to local food security initiatives.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Team Section -->
    <section class="team-section">
        <div class="container">
            <div class="row mb-5 animate-on-scroll">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">{{ $aboutContent->team_title ?? 'Meet Our Team' }}</h2>
                    <p class="section-subtitle">
                        {{ $aboutContent->team_subtitle ?? 'Passionate individuals dedicated to bringing you the best organic produce experience.' }}
                    </p>
                </div>
            </div>
            
            <div class="row g-4">
                @forelse($teamMembers as $member)
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="team-card">
                        <img src="{{ $member->image_path ? asset('storage/' . $member->image_path) : 'https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80' }}" 
                             alt="{{ $member->role }}" class="team-img">
                        <div class="team-info">
                            <h3 class="team-name">{{ $member->name }}</h3>
                            <div class="team-role">{{ $member->role }}</div>
                            <p class="team-desc">
                                {{ $member->description }}
                            </p>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             alt="Founder & CEO" class="team-img">
                        <div class="team-info">
                            <h3 class="team-name">Alex Morgan</h3>
                            <div class="team-role">Founder & CEO</div>
                            <p class="team-desc">
                                12+ years in sustainable agriculture. Passionate about organic farming.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             alt="Head of Operations" class="team-img">
                        <div class="team-info">
                            <h3 class="team-name">Sarah Johnson</h3>
                            <div class="team-role">Head of Operations</div>
                            <p class="team-desc">
                                Ensures seamless delivery and quality control across all operations.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             alt="Farm Relations Manager" class="team-img">
                        <div class="team-info">
                            <h3 class="team-name">Michael Chen</h3>
                            <div class="team-role">Farm Relations Manager</div>
                            <p class="team-desc">
                                Builds and maintains relationships with our network of organic farmers.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 animate-on-scroll">
                    <div class="team-card">
                        <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80" 
                             alt="Customer Experience Lead" class="team-img">
                        <div class="team-info">
                            <h3 class="team-name">Emily Rodriguez</h3>
                            <div class="team-role">Customer Experience Lead</div>
                            <p class="team-desc">
                                Dedicated to ensuring every customer has an exceptional experience.
                            </p>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="values-section">
        <div class="container">
            <div class="row mb-5 animate-on-scroll">
                <div class="col-lg-8 mx-auto text-center">
                    <h2 class="section-title">{{ $aboutContent->values_title ?? 'Our Core Values' }}</h2>
                    <p class="section-subtitle">
                        {{ $aboutContent->values_subtitle ?? 'The principles that guide everything we do at FruitsPage.' }}
                    </p>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-4 value-item animate-on-scroll">
                    <div class="value-number">01</div>
                    <h3 class="value-title">{{ $aboutContent->value1_title ?? 'Quality First' }}</h3>
                    <p class="value-text">
                        {{ $aboutContent->value1_text ?? 'We never compromise on quality. Every product is carefully selected, inspected, and delivered at peak freshness.' }}
                    </p>
                </div>
                <div class="col-lg-4 value-item animate-on-scroll">
                    <div class="value-number">02</div>
                    <h3 class="value-title">{{ $aboutContent->value2_title ?? 'Sustainability' }}</h3>
                    <p class="value-text">
                        {{ $aboutContent->value2_text ?? 'We\'re committed to environmentally friendly practices from farm to delivery, minimizing waste and carbon footprint.' }}
                    </p>
                </div>
                <div class="col-lg-4 value-item animate-on-scroll">
                    <div class="value-number">03</div>
                    <h3 class="value-title">{{ $aboutContent->value3_title ?? 'Transparency' }}</h3>
                    <p class="value-text">
                        {{ $aboutContent->value3_text ?? 'We believe in complete transparency about our sourcing, pricing, and business practices.' }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="cta-title animate__animated animate__fadeInDown">
                        {{ $aboutContent->cta_title ?? 'Join Our Organic Journey' }}
                    </h2>
                    <p class="cta-text animate__animated animate__fadeInUp">
                        {{ $aboutContent->cta_text ?? 'Experience the difference of fresh, organic produce delivered to your doorstep. Join thousands of happy customers who\'ve made the switch to healthier living.' }}
                    </p>
                    <a href="{{ $aboutContent->cta_button_url ?? '#' }}" class="cta-btn animate__animated animate__pulse animate__infinite">
                        <i class="{{ $aboutContent->cta_button_icon ?? 'fas fa-shopping-basket' }}"></i> {{ $aboutContent->cta_button_text ?? 'Start Shopping' }}
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/about.js') }}"></script>
@endpush
