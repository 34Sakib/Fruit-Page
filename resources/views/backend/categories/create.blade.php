@extends('backend.layouts.master')

@section('title', 'Create Category')

@section('content')
    @php
        $parentCategories = \App\Models\Category::whereNull('parent_id')->get();
    @endphp
    
    @include('backend.categories.form', [
        'formAction' => route('admin.categories.store'),
        'method' => 'POST',
        'category' => null,
        'parentCategories' => $parentCategories,
        'buttonText' => 'Create Category'
    ])
@endsection
