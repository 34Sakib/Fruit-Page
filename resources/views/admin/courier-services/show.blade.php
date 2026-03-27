@extends('backend.layouts.master')

@section('title', 'Courier Service Details - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Courier Service Details</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.courier-services.index') }}">Courier Services</a></li>
          <li class="breadcrumb-item active">{{ $courierService->name }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8">
        <!-- Basic Information -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Basic Information</h3>
            <div class="card-tools">
              <a href="{{ route('admin.courier-services.edit', $courierService) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit"></i> Edit
              </a>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <strong>Service Name:</strong> {{ $courierService->name }}
              </div>
              <div class="col-sm-6">
                <strong>Service Code:</strong> {{ $courierService->code }}
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Status:</strong> 
                @if($courierService->is_active)
                  <span class="badge badge-success">Active</span>
                @else
                  <span class="badge badge-secondary">Inactive</span>
                @endif
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Phone:</strong> {{ $courierService->contact_phone ?: 'N/A' }}
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Email:</strong> {{ $courierService->contact_email ?: 'N/A' }}
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Website:</strong> 
                @if($courierService->website)
                  <a href="{{ $courierService->website }}" target="_blank">{{ $courierService->website }}</a>
                @else
                  N/A
                @endif
              </div>
            </div>
            
            @if($courierService->description)
              <hr>
              <h5>Description</h5>
              <p>{{ $courierService->description }}</p>
            @endif
          </div>
        </div>

        <!-- Pricing Information -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Pricing Information</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-4">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-map-marker-alt"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Base Charge</span>
                    <span class="info-box-number">৳{{ number_format($courierService->base_charge, 2) }}</span>
                    <small class="text-muted">Base charge</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-box">
                  <span class="info-box-icon bg-warning"><i class="fas fa-globe"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Inside Dhaka</span>
                    <span class="info-box-number">৳{{ number_format($courierService->inside_dhaka_charge, 2) }}</span>
                    <small class="text-muted">{{ $courierService->delivery_days_inside }} days delivery</small>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="info-box">
                  <span class="info-box-icon bg-success"><i class="fas fa-weight"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Outside Dhaka</span>
                    <span class="info-box-number">৳{{ number_format($courierService->outside_dhaka_charge, 2) }}</span>
                    <small class="text-muted">{{ $courierService->delivery_days_outside }} days delivery</small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Orders -->
        @if($courierService->specialOrders()->exists())
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Recent Orders</h3>
          </div>
          <div class="card-body">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Charge</th>
                  <th>Status</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                @foreach($courierService->specialOrders()->latest()->take(10)->get() as $order)
                  <tr>
                    <td>{{ $order->order_number }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>৳{{ number_format($order->courier_charge, 2) }}</td>
                    <td>
                      @switch($order->status)
                        @case('pending')
                          <span class="badge badge-warning">Pending</span>
                          @break
                        @case('approved')
                          <span class="badge badge-success">Approved</span>
                          @break
                        @case('rejected')
                          <span class="badge badge-danger">Rejected</span>
                          @break
                        @case('processing')
                          <span class="badge badge-info">Processing</span>
                          @break
                        @case('completed')
                          <span class="badge badge-primary">Completed</span>
                          @break
                        @default
                          <span class="badge badge-secondary">{{ $order->status }}</span>
                      @endswitch
                    </td>
                    <td>{{ $order->created_at->format('M j, Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @if($courierService->specialOrders()->count() > 10)
              <div class="text-center">
                <small class="text-muted">Showing 10 of {{ $courierService->specialOrders()->count() }} orders</small>
              </div>
            @endif
          </div>
        </div>
        @endif
      </div>

      <div class="col-md-4">
        <!-- Statistics -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Statistics</h3>
          </div>
          <div class="card-body">
            <div class="row text-center">
              <div class="col-6">
                <h4>{{ $courierService->specialOrders()->count() }}</h4>
                <small class="text-muted">Total Orders</small>
              </div>
              <div class="col-6">
                <h4>৳{{ number_format($courierService->specialOrders()->sum('courier_charge'), 2) }}</h4>
                <small class="text-muted">Total Revenue</small>
              </div>
            </div>
            <hr>
            <div class="row text-center">
              <div class="col-4">
                <h5>{{ $courierService->specialOrders()->where('status', 'pending')->count() }}</h5>
                <small class="text-warning">Pending</small>
              </div>
              <div class="col-4">
                <h5>{{ $courierService->specialOrders()->where('status', 'processing')->count() }}</h5>
                <small class="text-info">Processing</small>
              </div>
              <div class="col-4">
                <h5>{{ $courierService->specialOrders()->where('status', 'completed')->count() }}</h5>
                <small class="text-success">Completed</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Quick Actions</h3>
          </div>
          <div class="card-body">
            <div class="d-grid gap-2">
              <a href="{{ route('admin.courier-services.edit', $courierService) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Service
              </a>
              
              <form action="{{ route('admin.courier-services.toggle', $courierService) }}" method="POST">
                @csrf
                @method('PUT')
                <button type="submit" class="btn {{ $courierService->is_active ? 'btn-secondary' : 'btn-success' }} btn-block">
                  <i class="fas {{ $courierService->is_active ? 'fa-ban' : 'fa-check' }}"></i> 
                  {{ $courierService->is_active ? 'Deactivate' : 'Activate' }} Service
                </button>
              </form>
              
              <a href="{{ route('admin.courier-services.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
