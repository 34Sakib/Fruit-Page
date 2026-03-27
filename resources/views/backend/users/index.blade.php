@extends('backend.layouts.master')

@section('title', 'Manage Users - Admin Panel')

@push('styles')
<style>
    body, 
    .wrapper,
    .content-wrapper,
    .content-wrapper > .content,
    .content-wrapper > .content > .container,
    .content-wrapper > .content > .container-fluid {
        background-color: #000000 !important;
        color: #333 !important;
    }
    
    /* Override AdminLTE content wrapper */
    .content-wrapper {
        background-color: #000000 !important;
    }
    
    .card {
        background-color: #1a1a1a !important;
        border: 1px solid #333 !important;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(0, 0, 0, 0.3) !important;
        margin-bottom: 1.5rem !important;
        border-radius: 0.35rem !important;
    }
    
    .card-header {
        background-color: #1a1a1a !important;
        border-bottom: 1px solid #333 !important;
        padding: 1rem 1.25rem !important;
    }
    
    .card-title {
        color: #4e73df !important;
        font-weight: 600 !important;
        margin-bottom: 0 !important;
        font-size: 1.1rem !important;
    }
    
    .table {
        color: #333 !important;
        background-color: #1a1a1a !important;
    }
    
    .table th {
        background-color: #1a1a1a !important;
        color: #4e73df !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        font-size: 0.7rem !important;
        letter-spacing: 0.5px !important;
        border-bottom: 1px solid #333 !important;
    }
    
    .table td {
        border-top: 1px solid #333 !important;
        border-bottom: 1px solid #333 !important;
        vertical-align: middle !important;
        background-color: #1a1a1a !important;
        color: #333 !important;
    }
    
    .table tbody tr:hover {
        background-color: #2a2a2a !important;
    }
    
    .badge {
        font-weight: 500 !important;
        padding: 0.35em 0.65em !important;
        font-size: 85% !important;
        color: #333 !important;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.8rem !important;
    }
    
    .form-control {
        background-color: #2d2d2d !important;
        border: 1px solid #444 !important;
        color: #333 !important;
    }
    
    .form-control:focus {
        background-color: #2d2d2d !important;
        border-color: #4e73df !important;
        color: #333 !important;
        box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25) !important;
    }
    
    .page-link {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
        color: #333 !important;
    }
    
    .page-item.active .page-link {
        background-color: #4e73df !important;
        border-color: #4e73df !important;
        color: #333 !important;
    }
    
    .page-link:hover {
        background-color: #2a2a2a !important;
        color: #ffffff !important;
        border-color: #444 !important;
    }
    
    /* Override AdminLTE specific classes */
    .wrapper {
        background-color: #000000 !important;
    }
    
    .main-sidebar, .main-header, .main-footer {
        background-color: #1a1a1a !important;
        border-color: #333 !important;
    }
    
    .nav-sidebar > .nav-item > .nav-link {
        color: #333 !important;
    }
    
    .nav-sidebar > .nav-item > .nav-link:hover {
        background-color: #2a2a2a !important;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
    }
    
    .status-badge {
        min-width: 80px;
        text-align: center;
    }

    
    .role-user {
        background-color: #007bff;
        color: #333;
    }
    
    .action-btns .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.8rem;
        line-height: 1.5;
    }
        border-radius: 0.2rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-users text-primary me-2"></i>User Management
        </h1>
        <div class="d-none d-sm-inline-block">
            <div class="input-group input-group-sm">
                <input type="text" id="searchInput" class="form-control bg-white border-0 shadow-sm" 
                       placeholder="Search users..." style="min-width: 250px;">
                <div class="input-group-append">
                    <span class="input-group-text bg-white border-0">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Card -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex flex-column flex-md-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-user-friends me-2"></i>Users List
            </h6>
            <div class="mt-2 mt-md-0">
                <span class="badge bg-primary-soft text-primary px-3 py-2">
                    <i class="fas fa-users me-1"></i> 
                    {{ $users->total() }} {{ Str::plural('User', $users->total()) }}
                </span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="usersTable">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4" width="60">#</th>
                            <th>User</th>
                            <th>Contact</th>
                            <th class="text-center">Role</th>
                            <th class="text-center">Status</th>
                            <th>Member Since</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @forelse($users as $user)
                        <tr class="border-bottom">
                            <td class="ps-4 text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($user->profile_photo_path)
                                        <img src="{{ asset('storage/' . $user->profile_photo_path) }}" 
                                             alt="{{ $user->name }}" 
                                             class="rounded-circle me-3" 
                                             width="40" 
                                             height="40"
                                             style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                                        <small class="text-muted">ID: {{ $user->id }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="text-dark">{{ $user->email }}</span>
                                    @if($user->phone)
                                    <small class="text-muted"><i class="fas fa-phone-alt me-1"></i> {{ $user->phone }}</small>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill py-1 px-3 {{ $user->isAdmin() ? 'bg-success-soft text-success' : 'bg-primary-soft text-primary' }}">
                                    <i class="fas {{ $user->isAdmin() ? 'fa-user-shield me-1' : 'fa-user me-1' }}"></i>
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill py-1 px-3 {{ $user->is_active ? 'bg-success-soft text-success' : 'bg-secondary-soft text-secondary' }}">
                                    <i class="fas {{ $user->is_active ? 'fa-check-circle me-1' : 'fa-times-circle me-1' }}"></i>
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                                    <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td class="pe-4">
                                <div class="d-flex justify-content-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.users.show', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary rounded-start" 
                                           data-bs-toggle="tooltip" 
                                           title="View Profile">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           data-bs-toggle="tooltip" 
                                           title="Edit User">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST" 
                                              class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this user?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger rounded-end" 
                                                    data-bs-toggle="tooltip" 
                                                    title="Delete User">
                                                <i class="far fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <p class="mb-0">No users found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($users->hasPages())
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                {{ $users->links() }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{ asset('backend/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#usersTable').DataTable({
            "responsive": true,
            "paging": false,
            "searching": true,
            "info": false,
            "ordering": true,
            "autoWidth": false,
            "language": {
                "search": "",
                "searchPlaceholder": "Search users...",
                "emptyTable": "No users found."
            },
            "dom": '<"top"f>rt<"bottom"ip><"clear">',
            "initComplete": function() {
                // Move search input to the search container
            }
        });

        // Custom search input
        $('#searchInput').on('keyup', function() {
            table.search(this.value).draw();
        });

        // Initialize tooltips
        $('[data-toggle="tooltip"]').tooltip();

        // Handle delete confirmation
        $('.delete-form').on('submit', function(e) {
            if (!confirm('Are you sure you want to delete this user?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
