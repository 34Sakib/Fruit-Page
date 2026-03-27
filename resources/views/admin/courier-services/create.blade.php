@extends('backend.layouts.master')

@section('title', 'Add Courier Service - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Add Courier Service</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courier-services.index') }}">Courier Services</a></li>
          <li class="breadcrumb-item active">Add</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Courier Service Information</h3>
          </div>
          <form action="{{ route('admin.courier-services.store') }}" method="POST">
            @csrf
            <div class="card-body">
              <div class="form-group">
                <label for="name">Service Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name') }}" required maxlength="255">
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="code">Service Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="code" class="form-control" 
                           value="{{ old('code') }}" required maxlength="255" placeholder="PATHAO">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_phone">Phone Number</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" 
                           value="{{ old('contact_phone') }}" maxlength="20" placeholder="01XXXXXXXXX">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="website">Website</label>
                <input type="url" name="website" id="website" class="form-control" 
                       value="{{ old('website') }}" placeholder="https://example.com">
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" 
                          placeholder="Brief description about the courier service...">{{ old('description') }}</textarea>
              </div>

              <h4 class="mt-4 mb-3">Pricing Information</h4>
              
              <div class="row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="base_charge">Base Charge <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">৳</span>
                      </div>
                      <input type="number" name="base_charge" id="base_charge" 
                             class="form-control" value="{{ old('base_charge', 0) }}" 
                             step="0.01" min="0" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="inside_dhaka_charge">Inside Dhaka Charge <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">৳</span>
                      </div>
                      <input type="number" name="inside_dhaka_charge" id="inside_dhaka_charge" 
                             class="form-control" value="{{ old('inside_dhaka_charge', 60) }}" 
                             step="0.01" min="0" required>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="outside_dhaka_charge">Outside Dhaka Charge <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">৳</span>
                      </div>
                      <input type="number" name="outside_dhaka_charge" id="outside_dhaka_charge" 
                             class="form-control" value="{{ old('outside_dhaka_charge', 120) }}" 
                             step="0.01" min="0" required>
                    </div>
                  </div>
                </div>
              </div>

              <h4 class="mt-4 mb-3">Delivery Time</h4>
              
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="delivery_days_inside">Delivery Days (Inside Dhaka) <span class="text-danger">*</span></label>
                    <input type="number" name="delivery_days_inside" id="delivery_days_inside" 
                           class="form-control" value="{{ old('delivery_days_inside', 1) }}" 
                           min="1" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="delivery_days_outside">Delivery Days (Outside Dhaka) <span class="text-danger">*</span></label>
                    <input type="number" name="delivery_days_outside" id="delivery_days_outside" 
                           class="form-control" value="{{ old('delivery_days_outside', 3) }}" 
                           min="1" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" 
                         value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                  <label class="custom-control-label" for="is_active">
                    Active (Enable this courier service for orders)
                  </label>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Courier Service
              </button>
              <a href="{{ route('admin.courier-services.index') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> Cancel
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Help</h3>
          </div>
          <div class="card-body">
            <h5>Base Charge</h5>
            <p class="text-muted">Fixed charge for delivery regardless of weight.</p>
            
            <h5>Per KG Charge</h5>
            <p class="text-muted">Additional charge per kilogram of package weight.</p>
            
            <h5>Delivery Days</h5>
            <p class="text-muted">Estimated delivery time for packages.</p>
            
            <div class="alert alert-info mt-3">
              <strong>Note:</strong> All courier services will be available for selection in special orders when marked as active.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
