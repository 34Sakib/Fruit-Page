@extends('backend.layouts.master')

@section('title', isset($category) ? 'Edit Category' : 'Create Category')

@push('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- dropzone -->
    <link rel="stylesheet" href="{{ asset('backend/plugins/dropzone/min/dropzone.min.css') }}">
    <style>
        .custom-file-label::after {
            content: "Browse";
        }
        .preview-image {
            max-width: 200px;
            margin-top: 10px;
            display: block;
        }
    </style>
@endpush

@section('content')
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ isset($category) ? 'Edit' : 'Create' }} Category</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                            <li class="breadcrumb-item active">{{ isset($category) ? 'Edit' : 'Create' }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Category Information</h3>
                            </div>

                            <form action="{{ isset($category) ? route('admin.categories.update', $category->id) : route('admin.categories.store') }}" 
                                  method="POST" 
                                  enctype="multipart/form-data">
                                @csrf
                                @if(isset($category))
                                    @method('PUT')
                                @endif

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

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Category Name <span class="text-danger">*</span></label>
                                                <input type="text" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       id="name" 
                                                       name="name" 
                                                       value="{{ old('name', $category->name ?? '') }}" 
                                                       placeholder="Enter category name" 
                                                       required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="parent_id">Parent Category</label>
                                                <select class="form-control select2 @error('parent_id') is-invalid @enderror" 
                                                        id="parent_id" 
                                                        name="parent_id" 
                                                        style="width: 100%;">
                                                    <option value="">-- Select Parent Category --</option>
                                                    @foreach($parentCategories as $parent)
                                                        <option value="{{ $parent->id }}" 
                                                            {{ (old('parent_id', isset($category) ? $category->parent_id : '') == $parent->id) ? 'selected' : '' }}>
                                                            {{ $parent->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('parent_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="order">Display Order</label>
                                                <input type="number" 
                                                       class="form-control @error('order') is-invalid @enderror" 
                                                       id="order" 
                                                       name="order" 
                                                       value="{{ old('order', $category->order ?? 0) }}" 
                                                       min="0" 
                                                       placeholder="Display order">
                                                @error('order')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status <span class="text-danger">*</span></label>
                                                <select class="form-control @error('status') is-invalid @enderror" 
                                                        id="status" 
                                                        name="status" 
                                                        required>
                                                    <option value="active" {{ (old('status', $category->status ?? '') == 'active') ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ (old('status', $category->status ?? '') == 'inactive') ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group">
                                                <label for="image">Category Image</label>
                                                <div class="custom-file">
                                                    <input type="file" 
                                                           class="custom-file-input @error('image') is-invalid @enderror" 
                                                           id="image" 
                                                           name="image" 
                                                           onchange="previewImage(this)">
                                                    <label class="custom-file-label" for="image">Choose file</label>
                                                    @error('image')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                @if(isset($category) && $category->image)
                                                    <img src="{{ asset('storage/' . $category->image) }}" 
                                                         alt="Category Image" 
                                                         class="preview-image" 
                                                         id="imagePreview">
                                                @else
                                                    <img src="" 
                                                         alt="Preview" 
                                                         class="preview-image d-none" 
                                                         id="imagePreview">
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                                  id="description" 
                                                  name="description" 
                                                  rows="3" 
                                                  placeholder="Enter category description">{{ old('description', $category->description ?? '') }}</textarea>
                                        @error('description')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> {{ isset($category) ? 'Update' : 'Create' }} Category
                                    </button>
                                    <a href="{{ route('admin.categories.index') }}" class="btn btn-default">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
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
                placeholder: 'Select a parent category',
                allowClear: true
            });

            // Initialize bs-custom-file-input
            bsCustomFileInput.init();
        });

        // Preview image before upload
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onloadend = function () {
                preview.src = reader.result;
                preview.classList.remove('d-none');
            }

            if (file) {
                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.classList.add('d-none');
            }
        }
    </script>
@endpush
