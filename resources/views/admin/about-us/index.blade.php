@extends('backend.layouts.master')

@section('title', 'About Us Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">About Us Management</h3>

                        <div>
                            @if($aboutContent)
                                <a href="{{ route('admin.about-us.edit') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i> Edit Content
                                </a>
                            @else
                                <a href="{{ route('admin.about-us.edit') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-plus"></i> Create Content
                                </a>
                            @endif

                            <a href="{{ route('admin.about-us.team.index') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-users"></i> Manage Team
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if($aboutContent)
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Hero Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $aboutContent->hero_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($aboutContent->hero_subtitle, 100) }}</td></tr>
                                    <tr><td><strong>Icon:</strong></td><td><i class="{{ $aboutContent->hero_icon }}"></i></td></tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Statistics</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Happy Customers:</strong></td><td>{{ number_format($aboutContent->happy_customers) }}</td></tr>
                                    <tr><td><strong>Deliveries Made:</strong></td><td>{{ number_format($aboutContent->deliveries_made) }}</td></tr>
                                    <tr><td><strong>Local Farms:</strong></td><td>{{ number_format($aboutContent->local_farms) }}</td></tr>
                                    <tr><td><strong>Years Excellence:</strong></td><td>{{ $aboutContent->years_excellence }}</td></tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Mission Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $aboutContent->mission_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($aboutContent->mission_subtitle, 100) }}</td></tr>
                                </table>
                            </div>

                            <div class="col-md-6">
                                <h5>Team Section</h5>
                                <table class="table table-sm">
                                    <tr><td><strong>Title:</strong></td><td>{{ $aboutContent->team_title }}</td></tr>
                                    <tr><td><strong>Subtitle:</strong></td><td>{{ Str::limit($aboutContent->team_subtitle, 100) }}</td></tr>
                                </table>
                            </div>
                        </div>

                        <hr>

                        <h5>Current Team Members ({{ $teamMembers->count() }})</h5>
                        <div class="row">
                            @foreach($teamMembers as $member)
                                <div class="col-md-3 mb-3">
                                    <div class="card card-outline card-primary">
                                        @if($member->image_path)
                                            <img src="{{ asset('storage/'.$member->image_path) }}"
                                                 class="card-img-top"
                                                 style="height:150px;object-fit:cover;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center"
                                                 style="height:150px;">
                                                <span class="text-muted">No Image</span>
                                            </div>
                                        @endif

                                        <div class="card-body p-2">
                                            <h6 class="mb-1">{{ $member->name }}</h6>
                                            <p class="small mb-1">{{ $member->role }}</p>
                                            <span class="badge badge-{{ $member->status ? 'success' : 'secondary' }}">
                                                {{ $member->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No About Us content found.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
