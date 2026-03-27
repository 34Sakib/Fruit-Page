@extends('backend.layouts.master')

@section('title', 'View Blog Category')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ $category->name }}</h5>
                    <div>
                        <a href="{{ route('admin.blog.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('blog.category', $category->slug) }}" target="_blank" class="btn btn-outline-primary">
                            <i class="fas fa-external-link-alt me-2"></i>View on Site
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            @if($category->description)
                                <div class="mb-4">
                                    <h6>Description</h6>
                                    <p>{{ $category->description }}</p>
                                </div>
                            @endif

                            <h6>Recent Posts in this Category</h6>
                            @if($category->posts->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Author</th>
                                                <th>Status</th>
                                                <th>Published</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($category->posts as $post)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.blog.posts.show', $post) }}">
                                                        {{ Str::limit($post->title, 50) }}
                                                    </a>
                                                </td>
                                                <td>{{ $post->author->name }}</td>
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
                                    <a href="{{ route('admin.blog.posts.index') }}?category={{ $category->id }}" 
                                       class="btn btn-outline-primary">
                                        <i class="fas fa-list me-2"></i>View All Posts
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                    <h6 class="text-muted">No posts in this category yet</h6>
                                    <a href="{{ route('admin.blog.posts.create') }}?category={{ $category->id }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create First Post
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="mb-0">Category Details</h6>
                                </div>
                                <div class="card-body">
                                    <table class="table table-sm">
                                        <tr>
                                            <th>Name:</th>
                                            <td>{{ $category->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Slug:</th>
                                            <td><code>{{ $category->slug }}</code></td>
                                        </tr>
                                        <tr>
                                            <th>Posts Count:</th>
                                            <td>
                                                <span class="badge bg-info">{{ $category->posts_count }}</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created:</th>
                                            <td>{{ $category->created_at->format('M j, Y \a\t g:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Updated:</th>
                                            <td>{{ $category->updated_at->format('M j, Y \a\t g:i A') }}</td>
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
                                        <a href="{{ route('admin.blog.categories.edit', $category) }}" 
                                           class="btn btn-warning">
                                            <i class="fas fa-edit me-2"></i>Edit Category
                                        </a>
                                        <a href="{{ route('admin.blog.posts.create') }}?category={{ $category->id }}" 
                                           class="btn btn-success">
                                            <i class="fas fa-plus me-2"></i>New Post in Category
                                        </a>
                                        <a href="{{ route('blog.category', $category->slug) }}" 
                                           target="_blank" 
                                           class="btn btn-outline-primary">
                                            <i class="fas fa-external-link-alt me-2"></i>View on Site
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.blog.categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Categories
                        </a>
                        <a href="{{ route('admin.blog.categories.edit', $category) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
