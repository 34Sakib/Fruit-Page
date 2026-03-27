@extends('backend.layouts.master')

@section('title', 'Edit Blog Tag')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Edit Blog Tag</h5>
                    <a href="{{ route('admin.blog.tags.show', $tag) }}" class="btn btn-outline-primary">
                        <i class="fas fa-eye me-2"></i>View Tag
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.blog.tags.update', $tag) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Name *</label>
                                    <input type="text" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           id="name" 
                                           name="name" 
                                           value="{{ old('name', $tag->name) }}" 
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" 
                                           class="form-control @error('slug') is-invalid @enderror" 
                                           id="slug" 
                                           name="slug" 
                                           value="{{ old('slug', $tag->slug) }}" 
                                           placeholder="Leave empty to generate automatically">
                                    <div class="form-text">URL-friendly version of the name</div>
                                    @error('slug')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">Tag Statistics</h6>
                                            <div class="row text-center">
                                                <div class="col-12">
                                                    <h4>{{ $tag->posts_count }}</h4>
                                                    <div class="text-muted">Posts with this tag</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="card-title">Tag Guidelines</h6>
                                        <ul class="mb-0">
                                            <li>Use descriptive, concise names</li>
                                            <li>Keep tags relevant to content</li>
                                            <li>Use lowercase for consistency</li>
                                            <li>Avoid special characters</li>
                                            <li>Consider using hyphens for multi-word tags</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.blog.tags.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tags
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Tag
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#name').on('input', function() {
        const slug = $(this).val()
            .toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
        
        if ($('#slug').val() === '' || $('#slug').val() === '{{ $tag->slug }}') {
            $('#slug').val(slug);
        }
    });
});
</script>
@endpush
