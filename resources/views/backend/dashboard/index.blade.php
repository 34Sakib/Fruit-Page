@extends('backend.layouts.master')

@section('title', 'FruitMart Admin - Dashboard')

@section('dashboard-scripts')
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend/dist/js/pages/dashboard2.js') }}"></script>
@endsection

@section('page_title', 'Dashboard')

@section('breadcrumb')
  <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
  <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<div class="container-fluid">
    <!-- Info boxes -->
    <div class="row">
      <!-- Products -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('admin.products.index') }}" class="text-dark">
          <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-apple-alt"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Products</span>
              <span class="info-box-number">
                {{ number_format($totalProducts) }}
                <small>items</small>
              </span>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->

      <!-- Categories -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('admin.categories.index') }}" class="text-dark">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tags"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Categories</span>
              <span class="info-box-number">{{ number_format($totalCategories) }}</span>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->

      <!-- Users -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('admin.users.index') }}" class="text-dark">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Users</span>
              <span class="info-box-number">{{ number_format($totalUsers) }}</span>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->

      <!-- Admins -->
      <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="text-dark">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-indigo elevation-1"><i class="fas fa-user-shield"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Administrators</span>
              <span class="info-box-number">{{ number_format($totalAdmins) }}</span>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->

      <!-- Orders -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Orders</span>
            <span class="info-box-number">{{ number_format($totalOrders) }}</span>
          </div>
        </div>
      </div>
      <!-- /.col -->

      <!-- Revenue -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Revenue</span>
            <span class="info-box-number">${{ number_format($totalRevenue, 2) }}</span>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->


    <!-- Welcome Card -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-pie mr-1"></i>
              FruitMart Dashboard
            </h3>
          </div>
        </div>
      </div>
    </div>
    <!-- /.row -->
  </div><!--/. container-fluid -->
</section>
<!-- /.content -->
@endsection

@section('scripts')
<!-- Dashboard specific scripts -->
<script>
$(function () {
  'use strict'

  // Make the dashboard widgets interactive
  $('.info-box').hover(
    function() {
      $(this).addClass('elevation-3');
    },
    function() {
      $(this).removeClass('elevation-3');
    }
  );

  // Add some animation to the stats
  $('.description-header').each(function() {
    var $this = $(this);
    var countTo = $this.text().replace(/[^0-9.]/g, '');
    if (countTo) {
      $({ countNum: 0 }).animate({
        countNum: countTo
      }, {
        duration: 2000,
        easing: 'linear',
        step: function() {
          var prefix = $this.text().match(/^\$/) ? '$' : '';
          $this.text(prefix + Math.floor(this.countNum).toLocaleString());
        },
        complete: function() {
          var prefix = $this.text().match(/^\$/) ? '$' : '';
          $this.text(prefix + countTo);
        }
      });
    }
  });
});
</script>
@endsection
