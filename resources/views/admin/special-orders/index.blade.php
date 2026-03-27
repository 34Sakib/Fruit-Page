@extends('backend.layouts.master')

@section('title', 'Special Orders - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Special Orders</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Special Orders</li>
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

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All Special Orders</h3>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Order #</th>
              <th>Customer</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Delivery</th>
              <th>Status</th>
              <th>Courier</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($specialOrders as $order)
              <tr>
                <td>{{ $order->order_number }}</td>
                <td>
                  <strong>{{ $order->customer_name }}</strong><br>
                  <small class="text-muted">{{ $order->email }}</small><br>
                  <small class="text-muted">{{ $order->phone }}</small>
                </td>
                <td>
                  @if($order->product)
                    {{ $order->product->name }}
                  @else
                    {{ $order->product_name ?: 'Custom Product' }}
                  @endif
                  <br><small class="text-muted">{{ $order->category->name }}</small>
                </td>
                <td>
                  @if($order->quantity)
                    {{ number_format($order->quantity, 2) }} kg
                  @else
                    <span class="text-muted">Not set</span>
                  @endif
                </td>
                <td>
                  {{ $order->is_inside_dhaka ? 'Inside Dhaka' : 'Outside Dhaka' }}<br>
                  <small class="text-muted">৳{{ number_format($order->delivery_charge, 2) }}</small>
                </td>
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
                <td>
                  @if($order->courierService)
                    <strong>{{ $order->courierService->name }}</strong><br>
                    <small class="text-muted">৳{{ number_format($order->courier_charge, 2) }}</small>
                    @if($order->courier_tracking_number)
                      <br><small class="text-info">{{ $order->courier_tracking_number }}</small>
                    @endif
                  @else
                    <span class="text-muted">Not assigned</span>
                  @endif
                </td>
                <td>{{ $order->created_at->format('M j, Y') }}</td>
                <td>
                  <a href="{{ route('admin.special-orders.show', $order) }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-eye"></i> View
                  </a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center">No special orders found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $specialOrders->links() }}
      </div>
    </div>
  </div>
</section>
@endsection
