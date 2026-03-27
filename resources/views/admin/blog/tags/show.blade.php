@extends('backend.layouts.master')

@section('title', 'View Blog Tag')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">
                        <span class="badge bg-light text-dark me-2">{{ $tag->name }}</span>
                        Tag Details
                    </h5>
                    <div>
                        <a href="{{ route('admin.blog.tags.edit', $tag) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6>Posts with this Tag</h6>
                            @if($tag->posts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Category</th>
                                                <th>Status</th>
                                                <th>Published</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($tag->posts as $post)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.blog.posts.show', $post) }}">
                                                        {{ Str::limit($post->title, 50) }}
                                                    </a>
                                                </td>
                                                <td>{{ $post->author->name }}</td>
                                                <td>
                                                    @if($post->category)
                                                        <span class="badge bg-info">{{ $post->category->name }}</span>
                                                    @else
                                                        <span class="text-muted">No category</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $post->status === 'published' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($post->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($post->published_at)
                                                        {{ $post->published_at->format('M j, Y') }}
                                                    @else
                                                        <span class="text-muted">Not published</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.blog.posts.edit', $post) }}" 
                                                       class="btn btn-sm btn-outline-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="mt-3">
                                    <a href="{{ route('admin.blog.posts.index') }}?tag={{ $tag->id }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-list me-2"></i>View All Posts with Tag
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No posts with this tag yet</h6>
                                    <a href="{{ route('admin.blog.posts.create') }}?tags={{ $tag->id }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create Post with Tag
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Tag Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>
                                                <span class="badge bg-light text-dark">{{ $tag->name }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Slug:</th>
                                            <td><code>{{ $tag->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Posts Count:</th>
                                            <td>
                                                <span class="badge bg-info">{{ $tag->posts_count }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $tag->created_at->format('M j, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated:</th>
                                            <td>{{ $tag->updated_at->format('M j, Y \a\t g:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="card mt-3">
                                <div class="card-header">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <a href="{{ route('admin.blog.tags.edit', $tag) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Edit Tag
                                        </a>
                                        <a href="{{ route('admin.blog.posts.create') }}?tags={{ $tag->id }}" 
                                           class="btn btn-success">
                                            <i class="fas fa-plus me-2"></i>New Post with Tag
                                        </a>
                                    </div>
                                </div>
                            </div>

                            @if($tag->posts_count > 0)
                                <div class="card mt-3">
                                    <div class="card-header">
                                        <h6 class="mb-0">Tag Usage</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center">
                                            <h4>{{ $tag->posts_count }}</h4>
                                            <div class="text-muted">Posts use this tag</div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tags
                        </a>
                        <a href="{{ route('admin.blog.tags.edit', $tag) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Tag
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
