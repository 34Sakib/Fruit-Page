@extends('backend.layouts.master')

@section('title', 'View Team Member')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">Team Member Details</h3>

                        <div>
                            <a href="{{ route('admin.about-us.team.edit', $teamMember) }}"
                               class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <a href="{{ route('admin.about-us.team.index') }}"
                               class="btn btn-sm btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <!-- IMAGE -->
                        <div class="col-md-4 text-center">
                            @if($teamMember->image_path)
                                <img src="{{ asset('storage/' . $teamMember->image_path) }}"
                                     alt="{{ $teamMember->name }}"
                                     class="img-fluid rounded"
                                     style="max-height:300px;object-fit:cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center"
                                     style="height:200px;border:1px solid #dee2e6;border-radius:4px;">
                                    <span class="text-muted">No Image</span>
                                </div>
                            @endif
                        </div>

                        <!-- DETAILS -->
                        <div class="col-md-8">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width:30%;">Name</th>
                                    <td>{{ $teamMember->name }}</td>
                                </tr>

                                <tr>
                                    <th>Role</th>
                                    <td>{{ $teamMember->role }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        <span class="badge badge-{{ $teamMember->status ? 'success' : 'secondary' }}">
                                            {{ $teamMember->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Display Order</th>
                                    <td>{{ $teamMember->order }}</td>
                                </tr>

                                <tr>
                                    <th>Description</th>
                                    <td>{!! nl2br(e($teamMember->description)) !!}</td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $teamMember->created_at->format('M d, Y h:i A') }}</td>
                                </tr>

                                <tr>
                                    <th>Last Updated</th>
                                    <td>{{ $teamMember->updated_at->format('M d, Y h:i A') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer text-right">
                    <a href="{{ route('admin.about-us.team.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
