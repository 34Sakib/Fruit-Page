@extends('backend.layouts.master')

@section('title', 'View Blog Post')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $post->title }}</h5>
                    <div>
                        <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-2"></i>View on Site
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @if($post->featured_image)
                                <div class="mb-4">
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                         alt="{{ $post->title }}" 
                                         class="img-fluid rounded">
                                </div>
                            @endif

                            <div class="post-content">
                                {!! $post->content !!}
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Post Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($post->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Author:</th>
                                            <td>{{ $post->author->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Category:</th>
                                            <td>
                                                @if($post->category)
                                                    <span class="badge bg-info">{{ $post->category->name }}</span>
                                                @else
                                                    <span class="text-muted">No category</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Slug:</th>
                                            <td><code>{{ $post->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Published:</th>
                                            <td>
                                                @if($post->published_at)
                                                    {{ $post->published_at->format('M j, Y \a\t g:i A') }}
                                                @else
                                                    <span class="text-muted">Not published</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $post->created_at->format('M j, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated:</th>
                                            <td>{{ $post->updated_at->format('M j, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Statistics</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h4>{{ number_format($post->views) }}</h4>
                                            <div class="text-muted">Views</div>
                                        </div>
                                        <div class="col-6">
                                            <h4>{{ $post->comments_count ?? 0 }}</h4>
                                            <div class="text-muted">Comments</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($post->tags->count() > 0)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Tags</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($post->tags as $tag)
                                            <span class="badge bg-light text-dark me-1 mb-1">{{ $tag->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($post->excerpt)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Excerpt</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $post->excerpt }}</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.blog.posts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Posts
                        </a>
                        <a href="{{ route('admin.blog.posts.edit', $post) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Post
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.post-content {
    line-height: 1.6;
}

.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6 {
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.post-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.post-content blockquote {
    border-left: 4px solid #007bff;
    padding-left: 1rem;
    margin: 1rem 0;
    font-style: italic;
}

.post-content ul, .post-content ol {
    margin: 1rem 0;
    padding-left: 2rem;
}

.post-content code {
    background-color: #f8f9fa;
    padding: 0.2rem 0.4rem;
    border-radius: 3px;
    font-family: 'Courier New', monospace;
}

.post-content pre {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 5px;
    overflow-x: auto;
}
</style>
@endpush
