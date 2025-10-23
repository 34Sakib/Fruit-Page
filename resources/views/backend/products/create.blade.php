@extends('backend.layouts.master')

@section('title', 'Add New Product - FruitMart Admin')

@section('content')
<div class="content-wrapper">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add New Product</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @include('backend.products.form')
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection
