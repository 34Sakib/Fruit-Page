@extends('backend.layouts.master')

@section('title', 'FruitMart Admin - Dashboard')


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
        <a href="{{ route('admin.users.admins') }}" class="text-dark">
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
        <a href="{{ route('admin.orders.index') }}" class="text-dark">
          <div class="info-box mb-3">
            <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Total Orders</span>
              <span class="info-box-number total-orders-counter">{{ number_format($totalOrders) }}</span>
            </div>
          </div>
        </a>
      </div>
      <!-- /.col -->

      <!-- Revenue -->
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-dollar-sign"></i></span>
          <div class="info-box-content">
            <span class="info-box-text">Total Revenue</span>
            <span class="info-box-number revenue-counter">${{ number_format($totalRevenue, 2) }}</span>
          </div>
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->


    <div class="row">
      <!-- Order Statistics -->
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-chart-line mr-1"></i>
              Revenue Overview (Last 6 Months)
            </h3>
          </div>
          <div class="card-body">
            <div id="chart-container">
              <canvas id="revenueChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
            @if(empty(array_filter($revenueData)))
            <div id="no-data-message" class="text-center py-5">
              <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
              <p class="text-muted">No revenue data available yet.</p>
            </div>
            @endif
          </div>
        </div>
      </div>
      
      <!-- Order Status -->
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-shopping-cart mr-1"></i>
              Order Status
            </h3>
          </div>
          <div class="card-body p-0">
            <ul class="nav flex-column">
              <li class="p-3 border-bottom">
                <div class="d-flex justify-content-between">
                  <span>Pending Orders</span>
                  <span class="badge bg-warning">{{ $orderStatuses['pending'] ?? 0 }}</span>
                </div>
                <div class="progress progress-sm mt-2">
                  <div class="progress-bar bg-warning" style="width: {{ $totalOrders > 0 ? (($orderStatuses['pending'] ?? 0) / $totalOrders * 100) : 0 }}%"></div>
                </div>
              </li>
              <li class="p-3 border-bottom">
                <div class="d-flex justify-content-between">
                  <span>Processing Orders</span>
                  <span class="badge bg-info">{{ $orderStatuses['processing'] ?? 0 }}</span>
                </div>
                <div class="progress progress-sm mt-2">
                  <div class="progress-bar bg-info" style="width: {{ $totalOrders > 0 ? (($orderStatuses['processing'] ?? 0) / $totalOrders * 100) : 0 }}%"></div>
                </div>
              </li>
              <li class="p-3 border-bottom">
                <div class="d-flex justify-content-between">
                  <span>Completed Orders</span>
                  <span class="badge bg-success">{{ $orderStatuses['completed'] ?? 0 }}</span>
                </div>
                <div class="progress progress-sm mt-2">
                  <div class="progress-bar bg-success" style="width: {{ $totalOrders > 0 ? (($orderStatuses['completed'] ?? 0) / $totalOrders * 100) : 0 }}%"></div>
                </div>
              </li>
              <li class="p-3">
                <div class="d-flex justify-content-between">
                  <span>Cancelled Orders</span>
                  <span class="badge bg-danger">{{ $orderStatuses['cancelled'] ?? 0 }}</span>
                </div>
                <div class="progress progress-sm mt-2">
                  <div class="progress-bar bg-danger" style="width: {{ $totalOrders > 0 ? (($orderStatuses['cancelled'] ?? 0) / $totalOrders * 100) : 0 }}%"></div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
    <!-- Recent Orders -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              <i class="fas fa-shopping-bag mr-1"></i>
              Recent Orders
            </h3>
            <div class="card-tools">
              <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">View All Orders</a>
            </div>
          </div>
          <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                  <th>Order #</th>
                  <th>Customer</th>
                  <th>Date</th>
                  <th>Status</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                    $recentOrders = $recentOrders ?? collect([]);
                @endphp
                @forelse($recentOrders as $order)
                <tr>
                  <td>#{{ $order->order_number }}</td>
                  <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                  <td>{{ $order->created_at->format('M d, Y') }}</td>
                  <td>
                    <span class="badge 
                      @if($order->status == 'completed') bg-success
                      @elseif($order->status == 'cancelled') bg-danger
                      @else bg-warning
                      @endif order-status-badge">
                      {{ ucfirst($order->status) }}
                    </span>
                  </td>
                  <td class="order-total">${{ number_format($order->total, 2) }}</td>
                  <td>
                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info view-order" data-order-id="{{ $order->id }}">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="6" class="text-center">No orders found.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
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
<!-- ChartJS -->
<script src="{{ asset('backend/plugins/chart.js/Chart.min.js') }}"></script>

<script>
// Global variable to store chart instances
window.chartInstances = [];

// Initialize when document is ready
$(function () {
  'use strict'
  
  // Debug info
  console.log('Dashboard script loaded');
  
  // Initialize Revenue Chart if data is available
  @if(!empty($revenueData) && !empty($months))
  var revenueCtx = document.getElementById('revenueChart').getContext('2d');
  var revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
      labels: {!! json_encode($months) !!},
      datasets: [{
        label: 'Revenue',
        data: {!! json_encode($revenueData) !!},
        backgroundColor: 'rgba(60, 141, 188, 0.2)',
        borderColor: 'rgba(60, 141, 188, 1)',
        borderWidth: 2,
        pointBackgroundColor: '#3b8bba',
        pointBorderColor: '#3b8bba',
        pointRadius: 4,
        pointHoverRadius: 6,
        tension: 0.1,
        fill: true
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          display: false
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return 'Revenue: $' + context.parsed.y.toFixed(2);
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: function(value) {
              return '$' + value.toLocaleString();
            }
          }
        }
      }
    }
  });
  @endif
  console.log('CSRF Token:', '{{ csrf_token() }}');
  console.log('Dashboard data URL:', '{{ route("admin.dashboard.data") }}');
  
  // Global variable to store the chart instance
  var revenueChart;

  // Make the dashboard widgets interactive
  $('.info-box').hover(
    function() {
      $(this).addClass('elevation-3');
    },
    function() {
      $(this).removeClass('elevation-3');
    }
  );

  // Function to animate counter
  function animateCounter(element, target) {
    var $this = $(element);
    var current = parseInt($this.text().replace(/[^0-9.]/g, '') || '0');
    
    $({ countNum: current }).animate({
      countNum: target
    }, {
      duration: 1000,
      easing: 'swing',
      step: function() {
        var prefix = $this.text().match(/^\$/) ? '$' : '';
        $this.text(prefix + Math.floor(this.countNum).toLocaleString());
      },
      complete: function() {
        var prefix = $this.text().match(/^\$/) ? '$' : '';
        $this.text(prefix + target.toLocaleString());
      }
    });
  }
  
  // Function to update the dashboard data
  function updateDashboard() {
    console.log('Fetching dashboard data...');
    
    // Show loading state
    $('.dashboard-loading').show();
    
    $.ajax({
      url: '{{ route("admin.dashboard.data") }}',
      method: 'GET',
      dataType: 'json',
      headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      success: function(response) {
        console.log('Dashboard data received:', response);
        $('.dashboard-loading').hide();
        
        if (!response.success) {
          console.error('Error in dashboard data:', response.message);
          return;
        }
        if (response.success) {
          // Log the totalOrders value from the response
          console.log('Total Orders from response:', response.totalOrders);
          // Update order status counts and progress bars
          const pendingOrders = parseInt(response.pendingOrders) || 0;
          const completedOrders = parseInt(response.completedOrders) || 0;
          const cancelledOrders = parseInt(response.cancelledOrders) || 0;
          const totalOrders = pendingOrders + completedOrders + cancelledOrders;
          
          console.log('Order stats:', { pendingOrders, completedOrders, cancelledOrders, totalOrders });
          
          // Update pending orders
          $('.pending-orders-count').text(pendingOrders);
          const pendingPercent = totalOrders > 0 ? (pendingOrders / totalOrders * 100) : 0;
          $('.pending-orders-progress').css('width', pendingPercent + '%');
          
          // Update completed orders
          $('.completed-orders-count').text(completedOrders);
          const completedPercent = totalOrders > 0 ? (completedOrders / totalOrders * 100) : 0;
          $('.completed-orders-progress').css('width', completedPercent + '%');
          
          // Update cancelled orders
          $('.cancelled-orders-count').text(cancelledOrders);
          const cancelledPercent = totalOrders > 0 ? (cancelledOrders / totalOrders * 100) : 0;
          $('.cancelled-orders-progress').css('width', cancelledPercent + '%');
          
          // Update total orders counter
          if (response.totalOrders !== undefined) {
            const totalOrders = parseInt(response.totalOrders) || 0;
            console.log('Updating total orders counter:', totalOrders);
            
            // Directly update the counter without animation first to ensure it shows up
            $('.total-orders-counter').text(totalOrders.toLocaleString());
            
            // Then animate if needed
            const currentValue = parseInt($('.total-orders-counter').text().replace(/[^0-9]/g, '') || '0');
            if (currentValue !== totalOrders) {
              $({ countNum: currentValue }).animate(
                { countNum: totalOrders },
                {
                  duration: 1000,
                  easing: 'swing',
                  step: function(now) {
                    $('.total-orders-counter').text(Math.floor(now).toLocaleString());
                  },
                  complete: function() {
                    $('.total-orders-counter').text(totalOrders.toLocaleString());
                  }
                }
              );
            }
          }
          
          // Update total revenue with animation
          if (response.totalRevenue) {
            const revenueValue = typeof response.totalRevenue === 'string' 
              ? parseFloat(response.totalRevenue.replace(/[^0-9.]/g, '')) 
              : parseFloat(response.totalRevenue);
            console.log('Updating revenue counter with value:', revenueValue);
            animateCounter($('.revenue-counter'), revenueValue);
          }
          
          // Update recent orders table
          var recentOrdersHtml = '';
          if (response.recentOrders && response.recentOrders.length > 0) {
            response.recentOrders.forEach(function(order) {
              var statusClass = '';
              switch(order.status) {
                case 'completed': statusClass = 'bg-success'; break;
                case 'cancelled': statusClass = 'bg-danger'; break;
                default: statusClass = 'bg-warning';
              }
              
              recentOrdersHtml += `
                <tr>
                  <td>#${order.order_number}</td>
                  <td>${order.first_name} ${order.last_name}</td>
                  <td>${new Date(order.created_at).toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'})}</td>
                  <td><span class="badge ${statusClass}">${order.status.charAt(0).toUpperCase() + order.status.slice(1)}</span></td>
                  <td>$${parseFloat(order.total).toFixed(2)}</td>
                  <td><a href="${order.view_url}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i></a></td>
                </tr>`;
            });
          } else {
            recentOrdersHtml = '<tr><td colspan="6" class="text-center">No orders found.</td></tr>';
          }
          $('table.table-hover tbody').html(recentOrdersHtml);
          
          // Update the chart if we have data
          if (response.chartData && response.chartData.labels && response.chartData.data) {
            console.log('Chart data received:', response.chartData);
            
            // Format the chart data
            const chartData = {
              labels: response.chartData.labels,
              data: response.chartData.data.map(value => parseFloat(value) || 0)
            };
            
            // Check if all data values are zero
            const allZeros = chartData.data.every(value => value === 0);
            
            if (allZeros) {
              console.log('All chart data values are zero, hiding chart');
              const chartContainer = document.getElementById('chart-container');
              const noDataMessage = document.getElementById('no-data-message');
              if (chartContainer) chartContainer.style.display = 'none';
              if (noDataMessage) noDataMessage.style.display = 'block';
              return;
            }
            
            // Initialize or update the chart
            try {
              initRevenueChart(chartData);
            } catch (e) {
              console.error('Error initializing revenue chart:', e);
            }
          } else {
            console.log('No chart data available in response');
            const chartContainer = document.getElementById('chart-container');
            const noDataMessage = document.getElementById('no-data-message');
            if (chartContainer) chartContainer.style.display = 'none';
            if (noDataMessage) noDataMessage.style.display = 'block';
          }
        }
      },
      error: function(xhr, status, error) {
        console.error('Error updating dashboard:', {
          status: xhr.status,
          statusText: xhr.statusText,
          responseText: xhr.responseText
        });
        $('.dashboard-loading').hide();
        
        // Show error message
        const errorMessage = xhr.responseJSON?.message || 'Failed to load dashboard data';
        console.error('Dashboard error:', errorMessage);
      }
    });
  }
  
    function initDashboard() {
    console.log('Initializing dashboard...');

    if ($('.dashboard-loading').length === 0) {
      $('.card').prepend('<div class="dashboard-loading" style="display: none; position: absolute; top: 10px; right: 10px; z-index: 1000;"><i class="fas fa-sync fa-spin text-primary"></i> Updating...</div>');
    }

    updateDashboard();

    if (window.dashboardInterval) {
      clearInterval(window.dashboardInterval);
    }

    window.dashboardInterval = setInterval(updateDashboard, 30000);

    if ($('.refresh-dashboard').length === 0) {
      $('.card-header').append('<button class="btn btn-sm btn-outline-primary float-right ml-2 refresh-dashboard"><i class="fas fa-sync"></i> Refresh</button>');
    }

    $(document).off('click', '.refresh-dashboard').on('click', '.refresh-dashboard', function() {
      updateDashboard();
    });

    $(document).on('click', 'table.table-hover tbody tr', function() {
      var href = $(this).find('a').attr('href');
      if (href) {
        window.location = href;
      }
    }).css('cursor', 'pointer');
  }

  // Function to initialize or update the revenue chart
  function initRevenueChart(chartData) {
    console.log('Initializing revenue chart with data:', chartData);
    
    // Validate chart data structure
    if (!chartData) {
      console.error('Chart data is null or undefined');
      return;
    }
    
    const chartContainer = document.getElementById('chart-container');
    const noDataMessage = document.getElementById('no-data-message');
    
    // Check if we have data to display
    const hasData = chartData && chartData.data && chartData.data.length > 0 && 
                   chartData.labels && chartData.labels.length > 0;
    
    console.log('Has data:', hasData, 'Data length:', chartData.data?.length, 'Labels length:', chartData.labels?.length);
    
    // Show/hide elements based on data availability
    if (hasData) {
      if (chartContainer) chartContainer.style.display = 'block';
      if (noDataMessage) noDataMessage.style.display = 'none';
    } else {
      if (chartContainer) chartContainer.style.display = 'none';
      if (noDataMessage) noDataMessage.style.display = 'block';
      console.log('No data available for chart');
      return; // No data to display
    }
    
    // Get the canvas element
    var ctx = document.getElementById('revenueChart');
    if (!ctx) {
      console.error('Revenue chart canvas not found');
      return;
    }
    
    // Safely destroy existing chart instance if it exists
    if (window.revenueChart && typeof window.revenueChart.destroy === 'function') {
      try {
        window.revenueChart.destroy();
      } catch (e) {
        console.warn('Error destroying previous chart:', e);
      }
    }
    
    // Create new chart instance
    window.revenueChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: chartData.labels,
        datasets: [{
          label: 'Revenue',
          backgroundColor: 'rgba(60,141,188,0.9)',
          borderColor: 'rgba(60,141,188,0.8)',
          pointRadius: 4,
          pointBackgroundColor: '#3b8bba',
          pointBorderColor: 'rgba(255,255,255,0.8)',
          pointHoverRadius: 5,
          pointHoverBackgroundColor: '#3b8bba',
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: chartData.data,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            mode: 'index',
            intersect: false,
            callbacks: {
              label: function(context) {
                return '$' + context.parsed.y.toFixed(2);
              }
            }
          }
        },
        scales: {
          x: {
            grid: {
              display: false
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return '$' + value;
              }
            }
          }
        }
      }
    });
  }

  // Initialize the dashboard when the page loads
  $(document).ready(function() {
    initDashboard();
  });
});
</script>
@endsection
