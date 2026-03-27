@extends('backend.layouts.master')

@section('title', 'Edit Review - Admin Panel')

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body, 
        .wrapper,
        .content-wrapper,
        .content-wrapper > .content,
        .content-wrapper > .content > .container,
        .content-wrapper > .content > .container-fluid {
            background-color: #f4f6f9 !important;
            color: #333 !important;
        }
        
        .card {
            border: 0;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 1rem 1.25rem;
        }
        
        .card-title {
            color: #4e73df;
            font-weight: 600;
            margin-bottom: 0;
            font-size: 1.1rem;
        }
        
        .form-control, .form-control:focus {
            border: 1px solid #d1d3e2;
            border-radius: 0.35rem;
            color: #6e707e;
        }
        
        .form-control:focus {
            border-color: #bac8f3;
            box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
        }
        
        .form-control:read-only {
            background-color: #eaecf4;
        }
        
        .custom-control-input:checked ~ .custom-control-label::before {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .custom-switch .custom-control-label::after {
            background-color: #fff;
        }
        
        .custom-control-label {
            color: #5a5c69;
        }
        
        .star-rating {
            font-size: 1.5rem;
            color: #ffc107;
        }
        
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2653d4;
        }
        
        .btn-outline-secondary {
            color: #5a5c69;
            border-color: #d1d3e2;
        }
        
        .btn-outline-secondary:hover {
            background-color: #eaeaea;
            border-color: #d1d3e2;
            color: #5a5c69;
        }
        
        label {
            color: #5a5c69;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .text-gray-800 {
            color: #5a5c69 !important;
        }
    </style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-star text-warning me-2"></i>Edit Review
        </h1>
        <a href="{{ route('admin.reviews.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50 me-1"></i> Back to Reviews
        </a>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Review: #{{ $review->id }}</h3>
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary float-right">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="product">Product</label>
                                    <input type="text" id="product" class="form-control" value="{{ $review->product->name }}" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user">User</label>
                                    <input type="text" id="user" class="form-control" value="{{ $review->name }} ({{ $review->email }})" readonly>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rating">Rating <span class="text-danger">*</span></label>
                                    <select name="rating" id="rating" class="form-control @error('rating') is-invalid @enderror" required>
                                        <option value="1" {{ $review->rating == 1 ? 'selected' : '' }}>⭐ (1 Star)</option>
                                        <option value="2" {{ $review->rating == 2 ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                                        <option value="3" {{ $review->rating == 3 ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                                        <option value="4" {{ $review->rating == 4 ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                                        <option value="5" {{ $review->rating == 5 ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                    </select>
                                    @error('rating')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="comment">Comment <span class="text-danger">*</span></label>
                                    <textarea name="comment" id="comment" rows="5" class="form-control @error('comment') is-invalid @enderror" required>{{ old('comment', $review->comment) }}</textarea>
                                    @error('comment')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="is_approved" name="is_approved" value="1" {{ $review->is_approved ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_approved">Approve this review</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Review
                            </button>
                            <a href="{{ route('admin.reviews.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
@endsection
