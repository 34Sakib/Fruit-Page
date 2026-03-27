@extends('frontend.layouts.master')

@section('title', 'Order Confirmation - Organic Fresh')

@push('styles')
    <style>
        .order-success {
            text-align: center;
            padding: 4rem 0;
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }
        
        @media (min-width: 768px) {
            .order-success {
                padding: 4rem 2rem;
            }
        }
        
        .success-icon {
            font-size: 5rem;
            color: #2ecc71;
            margin-bottom: 2rem;
        }
        
        .order-success h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            color: #2c3e50;
        }
        
        .order-success p {
            font-size: 1.2rem;
            color: #7f8c8d;
            margin-bottom: 2rem;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.6;
        }
        
        .order-details {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 2rem;
            margin: 2rem auto;
            max-width: 600px;
            text-align: left;
        }
        
        .order-details h3 {
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            color: #2c3e50;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 0.75rem;
        }
        
        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px dashed #e9ecef;
        }
        
        .detail-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        
        .detail-label {
            font-weight: 600;
            color: #2c3e50;
        }
        
        .detail-value {
            color: #7f8c8d;
        }
        
        .btn-container {
            margin-top: 2rem;
        }
        
        .btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            margin: 0 0.5rem;
        }
        
        .btn-primary {
            background: #2ecc71;
            color: white;
            border: 2px solid #2ecc71;
        }
        
        .btn-primary:hover {
            background: #27ae60;
            border-color: #27ae60;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(46, 204, 113, 0.3);
        }
        
        .btn-outline {
            background: transparent;
            color: #2ecc71;
            border: 2px solid #2ecc71;
        }
        
        .btn-outline:hover {
            background: rgba(46, 204, 113, 0.1);
            transform: translateY(-2px);
        }
        
        @media (max-width: 576px) {
            .order-success {
                padding: 2rem 1rem;
            }
            
            .order-success h1 {
                font-size: 2rem;
            }
            
            .btn-container {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            
            .btn {
                width: 100%;
                margin: 0;
            }
        }
    </style>
@endpush

@section('content')
    <div class="order-success">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <h1>Thank You for Your Order!</h1>
        
        <p>Your order has been placed successfully. We've sent a confirmation email to your registered email address with all the details.</p>
        
        @if(isset($order) && $order)
            <div class="order-details">
                <h3>Order Summary</h3>
                
                <div class="detail-row">
                    <span class="detail-label">Order Number:</span>
                    <span class="detail-value">#{{ $order->order_number }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Order Date:</span>
                    <span class="detail-value">{{ $order->created_at->format('F j, Y') }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Order Status:</span>
                    <span class="detail-value">
                        <span class="badge {{ $order->status === 'completed' ? 'badge-success' : 'badge-info' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Items:</span>
                    <span class="detail-value">{{ $order->items->sum('quantity') }} items</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Subtotal:</span>
                    <span class="detail-value">৳{{ number_format($order->subtotal, 2) }}</span>
                </div>
                
                @if($order->discount > 0)
                    <div class="detail-row">
                        <span class="detail-label">Discount:</span>
                        <span class="detail-value text-success">-৳{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                
                @if($order->tax > 0)
                    <div class="detail-row">
                        <span class="detail-label">Tax:</span>
                        <span class="detail-value">৳{{ number_format($order->tax, 2) }}</span>
                    </div>
                @endif
                
                <div class="detail-row">
                    <span class="detail-label">Shipping:</span>
                    <span class="detail-value">৳{{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                
                <div class="detail-row total-row">
                    <span class="detail-label">Total Amount:</span>
                    <span class="detail-value">৳{{ number_format($order->total, 2) }}</span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Payment Method:</span>
                    <span class="detail-value">
                        @switch($order->payment_method)
                            @case('cod')
                                Cash on Delivery
                                @break
                            @case('bkash')
                                bKash
                                @break
                            @case('nagad')
                                Nagad
                                @break
                            @case('card')
                                Credit/Debit Card
                                @break
                            @default
                                {{ ucfirst($order->payment_method) }}
                        @endswitch
                        
                        @if($order->payment_status === 'paid')
                            <span class="badge badge-success ml-2">Paid</span>
                        @else
                            <span class="badge badge-warning ml-2">Pending</span>
                        @endif
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Delivery Method:</span>
                    <span class="detail-value">
                        {{ $order->delivery_method === 'express' ? 'Express Delivery' : 'Standard Delivery' }}
                        ({{ $order->delivery_method === 'express' ? '1-2 business days' : '3-5 business days' }})
                    </span>
                </div>
                
                <div class="detail-row">
                    <span class="detail-label">Delivery Status:</span>
                    <span class="detail-value">
                        <span class="badge 
                            {{ $order->delivery_status === 'delivered' ? 'badge-success' : 
                              ($order->delivery_status === 'shipped' ? 'badge-primary' : 'badge-secondary') }}">
                            {{ ucfirst($order->delivery_status) }}
                        </span>
                    </span>
                </div>
                
                <!-- Order Items -->
                <div class="order-items mt-4">
                    <h4>Ordered Items</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @php
                                                    $imagePath = null;
                                                    
                                                    // Check image source in order of priority
                                                    if ($item->image) {
                                                        // If image is stored directly in order item
                                                        $imagePath = str_starts_with($item->image, 'http') 
                                                            ? $item->image 
                                                            : (
                                                                str_starts_with($item->image, 'products/') 
                                                                ? asset('storage/' . $item->image) 
                                                                : asset('storage/products/' . $item->image)
                                                              );
                                                    } elseif (isset($item->options['image'])) {
                                                        // Fallback to image in options
                                                        $imagePath = str_starts_with($item->options['image'], 'http')
                                                            ? $item->options['image']
                                                            : asset('storage/' . $item->options['image']);
                                                    } elseif ($item->product && $item->product->image) {
                                                        // Fallback to product relationship
                                                        $imagePath = str_starts_with($item->product->image, 'http')
                                                            ? $item->product->image
                                                            : asset('storage/' . $item->product->image);
                                                    }
                                                @endphp
                                                
                                                @if($imagePath)
                                                    <img src="{{ $imagePath }}" 
                                                         alt="{{ $item->name }}" 
                                                         class="img-thumbnail me-3" 
                                                         style="width: 60px; height: 60px; object-fit: cover;
                                                         @if(!@getimagesize(public_path(parse_url($imagePath, PHP_URL_PATH)))) display:none; @endif">
                                                @endif
                                                
                                                <div>
                                                    <h6 class="mb-0">{{ $item->name }}</h6>
                                                    @if(isset($item->options['weight']))
                                                        <small class="text-muted">{{ $item->options['weight'] }}</small>
                                                    @endif
                                                    @if(app()->environment('local') && $item->image)
                                                        <div class="text-muted small">{{ $item->image }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>৳{{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>৳{{ number_format($item->price * $item->quantity, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- Delivery Address -->
                <div class="delivery-address mt-4">
                    <h4>Delivery Address</h4>
                    <address>
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->postal_code }}<br>
                        {{ $order->country }}<br>
                        <i class="fas fa-phone me-2"></i> {{ $order->phone }}<br>
                        <i class="fas fa-envelope me-2"></i> {{ $order->email }}
                    </address>
                </div>
                
                <!-- Order Notes -->
                @if($order->notes)
                    <div class="order-notes mt-4">
                        <h4>Order Notes</h4>
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                @endif
            </div>
        @endif
        
        <div class="btn-container">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i class="fas fa-home me-2"></i> Back to Home
            </a>
            
            <a href="{{ route('home') }}" class="btn btn-outline">
                <i class="fas fa-shopping-bag me-2"></i> Continue Shopping
            </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Add animation to the success icon
        document.addEventListener('DOMContentLoaded', function() {
            const successIcon = document.querySelector('.success-icon i');
            if (successIcon) {
                successIcon.style.opacity = '0';
                successIcon.style.transform = 'scale(0.5)';
                successIcon.style.transition = 'all 0.6s ease';
                
                setTimeout(() => {
                    successIcon.style.opacity = '1';
                    successIcon.style.transform = 'scale(1)';
                }, 100);
            }
            
            // Animate order details
            const details = document.querySelectorAll('.detail-row');
            details.forEach((row, index) => {
                row.style.opacity = '0';
                row.style.transform = 'translateX(20px)';
                row.style.transition = `all 0.5s ease ${index * 0.1}s`;
                
                setTimeout(() => {
                    row.style.opacity = '1';
                    row.style.transform = 'translateX(0)';
                }, 300 + (index * 100));
            });
        });
    </script>
@endpush
