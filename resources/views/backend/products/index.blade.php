@extends('backend.layouts.master')

@section('title', 'Manage Products')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .table td {
        vertical-align: middle !important;
    }

    table.table td,
    table.table th {
        vertical-align: middle !important;
        padding: 8px 10px !important;
        font-size: 14px;
    }

    td:nth-child(3) { max-width: 200px; word-break: break-word; }
    td:nth-child(4) { max-width: 150px; }
    td:nth-child(5) { min-width: 120px; }
    td:nth-child(6) { min-width: 100px; }
    td:nth-child(7) { min-width: 100px; }

    @media (max-width: 768px) {
        .table td:nth-child(2) > div > div {
            width: 80px !important;
            height: 60px !important;
        }
        td:nth-child(3), 
        td:nth-child(4),
        td:nth-child(5),
        td:nth-child(6) { 
            max-width: 120px; 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Products</h3>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Product
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Featured</th>
                                    <th>Top Product</th>
                                    <th>Status</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($products as $product)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <div style="width: 80px; height: 60px; overflow: hidden;" class="d-flex align-items-center justify-content-center border rounded">
                                                    @if($product->image_url)
                                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @else
                                                        <img src="{{ asset('images/default-product.png') }}" alt="No Image" class="img-fluid h-100 w-100" style="object-fit: cover;">
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        
                                        <td>
                                            @if($product->sale_price && $product->sale_price < $product->price)
                                                <span class="text-success">${{ number_format($product->sale_price, 2) }}</span>
                                                <br><small class="text-muted"><del>${{ number_format($product->price, 2) }}</del></small>
                                            @else
                                                ${{ number_format($product->price, 2) }}
                                            @endif
                                        </td>
                                        
                                        <td>{{ $product->quantity }}</td>

                                        <td>
                                            <span class="badge {{ $product->is_featured ? 'bg-primary' : 'bg-secondary' }}">
                                                {{ $product->is_featured ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge {{ $product->is_top_product ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $product->is_top_product ? 'Yes' : 'No' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="badge {{ $product->status == 'active' ? 'badge-success' : 'badge-secondary' }}">
                                                {{ ucfirst($product->status) }}
                                            </span>
                                        </td>

                                        <td>
                                            <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}" 
                                                method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this product?')"
                                                    title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($products->hasPages())
                        <div class="card-footer clearfix">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
