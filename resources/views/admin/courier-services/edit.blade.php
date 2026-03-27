@extends('backend.layouts.master')

@section('title', 'Edit Courier Service - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Edit Courier Service</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courier-services.index') }}">Courier Services</a></li>
          <li class="breadcrumb-item active">Edit</li>
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
            <h3 class="card-title">Edit Courier Service: {{ $courierService->name }}</h3>
          </div>
          <form action="{{ route('admin.courier-services.update', $courierService) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
              <div class="form-group">
                <label for="name">Service Name <span class="text-danger">*</span></label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $courierService->name) }}" required maxlength="255">
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="code">Service Code <span class="text-danger">*</span></label>
                    <input type="text" name="code" id="code" class="form-control" 
                           value="{{ old('code', $courierService->code) }}" required maxlength="255" placeholder="PATHAO">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_phone">Phone Number</label>
                    <input type="text" name="contact_phone" id="contact_phone" class="form-control" 
                           value="{{ old('contact_phone', $courierService->contact_phone) }}" maxlength="20" placeholder="01XXXXXXXXX">
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" name="website" id="website" class="form-control" 
                           value="{{ old('website', $courierService->website) }}" placeholder="https://example.com">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="contact_email">Email</label>
                    <input type="email" name="contact_email" id="contact_email" class="form-control" 
                           value="{{ old('contact_email', $courierService->contact_email) }}" placeholder="contact@example.com">
                  </div>
                </div>
              </div>

              <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" rows="3" 
                          placeholder="Brief description about the courier service...">{{ old('description', $courierService->description) }}</textarea>
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
                             class="form-control" value="{{ old('base_charge', $courierService->base_charge) }}" 
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
                             class="form-control" value="{{ old('inside_dhaka_charge', $courierService->inside_dhaka_charge) }}" 
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
                             class="form-control" value="{{ old('outside_dhaka_charge', $courierService->outside_dhaka_charge) }}" 
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
                           class="form-control" value="{{ old('delivery_days_inside', $courierService->delivery_days_inside) }}" 
                           min="1" required>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="delivery_days_outside">Delivery Days (Outside Dhaka) <span class="text-danger">*</span></label>
                    <input type="number" name="delivery_days_outside" id="delivery_days_outside" 
                           class="form-control" value="{{ old('delivery_days_outside', $courierService->delivery_days_outside) }}" 
                           min="1" required>
                  </div>
                </div>
              </div>

              <div class="form-group">
                <div class="custom-control custom-switch">
                  <input type="checkbox" name="is_active" id="is_active" class="custom-control-input" 
                         value="1" {{ old('is_active', $courierService->is_active) ? 'checked' : '' }}>
                  <label class="custom-control-label" for="is_active">
                    Active (Enable this courier service for orders)
                  </label>
                </div>
              </div>
            </div>

            <div class="card-footer">
              <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Courier Service
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
            <h3 class="card-title">Usage Statistics</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="text-center">
                  <h4>{{ $courierService->specialOrders()->count() }}</h4>
                  <small class="text-muted">Total Orders</small>
                </div>
              </div>
              <div class="col-6">
                <div class="text-center">
                  <h4>{{ $courierService->specialOrders()->where('status', 'completed')->count() }}</h4>
                  <small class="text-muted">Completed</small>
                </div>
              </div>
            </div>
            
            @if($courierService->specialOrders()->exists())
              <hr>
              <h5>Recent Orders</h5>
              @foreach($courierService->specialOrders()->latest()->take(5)->get() as $order)
                <div class="mb-2">
                  <small class="text-muted">{{ $order->order_number }}</small><br>
                  <small>{{ $order->customer_name }}</small><br>
                  <small class="text-info">৳{{ number_format($order->courier_charge, 2) }}</small>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
