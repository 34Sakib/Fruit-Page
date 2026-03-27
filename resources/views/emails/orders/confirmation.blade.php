<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - #{{ $order->order_number }}</title>
    <style>
        /* Base styles */
        body {
            font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #2c3e50;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
        }
        
        /* Container */
        .email-container {
            max-width: 650px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        /* Header */
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }
        
        .header h1 {
            margin: 0 0 15px 0;
            font-size: 32px;
            font-weight: 700;
            position: relative;
            z-index: 2;
        }
        
        .header p {
            margin: 0;
            font-size: 18px;
            opacity: 0.9;
            position: relative;
            z-index: 2;
        }
        
        .header-icon {
            font-size: 48px;
            margin-bottom: 20px;
            display: block;
            position: relative;
            z-index: 2;
        }
        
        /* Content */
        .content {
            padding: 40px 35px;
        }
        
        /* Order info */
        .order-info {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 30px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        
        .order-info h2 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .order-info h2::before {
            content: '📦';
            font-size: 24px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        
        .info-item {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .info-label {
            font-weight: 600;
            color: #667eea;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            font-weight: 500;
            color: #2c3e50;
            font-size: 16px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 6px 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            text-transform: capitalize;
        }
        
        .payment-status {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 4px 12px;
            border-radius: 15px;
            font-size: 14px;
            font-weight: 600;
        }
        
        .payment-status.paid {
            background: rgba(39, 174, 96, 0.1);
            color: #27ae60;
        }
        
        .payment-status.pending {
            background: rgba(230, 126, 34, 0.1);
            color: #e67e22;
        }
        
        /* Order items */
        .section-title {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .section-title::before {
            content: '🛒';
            font-size: 20px;
        }
        
        .order-items {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin: 25px 0;
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }
        
        .order-items th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 18px 15px;
            text-align: left;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .order-items th:first-child {
            border-top-left-radius: 15px;
        }
        
        .order-items th:last-child {
            border-top-right-radius: 15px;
        }
        
        .order-items td {
            padding: 20px 15px;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            vertical-align: top;
        }
        
        .order-items tr:last-child td {
            border-bottom: none;
        }
        
        .order-items .product {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .order-items .product img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #f8f9ff;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        
        .order-items .product img:hover {
            transform: scale(1.05);
        }
        
        .order-items .product-info h4 {
            margin: 0 0 8px 0;
            color: #2c3e50;
            font-weight: 600;
            font-size: 16px;
        }
        
        .order-items .product-info p {
            margin: 0;
            color: #7f8c8d;
            font-size: 14px;
        }
        
        .order-items td {
            font-weight: 500;
            color: #2c3e50;
        }
        
        /* Totals */
        .totals {
            margin-top: 30px;
            text-align: right;
        }
        
        .totals table {
            width: 100%;
            max-width: 350px;
            margin-left: auto;
            border-collapse: separate;
            border-spacing: 0;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        
        .totals td {
            padding: 15px 20px;
            border-bottom: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .totals .label {
            text-align: left;
            padding-right: 20px;
            color: #667eea;
            font-weight: 600;
        }
        
        .totals .amount {
            text-align: right;
            font-weight: 600;
            color: #2c3e50;
        }
        
        .totals .total-row td {
            border-top: 2px solid rgba(102, 126, 234, 0.2);
            padding-top: 20px;
            font-size: 20px;
            color: #2c3e50;
            background: rgba(102, 126, 234, 0.05);
        }
        
        .discount {
            color: #e74c3c !important;
        }
        
        /* Delivery Address */
        .address-section {
            margin-top: 40px;
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            padding: 30px;
            border-radius: 15px;
            border: 1px solid rgba(102, 126, 234, 0.1);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.1);
        }
        
        .address-section h3 {
            color: #2c3e50;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 20px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .address-section h3::before {
            content: '🏠';
            font-size: 18px;
        }
        
        .address-content {
            line-height: 1.8;
            color: #2c3e50;
        }
        
        .address-content strong {
            color: #667eea;
        }
        
        .order-notes {
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1px solid rgba(102, 126, 234, 0.2);
        }
        
        .order-notes h4 {
            color: #2c3e50;
            margin-bottom: 12px;
            font-size: 16px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .order-notes h4::before {
            content: '📝';
            font-size: 14px;
        }
        
        /* Order Status */
        .status-section {
            margin-top: 35px;
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.05) 0%, rgba(118, 75, 162, 0.05) 100%);
            border-radius: 15px;
            border: 1px solid rgba(102, 126, 234, 0.1);
        }
        
        .status-section p {
            margin: 0;
            font-size: 16px;
            color: #2c3e50;
        }
        
        .status-section a {
            color: #667eea;
            text-decoration: none;
            font-weight: 700;
            transition: color 0.3s ease;
        }
        
        .status-section a:hover {
            color: #764ba2;
            text-decoration: underline;
        }
        
        /* Footer */
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            padding: 35px 30px;
            text-align: center;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }
        
        .footer p {
            margin: 0 0 15px 0;
        }
        
        .footer-links {
            display: flex;
            justify-content: center;
            gap: 25px;
            margin-bottom: 20px;
        }
        
        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .footer-links a:hover {
            color: #667eea;
        }
        
        .social-links {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }
        
        .social-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .social-links a:hover {
            color: #667eea;
        }
        
        /* Responsive */
        @media only screen and (max-width: 600px) {
            body {
                padding: 10px;
            }
            
            .content {
                padding: 25px 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h1 {
                font-size: 26px;
            }
            
            .info-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .order-info, .address-section {
                padding: 20px;
            }
            
            .order-items {
                display: block;
                overflow-x: auto;
            }
            
            .order-items .product {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }
            
            .order-items .product img {
                width: 80px;
                height: 80px;
            }
            
            .footer-links {
                flex-direction: column;
                gap: 10px;
            }
            
            .totals table {
                max-width: 100%;
            }
        }
        
        /* Print styles */
        @media print {
            body {
                background: white !important;
                padding: 0 !important;
            }
            
            .email-container {
                box-shadow: none !important;
                border: 1px solid #ddd !important;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="header">
            <span class="header-icon">🎉</span>
            <h1>Thank You For Your Order!</h1>
            <p>Your order has been received and is being processed.</p>
        </div>
        
        <!-- Content -->
        <div class="content">
            <div class="order-info">
                <h2>Order #{{ $order->order_number }}</h2>
                
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Order Date</div>
                        <div class="info-value">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Order Status</div>
                        <div class="info-value">
                            <span class="status-badge">{{ $order->status }}</span>
                        </div>
                    </div>
                    
                    <div class="info-item">
                        <div class="info-label">Payment Method</div>
                        <div class="info-value">
                            @switch($order->payment_method)
                                @case('cod')
                                    💰 Cash on Delivery
                                    @break
                                @case('bkash')
                                    📱 bKash
                                    @break
                                @case('nagad')
                                    📲 Nagad
                                    @break
                                @case('card')
                                    💳 Credit/Debit Card
                                    @break
                                @default
                                    {{ ucfirst($order->payment_method) }}
                            @endswitch
                            
                            @if($order->payment_status === 'paid')
                                <span class="payment-status paid">✓ Paid</span>
                            @else
                                <span class="payment-status pending">⏳ Pending</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($order->delivery_method)
                    <div class="info-item">
                        <div class="info-label">Delivery Method</div>
                        <div class="info-value">
                            🚚 {{ $order->delivery_method === 'express' ? 'Express Delivery' : 'Standard Delivery' }}
                            <br>
                            <small style="color: #7f8c8d;">
                                {{ $order->delivery_method === 'express' ? '1-2 business days' : '3-5 business days' }}
                            </small>
                        </div>
                    </div>
                    @endif
                    
                    @if($order->tracking_number)
                    <div class="info-item">
                        <div class="info-label">Tracking Number</div>
                        <div class="info-value">
                            📦 {{ $order->tracking_number }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Items -->
            <h3 class="section-title">Order Items</h3>
            
            <table class="order-items">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            <div class="product">
                                @php
                                    $imageUrl = null;
                                    if (!empty($item->image_url) && $item->image_url !== asset('images/default-product.png')) {
                                        $imageUrl = $item->image_url;
                                    } elseif (isset($item->product) && $item->product->image) {
                                        $imageUrl = asset('storage/' . $item->product->image);
                                    } elseif (!empty($item->options['image'] ?? null)) {
                                        $imageUrl = asset('storage/' . ltrim($item->options['image'], '/'));
                                    }
                                @endphp
                                @if($imageUrl)
                                <img 
                                    src="{{ $imageUrl }}" 
                                    alt="{{ $item->name }}" 
                                    style="display: block; border: 0; outline: none; text-decoration: none; -ms-interpolation-mode: bicubic;" 
                                    width="70" 
                                    height="70"
                                    onerror="this.onerror=null; this.style.display='none';"
                                    loading="lazy">
                                @else
                                <div style="display: flex; align-items: center; justify-content: center; width: 70px; height: 70px; background: #f5f5f5; color: #999; font-size: 20px;">
                                    <i class="fas fa-box-open"></i>
                                </div>
                                @endif
                                <div class="product-info">
                                    <h4>{{ $item->name }}</h4>
                                    @if(isset($item->options['weight']))
                                    <p>{{ $item->options['weight'] }}</p>
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
            
            <!-- Order Totals -->
            <div class="totals">
                <table>
                    <tr>
                        <td class="label">Subtotal:</td>
                        <td class="amount">৳{{ number_format($order->subtotal, 2) }}</td>
                    </tr>
                    
                    @if($order->discount > 0)
                    <tr>
                        <td class="label">Discount:</td>
                        <td class="amount discount">-৳{{ number_format($order->discount, 2) }}</td>
                    </tr>
                    @endif
                    
                    @if($order->tax > 0)
                    <tr>
                        <td class="label">Tax ({{ $order->tax_rate ?? '0' }}%):</td>
                        <td class="amount">৳{{ number_format($order->tax, 2) }}</td>
                    </tr>
                    @endif
                    
                    <tr>
                        <td class="label">Shipping:</td>
                        <td class="amount">৳{{ number_format($order->shipping_cost, 2) }}</td>
                    </tr>
                    
                    <tr class="total-row">
                        <td class="label">Total:</td>
                        <td class="amount">৳{{ number_format($order->total, 2) }}</td>
                    </tr>
                </table>
            </div>
            
            <!-- Delivery Address -->
            <div class="address-section">
                <h3>Delivery Address</h3>
                <div class="address-content">
                    <p>
                        <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                        {{ $order->address }}<br>
                        {{ $order->city }}, {{ $order->postal_code }}<br>
                        {{ $order->country }}<br>
                        <strong>📞 Phone:</strong> {{ $order->phone }}<br>
                        <strong>✉️ Email:</strong> {{ $order->email }}
                    </p>
                    
                    @if($order->notes)
                    <div class="order-notes">
                        <h4>Order Notes</h4>
                        <p style="margin: 0;">{{ $order->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            
            <!-- Order Status -->
            <div class="status-section">
                <p>
                    You can check your order status anytime by 
                    <a href="{{ route('home') }}">logging into your account</a>.
                </p>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <div class="footer-links">
                <a href="{{ route('home') }}">Our Website</a>
                <a href="{{ route('home') }}/contact">Contact Us</a>
                <a href="{{ route('home') }}/privacy-policy">Privacy Policy</a>
            </div>
            
            <p>© {{ date('Y') }} Fruitmart. All rights reserved.</p>
            
            <div class="social-links">
                <a href="#">Facebook</a>
                <a href="#">Twitter</a>
                <a href="#">Instagram</a>
                <a href="#">LinkedIn</a>
            </div>
        </div>
    </div>
</body>
</html>