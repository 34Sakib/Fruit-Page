@extends('backend.layouts.master')

@section('title', 'All Orders - Admin Panel')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

<style>
    .order-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
        min-width: 100px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .status-pending { 
        background-color: #fff3cd; 
        color: #856404;
        border-left: 4px solid #ffc107;
    }
    .status-processing { 
        background-color: #cce5ff; 
        color: #004085;
        border-left: 4px solid #007bff;
    }
    .status-completed { 
        background-color: #d4edda; 
        color: #155724;
        border-left: 4px solid #28a745;
    }
    .status-cancelled { 
        background-color: #f8d7da; 
        color: #721c24;
        border-left: 4px solid #dc3545;
    }
    .status-refunded { 
        background-color: #e2e3e5; 
        color: #383d41;
        border-left: 4px solid #6c757d;
    }
    
    .card {
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border: none;
        border-radius: 0.35rem;
    }
    
    .card-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.35rem;
    }
    
    .card-title {
        margin-bottom: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #4e73df;
    }
    
    .btn i {
        margin-right: 5px;
    }
    
    .table {
        margin-bottom: 0;
    }
    
    .table th {
        background-color: #f8f9fc;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 0.5px;
        padding: 1rem;
        color: #4e73df;
        border-top: 1px solid #e3e5f0;
    }
    
    .table td {
        padding: 1rem;
        vertical-align: middle;
        border-top: 1px solid #e3e5f0;
    }
    
    .badge {
        font-weight: 600;
        padding: 0.35em 0.65em;
        font-size: 85%;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.3rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #4e73df;
        color: #fff !important;
        border-color: #4e73df;
    }
    
    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #eaecf4;
        color: #2e59d9 !important;
    }
    
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 0.75rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid #d1d3e2;
        border-radius: 0.35rem;
        padding: 0.375rem 1.75rem 0.375rem 0.75rem;
    }
    
    .dropdown-menu {
        border: none;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        border-radius: 0.35rem;
    }
    
    .dropdown-item {
        padding: 0.5rem 1.5rem;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fc;
        color: #4e73df;
    }
    
    .text-nowrap {
        white-space: nowrap;
    }
    
    .customer-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background-color: #4e73df;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-right: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    
    .order-id {
        font-weight: 600;
        color: #4e73df;
    }
    
    .order-date {
        color: #6c757d;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Order Management</h1>
        <div>
            <a href="#" class="btn btn-secondary">
                <i class="fas fa-file-export"></i> Export
            </a>
        </div>
    </div>
    
    <!-- Status Filter -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap align-items-center">
                        <span class="mr-2 font-weight-bold">Filter by Status:</span>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-sm btn-outline-secondary {{ !request('status') ? 'active' : '' }}">
                                <input type="radio" name="status" value="" {{ !request('status') ? 'checked' : '' }} onchange="this.form.submit()"> All
                            </label>
                            @foreach(['pending', 'processing', 'completed', 'cancelled', 'refunded'] as $status)
                            <label class="btn btn-sm btn-outline-{{ $status === 'completed' ? 'success' : ($status === 'processing' ? 'primary' : ($status === 'cancelled' ? 'danger' : ($status === 'refunded' ? 'secondary' : 'warning'))) }} {{ request('status') === $status ? 'active' : '' }}">
                                <input type="radio" name="status" value="{{ $status }}" {{ request('status') === $status ? 'checked' : '' }} onchange="this.form.submit()">
                                {{ ucfirst($status) }}
                            </label>
                            @endforeach
                        </div>
                        
                        <div class="ml-auto d-flex">
                            <div class="input-group input-group-sm mr-2" style="width: 250px;">
                                <input type="text" class="form-control" placeholder="Search orders..." id="searchInput">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i> More Filters
                                </button>
                                <div class="dropdown-menu dropdown-menu-right p-3" style="min-width: 300px;" aria-labelledby="filterDropdown">
                                    <div class="form-group">
                                        <label class="small font-weight-bold">Date Range</label>
                                        <div class="input-daterange input-group">
                                            <input type="date" class="form-control form-control-sm" name="start_date" value="{{ request('start_date') }}">
                                            <div class="input-group-append">
                                                <span class="input-group-text">to</span>
                                            </div>
                                            <input type="date" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }}">
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label class="small font-weight-bold">Order Total</label>
                                        <div class="input-group input-group-sm">
                                            <input type="number" class="form-control" placeholder="Min" name="min_amount" value="{{ request('min_amount') }}">
                                            <input type="number" class="form-control" placeholder="Max" name="max_amount" value="{{ request('max_amount') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            Order List
                        </h3>
                        <div class="card-tools">
                            <div class="input-group input-group-sm" style="width: 200px;">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="ordersTable" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Customer</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                    <tr>
                                        <td>#{{ $order->order_number }}</td>
                                        <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                                        <td>{{ $order->created_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <span class="order-status status-{{ $order->status }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No orders found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        @if($orders->hasPages())
                        <div class="card-footer clearfix">
                            {{ $orders->links() }}
                        </div>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@section('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script>
    $(function () {
        // Initialize DataTable
        $("#ordersTable").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
            "order": [[2, 'desc']] // Sort by date (column index 2) in descending order
        });
    });
</script>
@endsection
