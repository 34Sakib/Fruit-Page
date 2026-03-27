@extends('backend.layouts.master')

@section('title', 'Add Team Member')

@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Add Team Member</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.about-us.team.index') }}">Team Members</a></li>
                        <li class="breadcrumb-item active">Add</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('admin.about-us.team.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Team Member Details</h3>
                                <div class="card-tools">
                                    <a href="{{ route('admin.about-us.team.index') }}" class="btn btn-sm btn-secondary">
                                        <i class="fas fa-arrow-left"></i> Back to List
                                    </a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!-- Image -->
                                    <div class="col-md-4 text-center">
                                        <img id="previewImg"
                                             src="https://via.placeholder.com/300x300?text=No+Image"
                                             class="img-fluid rounded mb-2"
                                             style="max-height:250px;">

                                        <div class="form-group mt-2">
                                            <input type="file" name="image" id="image"
                                                   class="form-control" accept="image/*" required>
                                            <small class="text-muted">Image required (Max 2MB)</small>
                                            @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <!-- Form -->
                                    <div class="col-md-8">
                                        <table class="table table-bordered">
                                            <tr>
                                                <th style="width:30%">Name *</th>
                                                <td>
                                                    <input type="text" name="name" class="form-control"
                                                           value="{{ old('name') }}" required>
                                                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Role *</th>
                                                <td>
                                                    <input type="text" name="role" class="form-control"
                                                           value="{{ old('role') }}" required>
                                                    @error('role') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Description *</th>
                                                <td>
                                                    <textarea name="description" rows="4"
                                                              class="form-control" required>{{ old('description') }}</textarea>
                                                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Display Order</th>
                                                <td>
                                                    <input type="number" name="order" class="form-control"
                                                           value="{{ old('order', 0) }}">
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                               id="status" name="status" value="1"
                                                               {{ old('status', true) ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="status">Active</label>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save
                                </button>
                                <a href="{{ route('admin.about-us.team.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function () {
    const file = this.files[0];
    const img = document.getElementById('previewImg');
    if (!file) return;

    const reader = new FileReader();
    reader.onload = e => img.src = e.target.result;
    reader.readAsDataURL(file);
});
</script>
@endpush
