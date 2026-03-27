@extends('backend.layouts.master')

@section('title', 'Edit About Us Content')

@section('content')
<div class="container-fluid">
    <form action="{{ route('admin.about-us.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Edit About Us Content</h3>

                            <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- HERO + STATS -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Hero Section</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Hero Title</label>
                                            <input type="text" class="form-control" name="hero_title"
                                                   value="{{ old('hero_title', $aboutContent->hero_title ?? '') }}" required>
                                        </div>

                                        <div class="form-group">
                                            <label>Hero Subtitle</label>
                                            <textarea class="form-control" name="hero_subtitle" rows="3" required>{{ old('hero_subtitle', $aboutContent->hero_subtitle ?? '') }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label>Hero Icon</label>
                                            <input type="text" class="form-control" name="hero_icon"
                                                   value="{{ old('hero_icon', $aboutContent->hero_icon ?? 'fas fa-leaf') }}" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">Statistics</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Happy Customers</label>
                                                    <input type="number" class="form-control" name="happy_customers"
                                                           value="{{ old('happy_customers', $aboutContent->happy_customers ?? 50000) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Deliveries Made</label>
                                                    <input type="number" class="form-control" name="deliveries_made"
                                                           value="{{ old('deliveries_made', $aboutContent->deliveries_made ?? 150000) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Local Farms</label>
                                                    <input type="number" class="form-control" name="local_farms"
                                                           value="{{ old('local_farms', $aboutContent->local_farms ?? 200) }}" required>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Years Excellence</label>
                                                    <input type="number" class="form-control" name="years_excellence"
                                                           value="{{ old('years_excellence', $aboutContent->years_excellence ?? 8) }}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MISSION + TEAM -->
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card card-outline card-success">
                                    <div class="card-header">
                                        <h3 class="card-title">Mission Section</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control mb-2" name="mission_title"
                                               value="{{ old('mission_title', $aboutContent->mission_title ?? '') }}" required>

                                        <textarea class="form-control" name="mission_subtitle" rows="3" required>{{ old('mission_subtitle', $aboutContent->mission_subtitle ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card card-outline card-warning">
                                    <div class="card-header">
                                        <h3 class="card-title">Team Section</h3>
                                    </div>
                                    <div class="card-body">
                                        <input type="text" class="form-control mb-2" name="team_title"
                                               value="{{ old('team_title', $aboutContent->team_title ?? '') }}" required>

                                        <textarea class="form-control" name="team_subtitle" rows="3" required>{{ old('team_subtitle', $aboutContent->team_subtitle ?? '') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SAVE -->
                        <div class="row mt-4">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Content
                                </button>
                                <a href="{{ route('admin.about-us.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
