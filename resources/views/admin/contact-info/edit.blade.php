@extends('backend.layouts.master')

@section('title', 'Edit Contact Information - ' . $contactInfo->header_title)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Contact Information</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.contact-info.show', $contactInfo) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Contact Info
                        </a>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.contact-info.update', $contactInfo) }}?_method=PUT">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="header_title">Header Title *</label>
                                    <input type="text" class="form-control" id="header_title" name="header_title" 
                                           value="{{ old('header_title', $contactInfo->header_title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="header_icon">Header Icon</label>
                                    <input type="text" class="form-control" id="header_icon" name="header_icon" 
                                           value="{{ old('header_icon', $contactInfo->header_icon) }}" placeholder="fas fa-headset">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="header_subtitle">Header Subtitle</label>
                            <textarea class="form-control" id="header_subtitle" name="header_subtitle" rows="3">{{ old('header_subtitle', $contactInfo->header_subtitle) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                           value="{{ old('email', $contactInfo->email) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone" 
                                           value="{{ old('phone', $contactInfo->phone) }}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3">{{ old('address', $contactInfo->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email_hours">Email Hours</label>
                                    <input type="text" class="form-control" id="email_hours" name="email_hours" 
                                           value="{{ old('email_hours', $contactInfo->email_hours) }}" placeholder="24/7 Support">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone_hours">Phone Hours</label>
                                    <input type="text" class="form-control" id="phone_hours" name="phone_hours" 
                                           value="{{ old('phone_hours', $contactInfo->phone_hours) }}" placeholder="Mon-Sat 9AM-8PM">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="map_embed_url">Map Embed URL</label>
                            <textarea class="form-control" id="map_embed_url" name="map_embed_url" rows="4" 
                                      placeholder="Paste Google Maps embed iframe code here">{{ old('map_embed_url', $contactInfo->map_embed_url) }}</textarea>
                            <small class="form-text text-muted">Paste the full iframe embed code from Google Maps</small>
                        </div>

                        <div class="form-group">
                            <label for="map_address">Map Address</label>
                            <input type="text" class="form-control" id="map_address" name="map_address" 
                                   value="{{ old('map_address', $contactInfo->map_address) }}" placeholder="123 Organic Street, Freshville, Dhaka 1205, Bangladesh">
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" 
                                       {{ old('status', $contactInfo->status) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="status">Active</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Contact Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
