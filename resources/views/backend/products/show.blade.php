@extends('backend.layouts.master')

@section('title', 'View Product - FruitMart Admin')

@push('styles')
<style>
    .product-image {
            max-width: 200px;
            max-height: 150px;
            margin-top: 10px;
    }
    .info-label {
        font-weight: 600;
        color: #6c757d;
        min-width: 120px;
        display: inline-block;
    }
    .info-value {
        color: #4e73df;
    }
    .badge {
        font-size: 0.8rem;
        font-weight: 600;
        padding: 0.35em 0.65em;
    }
    .a4-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
        background: white;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        border-radius: 6px;
    }
    .card {
        box-shadow: none;
        border: none;
        border-radius: 0;
    }
</style>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="a4-container">
                <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Product Details: {{ $product->name }}</h3>
                        <div>
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Product
                            </a>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="text-center">
                                <img src="{{ $product->image_url }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-image img-fluid mb-4">
                                
                                <div class="d-flex justify-content-center mb-4">
                                    <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }} me-2">
                                        <i class="fas {{ $product->status == 'active' ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ ucfirst($product->status) }}
                                    </span>
                                    <span class="badge bg-info">
                                        <i class="fas fa-tag"></i>
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </span>
                                </div>

                                <div class="pricing-box mb-4">
                                    <h3 class="text-primary mb-1">
                                        @if($product->sale_price && $product->sale_price < $product->price)
                                            <span class="text-success">${{ number_format($product->sale_price, 2) }}</span>
                                            <del class="text-muted small d-block">${{ number_format($product->price, 2) }}</del>
                                        @else
                                            ${{ number_format($product->price, 2) }}
                                        @endif
                                    </h3>
                                    <p class="mb-0">
                                        <span class="badge {{ $product->quantity > 0 ? 'bg-success' : 'bg-danger' }}">
                                            <i class="fas {{ $product->quantity > 0 ? 'fa-check' : 'fa-times' }}"></i>
                                            {{ $product->quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                        </span>
                                        <span class="ms-2">{{ $product->quantity }} items available</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="mb-4">
                                <h4 class="mb-3">Product Information</h4>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <td class="w-25"><strong>SKU</strong></td>
                                                <td>#{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Name</strong></td>
                                                <td>{{ $product->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Category</strong></td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Status</strong></td>
                                                <td>
                                                    <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ ucfirst($product->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Featured</strong></td>
                                                <td>
                                                    <span class="badge {{ $product->is_featured ? 'bg-primary' : 'bg-secondary' }}">
                                                        {{ $product->is_featured ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Top Product</strong></td>
                                                <td>
                                                    <span class="badge {{ $product->is_top_product ? 'bg-success' : 'bg-secondary' }}">
                                                        {{ $product->is_top_product ? 'Yes' : 'No' }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Created</strong></td>
                                                <td>{{ $product->created_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated</strong></td>
                                                <td>{{ $product->updated_at->format('M d, Y h:i A') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="mb-4">
                                <h5 class="mb-3">Description</h5>
                                <div class="p-3 bg-light rounded">
                                    {!! $product->description ? nl2br(e($product->description)) : '<span class="text-muted">No description available.</span>' !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                        <i class="fas fa-edit"></i> Edit Product
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
