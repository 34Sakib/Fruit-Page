@extends('backend.layouts.master')

@section('title', 'Edit User - Admin Panel')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('backend/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<style>
    .card {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        margin-bottom: 1.5rem;
        border-radius: 0.35rem;
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
    
    .form-control:disabled, .form-control[readonly] {
        background-color: #f8f9fc;
        opacity: 1;
    }
    
    .profile-img-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }
    
    .profile-img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #e3e6f0;
    }
    
    .nav-tabs .nav-link {
        color: #6e707e;
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 600;
    }
    
    .nav-tabs .nav-link.active {
        color: #4e73df;
        border-bottom: 2px solid #4e73df;
        background: transparent;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to Users
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit User Information</h6>
        </div>
        <div class="card-body">
            <form id="editUserForm" action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img-container">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="profile-img mb-3" alt="Profile Image" id="profileImagePreview">
                            @else
                                <div class="profile-img bg-primary text-white d-flex align-items-center justify-content-center mb-3" style="font-size: 3rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="profile_photo" name="profile_photo">
                                    <label class="custom-file-label" for="profile_photo">Choose file</label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="status">Account Status</label>
                            <select class="form-control" id="is_active" name="is_active">
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-8">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="name">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="email">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="phone">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                            </div>
                            
                            <div class="form-group col-md-6">
                                <label for="role">User Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrator</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="change_password" name="change_password">
                                <label class="custom-control-label" for="change_password">Change Password</label>
                            </div>
                        </div>
                        
                        <div id="passwordFields" style="display: none;">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update User
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- SweetAlert2 -->
<script src="{{ asset('backend/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ asset('backend/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize file input
        bsCustomFileInput.init();
        
        // Toggle password fields
        $('#change_password').change(function() {
            if($(this).is(':checked')) {
                $('#passwordFields').slideDown();
                $('#password').prop('required', true);
                $('#password_confirmation').prop('required', true);
            } else {
                $('#passwordFields').slideUp();
                $('#password').prop('required', false);
                $('#password_confirmation').prop('required', false);
            }
        });
        
        // Preview image before upload
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#profileImagePreview').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        $("#profile_photo").change(function() {
            readURL(this);
        });
        
        // Form submission with validation
        $('#editUserForm').on('submit', function(e) {
            e.preventDefault();
            
            var form = $(this);
            var formData = new FormData(this);
            var url = form.attr('action');
            
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'User updated successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        timer: 2000
                    }).then((result) => {
                        window.location.href = "{{ route('admin.users.index') }}";
                    });
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';
                    
                    $.each(errors, function(key, value) {
                        errorMessage += value[0] + '\n';
                    });
                    
                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    });
</script>
@endpush
                            