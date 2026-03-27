@extends('backend.layouts.master')

@section('title', 'Blog Posts')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Blog Posts</h5>
                    <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Post
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Author</th>
                                    <th>Status</th>
                                    <th>Published</th>
                                    <th>Views</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($posts as $post)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($post->featured_image)
                                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                                     alt="{{ $post->title }}" 
                                                     class="me-3" 
                                                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                            @endif
                                            <div>
                                                <strong>{{ Str::limit($post->title, 50) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ $post->slug }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($post->category)
                                            <span class="badge bg-info">{{ $post->category->name }}</span>
                                        @else
                                            <span class="text-muted">No category</span>
                                        @endif
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
                                    <td>{{ number_format($post->views) }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.blog.posts.show', $post) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.blog.posts.edit', $post) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-info toggle-status-btn"
                                                    data-id="{{ $post->id }}"
                                                    data-status="{{ $post->status }}"
                                                    title="Toggle Status">
                                                <i class="fas fa-power-off"></i>
                                            </button>
                                            <form action="{{ route('admin.blog.posts.destroy', $post) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger delete-btn"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">No blog posts found</h5>
                                        <p class="text-muted">Create your first blog post to get started.</p>
                                        <a href="{{ route('admin.blog.posts.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create Post
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            <small class="text-muted">
                                Showing {{ $posts->firstItem() }} to {{ $posts->lastItem() }} of {{ $posts->total() }} entries
                            </small>
                        </div>
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.toggle-status-btn').on('click', function() {
        const btn = $(this);
        const postId = btn.data('id');
        const currentStatus = btn.data('status');
        
        if (confirm('Are you sure you want to ' + (currentStatus === 'published' ? 'unpublish' : 'publish') + ' this post?')) {
            $.ajax({
                url: '{{ route("admin.blog.posts.toggle-status", ":id") }}'.replace(':id', postId),
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function() {
                    alert('An error occurred while updating the post status.');
                }
            });
        }
    });

    $('.delete-btn').on('click', function(e) {
        if (!confirm('Are you sure you want to delete this post? This action cannot be undone.')) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
