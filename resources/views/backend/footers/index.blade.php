@extends('backend.layouts.master')

@section('title', 'Manage Footers')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    .table td {
        vertical-align: middle !important;
    }

    table.table td,
    table.table th {
        vertical-align: middle !important;
        padding: 8px 10px !important;
        font-size: 14px;
    }

    td:nth-child(2) { max-width: 200px; word-break: break-word; }
    td:nth-child(3) { max-width: 300px; word-break: break-word; }
    td:nth-child(4) { min-width: 100px; }
    td:nth-child(5) { min-width: 80px; }

    @media (max-width: 768px) {
        td:nth-child(2), 
        td:nth-child(3) { 
            max-width: 120px; 
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Footer Management</h3>
                        <a href="{{ route('admin.footers.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add New Footer
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 50px;">#</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Contact Info</th>
                                    <th>Status</th>
                                    <th style="width: 150px;">Actions</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($footers as $footer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $footer->title }}</td>
                                        <td>{{ Str::limit($footer->description, 100) }}</td>
                                        <td>
                                            <small>
                                                @if($footer->email){{ $footer->email }}<br>@endif
                                                @if($footer->phone){{ $footer->phone }}<br>@endif
                                                @if($footer->address){{ Str::limit($footer->address, 50) }}@endif
                                            </small>
                                        </td>
                                        <td>
                                            <span class="badge {{ $footer->status ? 'badge-success' : 'badge-secondary' }}">
                                                {{ $footer->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.footers.edit', $footer->id) }}" 
                                               class="btn btn-sm btn-primary" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.footers.destroy', $footer->id) }}" 
                                                  method="POST" 
                                                  class="d-inline" 
                                                  onsubmit="return confirm('Are you sure you want to delete this footer?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No footers found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($footers->hasPages())
                        <div class="card-footer clearfix">
                            {{ $footers->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
