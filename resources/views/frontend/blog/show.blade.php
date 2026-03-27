@extends('frontend.layouts.master')

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/css/show.css') }}">
<style>
.post-content {
    line-height: 1.8;
    white-space: pre-wrap;
    font-family: inherit;
    font-size: 1.1rem;
    color: #374151;
    background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    border: 1px solid #e5e7eb;
    position: relative;
    overflow: hidden;
}

.post-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #10b981, #3b82f6, #8b5cf6);
    border-radius: 4px 4px 0 0;
}

.post-content br {
    margin-bottom: 1rem;
    display: block;
}

/* Enhanced typography for content */
.post-content {
    text-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
}

/* Add some visual hierarchy */
.post-content::first-line {
    font-weight: 500;
    color: #1f2937;
}

/* Add subtle animations */
.post-content {
    animation: fadeInUp 0.6s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Add hover effect for interactive feel */
.post-content:hover {
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    transform: translateY(-2px);
    transition: all 0.3s ease;
}

/* Make emojis and special characters stand out */
.post-content {
    font-variant-ligatures: common-ligatures;
}

/* Add reading progress indicator */
.reading-progress {
    position: sticky;
    top: 0;
    height: 3px;
    background: linear-gradient(90deg, #10b981, #3b82f6);
    border-radius: 3px;
    margin: -2rem -2rem 2rem -2rem;
    z-index: 10;
}
</style>
@endpush

@section('content')
    <!-- Reading Progress Bar -->
    <div class="progress-container">
        <div class="progress-bar" id="progressBar"></div>
    </div>

    <!-- Article Header -->
    <header class="article-header">
        <div class="article-header-content animate__animated animate__fadeInDown">
            @if($post->category)
            <span class="article-category animate__animated animate__fadeIn animate__delay-1s">
                <i class="fas fa-tag me-2"></i>{{ $post->category->name }}
            </span>
            @endif
            <h1 class="article-title">{{ $post->title }}</h1>
            
            <div class="article-meta animate__animated animate__fadeIn animate__delay-1s">
                <div class="meta-item">
                    <i class="far fa-calendar"></i>
                    <span>{{ $post->formatted_date }}</span>
                </div>
                <div class="meta-item">
                    <i class="far fa-clock"></i>
                    <span>{{ $post->reading_time }} min read</span>
                </div>
                <div class="meta-item">
                    <i class="far fa-eye"></i>
                    <span>{{ number_format($post->views ?? 0) }} views</span>
                </div>
                <div class="meta-item">
                    <i class="far fa-comment"></i>
                    <span>{{ $post->comments_count ?? 0 }} comments</span>
                </div>
            </div>
            
            <div class="author-info animate__animated animate__fadeIn animate__delay-2s">
                <img src="{{ $post->author->profile_image ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}" 
                     alt="{{ $post->author->name ?? 'Author' }}" class="author-img">
                <div class="author-details">
                    <h4>{{ $post->author->name ?? 'Admin' }}</h4>
                    <p>{{ $post->author->bio ?? 'Content Writer' }}</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="article-container">
        <div class="row">
            <!-- Article Content -->
            <div class="col-lg-8">
                <article class="article-content animate-on-scroll">
                    @if($post->featured_image)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                         alt="{{ $post->title }}" class="featured-image">
                    @endif
                    
                    <div class="article-body">
                        @if($post->excerpt)
                        <p class="lead">{{ $post->excerpt }}</p>
                        @endif
                        
                        <div class="post-content">
                            {!! nl2br($post->content) !!}
                        </div>
                        
                        <div class="social-share">
                            <span style="color: var(--text-dark); font-weight: 600; margin-right: 1rem;">Share this article:</span>
                            <a href="#" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" class="share-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" class="share-btn pinterest">
                                <i class="fab fa-pinterest-p"></i>
                            </a>
                            <a href="#" class="share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a href="#" class="share-btn whatsapp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                        </div>
                        
                        <div class="article-tags">
                            @forelse($post->tags as $tag)
                            <a href="#" class="tag">{{ $tag->name }}</a>
                            @empty
                            <span class="text-muted">No tags</span>
                            @endforelse
                        </div>
                    </div>
                </article>
                
                <!-- Author Bio -->
                <div class="author-bio animate-on-scroll">
                    <img src="{{ $post->author->profile_image ?? 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80' }}" 
                         alt="{{ $post->author->name ?? 'Author' }}" class="author-bio-img">
                    <div class="author-bio-content">
                        <h3>About the Author</h3>
                        <p>{{ $post->author->bio ?? 'Content writer and contributor to the FruitMart blog.' }}</p>
                        <div class="author-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                        </div>
                    </div>
                </div>
                
                <!-- Comments Section -->
                <div class="comments-section animate-on-scroll">
                    <h3 class="section-title">Comments ({{ $post->comments_count ?? 0 }})</h3>
                    
                    @forelse($post->comments ?? [] as $comment)
                    <div class="comment">
                        <img src="{{ $comment->author->profile_image ?? 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80' }}" 
                             alt="{{ $comment->author->name }}" class="comment-avatar">
                        <div class="comment-content">
                            <h4>{{ $comment->author->name }}</h4>
                            <div class="comment-meta">{{ $comment->formatted_date }}</div>
                            <p class="comment-text">{{ $comment->content }}</p>
                            <button class="reply-btn">Reply</button>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted">No comments yet.</p>
                    @endforelse
                    
                    <!-- Comment Form -->
                    <div class="comment-form animate-on-scroll">
                        <h4>Leave a Comment</h4>
                        <form id="commentForm">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Name *</label>
                                        <input type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">Email *</label>
                                        <input type="email" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Comment *</label>
                                <textarea class="form-control" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="submit-btn">
                                <i class="fas fa-paper-plane me-2"></i>Post Comment
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Newsletter -->
                <div class="article-newsletter animate-on-scroll">
                    <h3 class="newsletter-title">Stay Updated</h3>
                    <p>Get weekly health tips and nutrition advice delivered to your inbox</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Your email address" required>
                        <button type="submit" class="submit-btn" style="width: 100%;">
                            <i class="fas fa-envelope me-2"></i>Subscribe Now
                        </button>
                    </form>
                </div>
                
                <!-- Related Posts -->
                <div class="related-posts animate-on-scroll">
                    <h3 class="section-title">Related Articles</h3>
                    <div class="related-grid">
                        @forelse($relatedPosts as $relatedPost)
                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="related-card">
                            <img src="{{ $relatedPost->featured_image ? asset('storage/' . $relatedPost->featured_image) : 'https://images.unsplash.com/photo-1518843875459-f738682238a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80' }}" 
                                 alt="{{ $relatedPost->title }}" class="related-img">
                            <div class="related-content">
                                <h4 class="related-title">{{ Str::limit($relatedPost->title, 50) }}</h4>
                                <div class="related-meta">{{ $relatedPost->formatted_date }} • {{ $relatedPost->reading_time }} min read</div>
                            </div>
                        </a>
                        @empty
                        <p class="text-muted">No related posts found.</p>
                        @endforelse
                    </div>
                </div>
                
                <!-- Popular Tags -->
                <div class="sidebar animate-on-scroll" style="margin-top: 2rem;">
                    <h3 class="section-title">Popular Tags</h3>
                    <div class="article-tags">
                        @forelse($popularTags as $tag)
                        <a href="#" class="tag">{{ $tag->name }}</a>
                        @empty
                        <span class="text-muted">No popular tags.</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Back to Blog -->
        <div class="back-to-blog animate-on-scroll">
            <a href="{{ route('blog.index') }}" class="back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to Blog
            </a>
        </div>
    </div>
@endsection

@push('scripts')
<script src="{{ asset('frontend/js/show.js') }}"></script>
<script>
// Enhanced reading experience
document.addEventListener('DOMContentLoaded', function() {
    // Reading progress indicator
    const progressBar = document.getElementById('progressBar');
    const postContent = document.querySelector('.post-content');
    
    if (progressBar && postContent) {
        function updateReadingProgress() {
            const scrollTop = window.pageYOffset;
            const docHeight = document.documentElement.scrollHeight;
            const winHeight = window.innerHeight;
            const scrollPercent = (scrollTop / (docHeight - winHeight)) * 100;
            
            progressBar.style.width = scrollPercent + '%';
        }
        
        window.addEventListener('scroll', updateReadingProgress);
        updateReadingProgress();
    }
    
    // Add smooth scrolling for better reading experience
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
    
    // Add reading time estimation
    const content = postContent?.innerText || '';
    const wordsPerMinute = 200;
    const wordCount = content.trim().split(/\s+/).length;
    const readingTime = Math.ceil(wordCount / wordsPerMinute);
    
    // Update reading time display if element exists
    const readingTimeElement = document.querySelector('.reading-time');
    if (readingTimeElement) {
        readingTimeElement.textContent = readingTime + ' min read';
    }
});
</script>
@endpush