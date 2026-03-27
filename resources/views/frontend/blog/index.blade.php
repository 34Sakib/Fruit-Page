@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/blog.css') }}">
@endpush

@section('content')
    <!-- Header -->
    <header class="blog-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-newspaper"></i>
            </div>
            <h1 class="blog-title animate__animated animate__fadeInDown">Organic Living Blog</h1>
            <p class="blog-subtitle animate__animated animate__fadeInUp">
                Discover tips, recipes, and insights for a healthier, more sustainable lifestyle. 
                Fresh perspectives on organic living.
            </p>
        </div>
    </header>

    <!-- Main Content -->
    <div class="blog-container">
        <div class="row">
            <!-- Main Blog Area -->
            <div class="col-lg-8">
                <!-- Featured Posts -->
                @if($featuredPosts->count() > 0)
                <div class="featured-slider">
                    <div class="row">
                        @foreach($featuredPosts as $post)
                        <div class="col-md-6 mb-4">
                            <div class="featured-post animate__animated animate__fadeInLeft">
                                <div class="position-relative">
                                    <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                                         alt="{{ $post->title }}" class="featured-img">
                                    <span class="featured-badge">Featured</span>
                                </div>
                                <div class="featured-content">
                                    <div class="featured-meta">
                                        <span><i class="fas fa-calendar"></i> {{ $post->formatted_date }}</span>
                                        <span><i class="fas fa-clock"></i> {{ $post->reading_time }} min read</span>
                                    </div>
                                    <h2 class="featured-title">{{ $post->title }}</h2>
                                    <p class="featured-excerpt">
                                        {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 150) }}
                                    </p>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="read-more">
                                        Read Article <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Blog Grid -->
                <div class="blog-grid">
                    @forelse($posts as $post)
                    <article class="blog-card animate-delay-{{ $loop->iteration % 4 + 1 }}">
                        <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $post->title }}" class="card-img">
                        <div class="card-content">
                            @if($post->category)
                            <span class="card-category">{{ $post->category->name }}</span>
                            @endif
                            <h3 class="card-title">{{ $post->title }}</h3>
                            <p class="card-excerpt">
                                {{ Str::limit(strip_tags($post->excerpt ?? $post->content), 120) }}
                            </p>
                            <div class="card-meta">
                                <div class="card-author">
                                    <img src="{{ $post->author->profile_image ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}" 
                                         alt="{{ $post->author->name ?? 'Author' }}" class="author-img">
                                    <span>{{ $post->author->name ?? 'Admin' }}</span>
                                </div>
                                <span><i class="far fa-clock"></i> {{ $post->reading_time }} min read</span>
                            </div>
                        </div>
                    </article>
                    @empty
                    <div class="col-12">
                        <p class="text-center text-muted">No blog posts found.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="blog-pagination">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Categories -->
                <div class="sidebar animate__animated animate__fadeInRight">
                    <h3 class="sidebar-title">Categories</h3>
                    <ul class="category-list">
                        @forelse($categories as $category)
                        <li class="category-item">
                            <a href="{{ route('blog.category', $category->slug) }}" class="category-link">
                                <span>{{ $category->name }}</span>
                                <span class="category-count">{{ $category->posts_count ?? 0 }}</span>
                            </a>
                        </li>
                        @empty
                        <li class="category-item">
                            <span class="text-muted">No categories found</span>
                        </li>
                        @endforelse
                    </ul>
                </div>

                <!-- Recent Posts -->
                <div class="sidebar animate__animated animate__fadeInRight animate__delay-1s">
                    <h3 class="sidebar-title">Recent Posts</h3>
                    @forelse($featuredPosts->take(3) as $post)
                    <div class="recent-post">
                        <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=150&q=80' }}" 
                             alt="{{ $post->title }}" class="recent-img">
                        <div>
                            <h4 class="recent-title">{{ Str::limit($post->title, 40) }}</h4>
                            <div class="recent-date">{{ $post->formatted_date }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">No recent posts found.</p>
                    @endforelse
                </div>

                <!-- Newsletter -->
                <div class="newsletter-box animate__animated animate__fadeInRight animate__delay-2s">
                    <h3 class="newsletter-title">Stay Updated</h3>
                    <p>Get the latest blog posts delivered to your inbox</p>
                    <form id="newsletterForm">
                        <input type="email" class="newsletter-input" placeholder="Your email address" required>
                        <button type="submit" class="newsletter-btn">
                            <i class="fas fa-envelope me-2"></i> Subscribe
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script src="{{ asset('frontend/js/blog.js') }}"></script>
@endpush