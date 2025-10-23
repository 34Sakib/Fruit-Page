@extends('backend.layouts.master')

@section('title', 'View Product - FruitMart Admin')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Product Details</h3>
            <div class="card-tools">
                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-primary">
                    <i class="fas fa-edit"></i> Edit
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-4">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 300px;">
                    </div>
                </div>
                <div class="col-md-8">
                    <h2>{{ $product->name }}</h2>
                    
                    <div class="mb-3">
                        <span class="badge {{ $product->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($product->status) }}
                        </span>
                        <span class="badge bg-info">
                            {{ $product->category->name ?? 'Uncategorized' }}
                        </span>
                    </div>

                    <div class="mb-4">
                        <h4 class="text-primary">
                            ${{ number_format($product->price, 2) }}
                            @if($product->sale_price)
                                <del class="text-muted">${{ number_format($product->sale_price, 2) }}</del>
                            @endif
                        </h4>
                        <p class="mb-0">
                            <strong>In Stock:</strong> {{ $product->quantity }} items
                        </p>
                    </div>

                    <div class="border-top border-bottom py-3 mb-4">
                        <h5>Description</h5>
                        <p class="mb-0">{{ $product->description ?? 'No description available.' }}</p>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h5>Product Information</h5>
                            <ul class="list-unstyled">
                                <li><strong>SKU:</strong> #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</li>
                                <li><strong>Created:</strong> {{ $product->created_at->format('M d, Y') }}</li>
                                <li><strong>Last Updated:</strong> {{ $product->updated_at->format('M d, Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>
</div>
@endsection
