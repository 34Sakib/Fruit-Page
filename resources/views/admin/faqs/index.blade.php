@extends('backend.layouts.master')

@section('title', 'FAQ Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">FAQ Management</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add New FAQ
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Question</th>
                                <th>Answer</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($faqs as $faq)
                                <tr>
                                    <td>
                                        <span class="badge badge-info">{{ $faq->sort_order }}</span>
                                    </td>
                                    <td>{{ Str::limit($faq->question, 80) }}</td>
                                    <td>{{ Str::limit($faq->answer, 100) }}</td>
                                    <td>
                                        @if($faq->status)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Inactive</span>
                                        @endif
                                    </td>
                                    <td>{{ $faq->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('admin.faqs.show', $faq) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <form method="POST" action="{{ route('admin.faqs.destroy', $faq) }}?_method=DELETE" style="display: inline;">
                                            @csrf
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">No FAQs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{ $faqs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
