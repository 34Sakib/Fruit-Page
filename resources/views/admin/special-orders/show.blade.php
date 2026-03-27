@extends('backend.layouts.master')

@section('title', 'Special Order Details - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Special Order Details</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item"><a href="{{ route('admin.special-orders.index') }}">Special Orders</a></li>
          <li class="breadcrumb-item active">{{ $specialOrder->order_number }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    @if(session('success'))
      <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('success') }}
      </div>
    @endif

    <div class="row">
      <div class="col-md-8">
        <!-- Customer Information -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Customer Information</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <strong>Name:</strong> {{ $specialOrder->customer_name }}
              </div>
              <div class="col-sm-6">
                <strong>Email:</strong> {{ $specialOrder->email }}
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Phone:</strong> {{ $specialOrder->phone }}
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Location:</strong> {{ $specialOrder->is_inside_dhaka ? 'Inside Dhaka' : 'Outside Dhaka' }}
              </div>
              <div class="col-12 mt-2">
                <strong>Address:</strong><br>
                {{ $specialOrder->address }}
              </div>
            </div>
          </div>
        </div>

        <!-- Product Information -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Product Information</h3>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-sm-6">
                <strong>Category:</strong> {{ $specialOrder->category->name }}
              </div>
              <div class="col-sm-6">
                <strong>Product:</strong> 
                @if($specialOrder->product)
                  {{ $specialOrder->product->name }}
                @else
                  {{ $specialOrder->product_name ?: 'Custom Product' }}
                @endif
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Quantity:</strong> 
                @if($specialOrder->quantity)
                  {{ number_format($specialOrder->quantity, 2) }} kg
                @else
                  <span class="text-muted">Not finalized</span>
                @endif
              </div>
              <div class="col-sm-6 mt-2">
                <strong>Delivery Charge:</strong> ৳{{ number_format($specialOrder->delivery_charge, 2) }}
              </div>
            </div>

            <!-- Customer Requirements -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Customer Requirements</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <strong>Order Details:</strong><br>
                            {{ $specialOrder->notes }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing Information -->
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">Pricing Information</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Final Price:</strong> 
                            @if($specialOrder->final_price)
                                ৳{{ number_format($specialOrder->final_price, 2) }}
                            @else
                                <span class="text-muted">Not set</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <strong>Delivery Charge:</strong> ৳{{ number_format($specialOrder->delivery_charge, 2) }}
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12">
                            <strong>Total:</strong> ৳{{ number_format($specialOrder->total_price, 2) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Price Management -->
            @if($specialOrder->status === 'pending' || $specialOrder->status === 'approved')
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Price Management</h3>
                    </div>
                    <div class="card-body">
                        @if(!$specialOrder->final_price || !$specialOrder->quantity)
                            <form action="{{ route('admin.special-orders.final-price.update', $specialOrder) }}" method="POST" class="mb-3">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="quantity" class="form-label">Final Quantity (kg)</label>
                                        <input type="number" name="quantity" id="quantity" class="form-control" 
                                               step="0.1" min="0.1" {{ $specialOrder->quantity ? 'value="' . $specialOrder->quantity . '"' : '' }}>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="final_price" class="form-label">Final Price (BDT)</label>
                                        <input type="number" name="final_price" id="final_price" class="form-control" 
                                               step="0.01" min="0" {{ $specialOrder->final_price ? 'value="' . $specialOrder->final_price . '"' : '' }}>
                                    </div>
                                    <div class="col-md-4">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-primary btn-block">Set Details</button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        
                        @if($specialOrder->final_price && $specialOrder->quantity && !$specialOrder->invoice_sent_at)
                            <form action="{{ route('admin.special-orders.send-invoice', $specialOrder) }}" method="POST" class="mb-3">
                                @csrf
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-envelope"></i> Send Invoice to Customer
                                </button>
                            </form>
                        @endif
                        
                        @if($specialOrder->invoice_sent_at)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> 
                                Invoice sent on {{ $specialOrder->invoice_sent_at->format('M j, Y h:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            @endif
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <!-- Order Status -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Order Status</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.special-orders.status.update', $specialOrder) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="form-group">
                <label>Current Status:</label>
                <div>
                  @switch($specialOrder->status)
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
                      <span class="badge badge-secondary">{{ $specialOrder->status }}</span>
                  @endswitch
                </div>
              </div>

              <div class="form-group">
                <label for="status">Update Status:</label>
                <select name="status" id="status" class="form-control">
                  <option value="pending" {{ $specialOrder->status == 'pending' ? 'selected' : '' }}>Pending</option>
                  <option value="approved" {{ $specialOrder->status == 'approved' ? 'selected' : '' }}>Approved</option>
                  <option value="rejected" {{ $specialOrder->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                  <option value="processing" {{ $specialOrder->status == 'processing' ? 'selected' : '' }}>Processing</option>
                  <option value="completed" {{ $specialOrder->status == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
              </div>

              <button type="submit" class="btn btn-primary btn-block">Update Status</button>
            </form>
          </div>
        </div>

        <!-- Admin Notes -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Admin Notes</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.special-orders.notes.update', $specialOrder) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="form-group">
                <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" placeholder="Add notes about this order...">{{ $specialOrder->admin_notes }}</textarea>
              </div>

              <button type="submit" class="btn btn-info btn-block">Update Notes</button>
            </form>
          </div>
        </div>

        <!-- Courier Service -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Courier Service</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.special-orders.courier.update', $specialOrder) }}" method="POST">
              @csrf
              @method('PUT')
              
              <div class="form-group">
                <label for="courier_service_id">Select Courier Service:</label>
                <select name="courier_service_id" id="courier_service_id" class="form-control">
                  <option value="">Select Courier Service</option>
                  @foreach($courierServices as $courier)
                    <option value="{{ $courier->id }}" {{ $specialOrder->courier_service_id == $courier->id ? 'selected' : '' }}>
                      {{ $courier->name }} - 
                      {{ $courier->getChargeForLocation($specialOrder->is_inside_dhaka) }} BDT
                      ({{ $courier->getDeliveryDaysForLocation($specialOrder->is_inside_dhaka) }} days)
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="courier_charge">Courier Charge (BDT):</label>
                    <input type="number" name="courier_charge" id="courier_charge" class="form-control" 
                           value="{{ $specialOrder->courier_charge }}" step="0.01" min="0" placeholder="0.00">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="courier_tracking_number">Courier Tracking Number:</label>
                    <input type="text" name="courier_tracking_number" id="courier_tracking_number" class="form-control" 
                           value="{{ $specialOrder->courier_tracking_number }}" placeholder="Enter tracking number">
                  </div>
                </div>
              </div>

              @if($specialOrder->courierService)
                <div class="alert alert-info">
                  <strong>Selected Courier:</strong> {{ $specialOrder->courierService->name }}<br>
                  <strong>Phone:</strong> {{ $specialOrder->courierService->contact_phone ?? 'N/A' }}<br>
                  <strong>Website:</strong> @if($specialOrder->courierService->website) <a href="{{ $specialOrder->courierService->website }}" target="_blank">{{ $specialOrder->courierService->website }}</a> @else N/A @endif
                </div>
              @endif

              <button type="submit" class="btn btn-warning btn-block">Update Courier Service</button>
            </form>
          </div>
        </div>

        @if($specialOrder->courier_service_id && !$specialOrder->shipped_at)
        <!-- Mark as Shipped -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Mark as Shipped</h3>
          </div>
          <div class="card-body">
            <form action="{{ route('admin.special-orders.ship', $specialOrder) }}" method="POST">
              @csrf
              
              <div class="form-group">
                <label for="ship_tracking_number">Courier Tracking Number (Required):</label>
                <input type="text" name="courier_tracking_number" id="ship_tracking_number" class="form-control" 
                       value="{{ $specialOrder->courier_tracking_number }}" placeholder="Enter tracking number" required>
              </div>

              <button type="submit" class="btn btn-success btn-block">Mark as Shipped</button>
            </form>
          </div>
        </div>
        @endif

        <!-- Order Info -->
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Order Information</h3>
          </div>
          <div class="card-body">
            <p><strong>Order Number:</strong> {{ $specialOrder->order_number }}</p>
            <p><strong>Created:</strong> {{ $specialOrder->created_at->format('M j, Y h:i A') }}</p>
            <p><strong>Last Updated:</strong> {{ $specialOrder->updated_at->format('M j, Y h:i A') }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
