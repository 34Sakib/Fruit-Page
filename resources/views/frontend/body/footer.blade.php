<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-4">
    <div class="container">
        <!-- Footer Main Content -->
        <div class="row g-4">
            <!-- Company Info & Newsletter -->
            <div class="col-lg-4 col-md-6">
                <div class="footer-brand mb-4">
                    <div class="d-flex align-items-center mb-3">
                        @if(isset($footerData->logo) && $footerData->logo)
                            <img src="{{ asset('storage/' . $footerData->logo) }}" alt="{{ $footerData->title ?? 'GreenRootMart' }}" class="me-3" style="max-height: 40px; width: auto;">
                        @else
                            <div class="me-3">
                                <i class="fas fa-leaf fa-2x text-success"></i>
                            </div>
                        @endif
                        <h4 class="mb-0 fw-bold">{{ $footerData->title ?? 'GreenRootMart' }}</h4>
                    </div>
                    <p class="mb-3">{{ $footerData->description ?? 'Where trust, clarity, and connection live. Your trusted destination for fresh, organic groceries delivered with care.' }}</p>
                    
                    <!-- Newsletter Section -->
                    <div class="newsletter-section bg-dark bg-opacity-50 p-3 rounded">
                        <h6 class="fw-bold mb-3"><i class="fas fa-envelope me-2"></i>Stay Updated</h6>
                        <form class="newsletter-form" action="" method="POST">
                            @csrf
                            <div class="input-group">
                                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                                <button class="btn btn-success" type="submit">
                                    <i class="fas fa-paper-plane"></i>
                                </button>
                            </div>
                        </form>
                        <small class="text-muted mt-2 d-block">Get exclusive offers and updates</small>
                    </div>
                </div>
                
                <!-- Social Media -->
                <div class="social-links mt-4">
                    <h6 class="fw-bold mb-3">Follow Us</h6>
                    <div class="d-flex gap-2">
                        @if($footerData && ($footerData->facebook_url || $footerData->twitter_url || $footerData->instagram_url || $footerData->youtube_url || $footerData->linkedin_url))
                            @if($footerData->facebook_url)
                                <a href="{{ $footerData->facebook_url }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif
                            @if($footerData->twitter_url)
                                <a href="{{ $footerData->twitter_url }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
                                    <i class="fab fa-twitter"></i>
                                </a>
                            @endif
                            @if($footerData->instagram_url)
                                <a href="{{ $footerData->instagram_url }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif
                            @if($footerData->youtube_url)
                                <a href="{{ $footerData->youtube_url }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
                                    <i class="fab fa-youtube"></i>
                                </a>
                            @endif
                            @if($footerData->linkedin_url)
                                <a href="{{ $footerData->linkedin_url }}" target="_blank" class="btn btn-outline-light btn-sm rounded-circle">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                            @endif
                        @else
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                                <i class="fab fa-youtube"></i>
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm rounded-circle">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Categories -->
            <div class="col-lg-5 col-md-6">
                <h6 class="fw-bold mb-3">Shop Categories</h6>
                <ul class="list-unstyled footer-links">
                    @php
                        $footerCategories = \App\Models\Category::where('status', 'active')
                            ->orderBy('order', 'asc')
                            ->take(6)
                            ->get();
                        $categoryIcons = [
                            'fruits' => 'apple-alt',
                            'vegetables' => 'carrot',
                            'dairy' => 'cheese',
                            'bakery' => 'bread-slice',
                            'grains' => 'wheat',
                            'beverages' => 'coffee',
                            'meat' => 'drumstick-bite',
                            'seafood' => 'fish',
                            'snacks' => 'cookie',
                            'spices' => 'pepper-hot',
                            'default' => 'shopping-bag'
                        ];
                    @endphp
                    @foreach($footerCategories as $category)
                        @php
                            $icon = $categoryIcons[strtolower($category->name)] ?? $categoryIcons['default'];
                        @endphp
                        <li class="mb-2">
                            <a href="{{ route('category', $category->slug) }}" class="text-white-50 text-decoration-none hover-white">
                                <i class="fas fa-{{ $icon }} me-2 fa-xs"></i>{{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact Info & Policies -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Contact Info</h6>
                <div class="contact-info mb-4">
                    <div class="d-flex mb-2">
                        <i class="fas fa-map-marker-alt me-3 text-success mt-1"></i>
                        <span class="text-white-50">{{ $footerData->address ?? 'Kuril, Dhaka, Bangladesh' }}</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-phone-alt me-3 text-success mt-1"></i>
                        <span class="text-white-50">{{ $footerData->phone ?? '+8801641555173' }}</span>
                    </div>
                    <div class="d-flex mb-2">
                        <i class="fas fa-envelope me-3 text-success mt-1"></i>
                        <span class="text-white-50">{{ $footerData->email ?? 'info@fruitmart.com' }}</span>
                    </div>
                    <div class="d-flex">
                        <i class="fas fa-clock me-3 text-success mt-1"></i>
                        <span class="text-white-50">Mon-Sat: 9AM-8PM</span>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">Policies</h6>
                <ul class="list-unstyled footer-links">
                    <li class="mb-2"><a href="{{ url('/privacy-policy') }}" class="text-white-50 text-decoration-none hover-white"><i class="fas fa-shield-alt me-2 fa-xs"></i>Privacy Policy</a></li>
                    <li class="mb-2"><a href="{{ url('/terms-conditions') }}" class="text-white-50 text-decoration-none hover-white"><i class="fas fa-file-contract me-2 fa-xs"></i>Terms & Conditions</a></li>
                    <li class="mb-2"><a href="{{ url('/shipping-policy') }}" class="text-white-50 text-decoration-none hover-white"><i class="fas fa-truck me-2 fa-xs"></i>Shipping Policy</a></li>
                    <li class="mb-2"><a href="{{ url('/return-policy') }}" class="text-white-50 text-decoration-none hover-white"><i class="fas fa-undo me-2 fa-xs"></i>Return Policy</a></li>
                </ul>
            </div>
        </div>

        <!-- Payment Methods -->
        <div class="border-top border-secondary pt-4 mt-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="fw-bold mb-3">We Accept</h6>
                    <div class="payment-methods d-flex gap-2 flex-wrap">
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fab fa-cc-visa text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fab fa-cc-mastercard text-danger" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fab fa-cc-amex text-info" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fab fa-cc-paypal text-blue" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fab fa-stripe text-purple" style="font-size: 1.5rem;"></i>
                        </div>
                        <div class="payment-icon bg-white p-2 rounded">
                            <i class="fas fa-mobile-alt text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="app-download">
                        <h6 class="fw-bold mb-3">Download Our App</h6>
                        <div class="d-flex gap-2 justify-content-md-end">
                            <a href="#" class="btn btn-outline-light btn-sm">
                                <i class="fab fa-google-play me-2"></i>Google Play
                            </a>
                            <a href="#" class="btn btn-outline-light btn-sm">
                                <i class="fab fa-app-store me-2"></i>App Store
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="border-top border-secondary pt-3 mt-3 text-center">
            <p class="mb-0 text-white-50">
                &copy; {{ date('Y') }} {{ $footerData->copyright_text ?? 'GreenRootMart' }}. All Rights Reserved. | 
                <a href="{{ url('/sitemap') }}" class="text-white-50 text-decoration-none">Sitemap</a> | 
                <a href="{{ url('/accessibility') }}" class="text-white-50 text-decoration-none">Accessibility</a>
            </p>
        </div>
    </div>
</footer>

<!-- Footer Styles -->
<style rel="stylesheet" href="{{ asset('frontend/css/footer.css') }}"></style>