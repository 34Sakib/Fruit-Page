@extends('backend.layouts.master')

@section('title', isset($product) ? 'Edit Product' : 'Create Product')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

<style>
    .form-control:focus, .select2-container--bootstrap4 .select2-selection--single:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    .custom-file-label::after {
        content: "Browse";
    }
    .preview-image {
            max-width: 200px;
            max-height: 150px;
            margin-top: 10px;
    }
    .image-preview-container {
        margin-top: 10px;
    }
    .image-preview-item {
        position: relative;
        display: inline-block;
        margin: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 5px;
    }
    .image-preview-item img {
        max-width: 40px !important;
        max-height: 40px !important;
        width: 40px !important;
        height: 40px !important;
        display: block;
        object-fit: cover;
    }
    .remove-image {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        border: none;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        cursor: pointer;
        font-size: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .card {
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        border: none;
        border-radius: 8px;
        max-width: 800px;
        margin: 0 auto;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
    }
    .card-title {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }
    .form-group {
        margin-bottom: 1.5rem;
    }
    .btn i {
        margin-right: 5px;
    }
    .select2-container--bootstrap4 .select2-selection--single {
        height: calc(1.6em + 0.75rem + 2px);
        padding: 0.375rem 0.75rem;
    }
    .input-group-text {
        background-color: #f8f9fa;
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
                        <h3 class="card-title">{{ isset($product) ? 'Edit' : 'Create' }} Product</h3>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($product))
                        {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'PUT', 'files' => true]) !!}
                    @else
                        {!! Form::open(['route' => 'admin.products.store', 'method' => 'POST', 'files' => true]) !!}
                    @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    {!! Form::label('name', 'Product Name *') !!}
                                    {!! Form::text('name', null, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'required']) !!}
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    {!! Form::label('description', 'Description') !!}
                                    {!! Form::textarea('description', null, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'rows' => 4]) !!}
                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('price', 'Price *') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                {!! Form::number('price', null, ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''), 'step' => '0.01', 'min' => '0', 'required']) !!}
                                                @error('price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('sale_price', 'Sale Price') !!}
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">$</span>
                                                </div>
                                                {!! Form::number('sale_price', null, ['class' => 'form-control' . ($errors->has('sale_price') ? ' is-invalid' : ''), 'step' => '0.01', 'min' => '0']) !!}
                                                @error('sale_price')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('quantity', 'Quantity *') !!}
                                            {!! Form::number('quantity', null, ['class' => 'form-control' . ($errors->has('quantity') ? ' is-invalid' : ''), 'min' => '0', 'required']) !!}
                                            @error('quantity')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('status', 'Status *') !!}
                                            {!! Form::select('status', ['active' => 'Active', 'inactive' => 'Inactive'], null, ['class' => 'form-control' . ($errors->has('status') ? ' is-invalid' : ''), 'required']) !!}
                                            @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                {!! Form::checkbox('is_featured', 1, isset($product) ? $product->is_featured : false, ['class' => 'custom-control-input', 'id' => 'is_featured']) !!}
                                                {!! Form::label('is_featured', 'Mark as Featured', ['class' => 'custom-control-label']) !!}
                                            </div>
                                            <small class="form-text text-muted">Featured products will be shown on the homepage.</small>
                                            @error('is_featured')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                {!! Form::checkbox('is_top_product', 1, isset($product) ? $product->is_top_product : false, ['class' => 'custom-control-input', 'id' => 'is_top_product']) !!}
                                                {!! Form::label('is_top_product', 'Mark as Top Product', ['class' => 'custom-control-label']) !!}
                                            </div>
                                            <small class="form-text text-muted">Top products will be shown in the top products section based on sales and ratings.</small>
                                            @error('is_top_product')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('category_id', 'Category *') !!}
                                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control' . ($errors->has('category_id') ? ' is-invalid' : ''), 'placeholder' => 'Select Category', 'required']) !!}
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('image1', 'Product Image 1 *') !!}
                                    <div class="custom-file">
                                        {!! Form::file('image1', ['class' => 'custom-file-input', 'id' => 'image1Input']) !!}
                                        <label class="custom-file-label" for="image1Input">Choose image</label>
                                        @error('image1')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div id="image1Preview" class="image-preview-container"></div>
                                    
                                    @if(isset($product) && $product->images && isset($product->images[0]))
                                        <div class="mt-2">
                                            <h6>Current Image 1:</h6>
                                            <div class="image-preview-item">
                                                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }} Image 1" style="width: 40px !important; height: 40px !important; max-width: 40px !important; max-height: 40px !important; object-fit: cover !important;">
                                                <span class="badge badge-primary">Primary</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('image2', 'Product Image 2 (Optional)') !!}
                                    <div class="custom-file">
                                        {!! Form::file('image2', ['class' => 'custom-file-input', 'id' => 'image2Input']) !!}
                                        <label class="custom-file-label" for="image2Input">Choose image</label>
                                        @error('image2')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div id="image2Preview" class="image-preview-container"></div>
                                    
                                    @if(isset($product) && $product->images && isset($product->images[1]))
                                        <div class="mt-2">
                                            <h6>Current Image 2:</h6>
                                            <div class="image-preview-item">
                                                <img src="{{ asset('storage/' . $product->images[1]) }}" alt="{{ $product->name }} Image 2" style="width: 40px !important; height: 40px !important; max-width: 40px !important; max-height: 40px !important; object-fit: cover !important;">
                                                <span class="badge badge-secondary">2</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('image3', 'Product Image 3 (Optional)') !!}
                                    <div class="custom-file">
                                        {!! Form::file('image3', ['class' => 'custom-file-input', 'id' => 'image3Input']) !!}
                                        <label class="custom-file-label" for="image3Input">Choose image</label>
                                        @error('image3')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div id="image3Preview" class="image-preview-container"></div>
                                    
                                    @if(isset($product) && $product->images && isset($product->images[2]))
                                        <div class="mt-2">
                                            <h6>Current Image 3:</h6>
                                            <div class="image-preview-item">
                                                <img src="{{ asset('storage/' . $product->images[2]) }}" alt="{{ $product->name }} Image 3" style="width: 40px !important; height: 40px !important; max-width: 40px !important; max-height: 40px !important; object-fit: cover !important;">
                                                <span class="badge badge-secondary">3</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <small class="form-text text-muted">Image 1 is required. Images 2 and 3 are optional.</small>
                            </div>
                        </div>

                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
                            </button>
                            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ml-2">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Select2 -->
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(function () {
        // Initialize Select2
        $('.select2').select2({
            theme: 'bootstrap4',
            placeholder: 'Select an option',
            allowClear: true
        });

        // Initialize bs-custom-file-input
        bsCustomFileInput.init();

        // Preview individual images before upload
        function previewImage(inputId, previewId, imageNumber) {
            $('#' + inputId).change(function() {
                const file = this.files[0];
                const container = $('#' + previewId);
                container.empty();
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewItem = `
                            <div class="image-preview-item">
                                <img src="${e.target.result}" alt="Preview ${imageNumber}">
                                <span class="badge badge-primary">${imageNumber}</span>
                            </div>
                        `;
                        container.append(previewItem);
                    }
                    reader.readAsDataURL(file);
                }
            });
        }

        previewImage('image1Input', 'image1Preview', 1);
        previewImage('image2Input', 'image2Preview', 2);
        previewImage('image3Input', 'image3Preview', 3);
    });
</script>
@endpush
