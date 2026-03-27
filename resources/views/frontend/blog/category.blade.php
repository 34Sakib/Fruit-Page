@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/blog.css') }}">
@endpush

@section('content')
    <!-- Header -->
    <header class="blog-header">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-folder"></i>
            </div>
            <h1 class="blog-title animate__animated animate__fadeInDown">{{ $category->name }}</h1>
            <p class="blog-subtitle animate__animated animate__fadeInUp">
                {{ $category->description ?? 'Explore all posts in ' . $category->name . ' category.' }}
            </p>
            <div class="category-stats animate__animated animate__fadeIn animate__delay-1s">
                <span class="stat-item">
                    <i class="fas fa-file-alt"></i>
                    {{ $posts->total() }} Articles
                </span>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="blog-container">
        <div class="row">
            <!-- Main Blog Area -->
            <div class="col-lg-8">
                <!-- Blog Grid -->
                <div class="blog-grid">
                    @forelse($posts as $post)
                    <article class="blog-card animate-delay-{{ $loop->iteration % 4 + 1 }}">
                        <img src="{{ $post->featured_image ? asset('storage/' . $post->featured_image) : 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' }}" 
                             alt="{{ $post->title }}" class="card-img">
                        <div class="card-content">
                            <span class="card-category">{{ $post->category->name }}</span>
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
                        <div class="text-center py-5">
                            <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                            <h4 class="text-muted">No posts found in this category</h4>
                            <p class="text-muted">Check back later for new content in {{ $category->name }}</p>
                            <a href="{{ route('blog.index') }}" class="btn btn-primary mt-3">
                                <i class="fas fa-arrow-left me-2"></i>Back to Blog
                            </a>
                        </div>
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
                <!-- Back to Blog -->
                <div class="sidebar animate__animated animate__fadeInRight">
                    <a href="{{ route('blog.index') }}" class="back-to-blog-btn">
                        <i class="fas fa-arrow-left me-2"></i>Back to All Posts
                    </a>
                </div>

                <!-- Newsletter -->
                <div class="newsletter-box animate__animated animate__fadeInRight animate__delay-1s">
                    <h3 class="newsletter-title">Stay Updated</h3>
                    <p>Get the latest {{ $category->name }} posts delivered to your inbox</p>
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
