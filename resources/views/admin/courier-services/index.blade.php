@extends('backend.layouts.master')

@section('title', 'Courier Services - FruitMart Admin')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Courier Services</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">Courier Services</li>
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

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        {{ session('error') }}
      </div>
    @endif

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">All Courier Services</h3>
        <a href="{{ route('admin.courier-services.create') }}" class="btn btn-primary btn-sm float-right">
          <i class="fas fa-plus"></i> Add New Courier Service
        </a>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Name</th>
              <th>Contact</th>
              <th>Inside Dhaka</th>
              <th>Outside Dhaka</th>
              <th>Per KG</th>
              <th>Delivery Days</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($courierServices as $courier)
              <tr>
                <td>
                  <strong>{{ $courier->name }}</strong>
                  @if($courier->description)
                    <br><small class="text-muted">{{ Str::limit($courier->description, 50) }}</small>
                  @endif
                </td>
                <td>
                  @if($courier->contact_phone)
                    <small class="text-muted">{{ $courier->contact_phone }}</small><br>
                  @endif
                  @if($courier->website)
                    <a href="{{ $courier->website }}" target="_blank" class="text-info">
                      <small>Visit Website</small>
                    </a>
                  @endif
                </td>
                <td>
                  <strong>৳{{ number_format($courier->inside_dhaka_charge, 2) }}</strong>
                  <br><small class="text-muted">{{ $courier->delivery_days_inside }} days</small>
                </td>
                <td>
                  <strong>৳{{ number_format($courier->outside_dhaka_charge, 2) }}</strong>
                  <br><small class="text-muted">{{ $courier->delivery_days_outside }} days</small>
                </td>
                <td>৳{{ number_format($courier->base_charge, 2) }}</td>
                <td>
                  <small class="text-info">{{ $courier->delivery_days_inside }}d (in)</small><br>
                  <small class="text-warning">{{ $courier->delivery_days_outside }}d (out)</small>
                </td>
                <td>
                  @if($courier->is_active)
                    <span class="badge badge-success">Active</span>
                  @else
                    <span class="badge badge-secondary">Inactive</span>
                  @endif
                </td>
                <td>
                  <div class="btn-group btn-group-sm">
                    <a href="{{ route('admin.courier-services.show', $courier) }}" class="btn btn-info" title="View">
                      <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.courier-services.edit', $courier) }}" class="btn btn-warning" title="Edit">
                      <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.courier-services.toggle', $courier) }}" method="POST" style="display: inline;">
                      @csrf
                      @method('PUT')
                      <button type="submit" class="btn {{ $courier->is_active ? 'btn-secondary' : 'btn-success' }}" 
                              title="{{ $courier->is_active ? 'Deactivate' : 'Activate' }}">
                        <i class="fas {{ $courier->is_active ? 'fa-ban' : 'fa-check' }}"></i>
                      </button>
                    </form>
                    <form action="{{ route('admin.courier-services.destroy', $courier) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this courier service?')" 
                          style="display: inline;">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger" title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="8" class="text-center">No courier services found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        {{ $courierServices->links() }}
      </div>
    </div>
  </div>
</section>
@endsection
