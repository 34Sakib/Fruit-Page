@extends('backend.layouts.master')

@section('title', 'Manage Team Members')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Team Members</h3>

                        <a href="{{ route('admin.about-us.team.create') }}"
                           class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Team Member
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if($teamMembers->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width:70px;">Image</th>
                                        <th>Name</th>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th style="width:80px;">Order</th>
                                        <th style="width:90px;">Status</th>
                                        <th style="width:150px;">Actions</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($teamMembers as $member)
                                        <tr>
                                            <td>
                                                @if($member->image_path)
                                                    <img src="{{ asset('storage/' . $member->image_path) }}"
                                                         alt="{{ $member->name }}"
                                                         style="width:50px;height:50px;object-fit:cover;border-radius:5px;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                                         style="width:50px;height:50px;border-radius:5px;">
                                                        <small class="text-muted">N/A</small>
                                                    </div>
                                                @endif
                                            </td>

                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->role }}</td>
                                            <td>{{ Str::limit($member->description, 100) }}</td>
                                            <td>{{ $member->order }}</td>

                                            <td>
                                                <span class="badge badge-{{ $member->status ? 'success' : 'secondary' }}">
                                                    {{ $member->status ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>

                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.about-us.team.show', $member) }}"
                                                       class="btn btn-sm btn-primary"
                                                       title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('admin.about-us.team.edit', $member) }}"
                                                       class="btn btn-sm btn-info"
                                                       title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    <form action="{{ route('admin.about-us.team.destroy', $member) }}"
                                                          method="POST"
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this team member?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-sm btn-danger" title="Delete">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            <i class="fas fa-info-circle"></i>
                            No team members found.
                            <a href="{{ route('admin.about-us.team.create') }}"
                               class="btn btn-primary btn-sm ml-2">
                                Add First Team Member
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
