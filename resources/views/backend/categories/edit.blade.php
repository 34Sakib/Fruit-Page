@extends('backend.layouts.master')

@section('title', 'Edit Category')

@section('content')
    @php
        $parentCategories = \App\Models\Category::where('id', '!=', $category->id)
            ->where(function($query) use ($category) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '!=', $category->id);
            })
            ->get();
    @endphp
    
    @include('backend.categories.form', [
        'formAction' => route('admin.categories.update', $category->id),
        'method' => 'PUT',
        'category' => $category,
        'parentCategories' => $parentCategories,
        'buttonText' => 'Update Category'
    ])
@endsection
