@extends('backend.layouts.master')

@section('title', 'Edit FAQ - ' . $faq->question)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit FAQ</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.faqs.show', $faq) }}" class="btn btn-default btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to FAQ
                        </a>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.faqs.update', $faq) }}?_method=PUT">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="question">Question *</label>
                                    <input type="text" class="form-control" id="question" name="question" 
                                           value="{{ old('question', $faq->question) }}" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number" class="form-control" id="sort_order" name="sort_order" 
                                           value="{{ old('sort_order', $faq->sort_order) }}" min="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="status" name="status" value="1" 
                                               {{ old('status', $faq->status) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="status">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="answer">Answer *</label>
                            <textarea class="form-control" id="answer" name="answer" rows="6" 
                                      required>{{ old('answer', $faq->answer) }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update FAQ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
