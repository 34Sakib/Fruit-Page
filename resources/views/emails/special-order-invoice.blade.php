<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Special Order Invoice - {{ $specialOrder->order_number }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .invoice-container {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #2ecc71, #1abc9c);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 1.1rem;
        }
        .content {
            padding: 40px 30px;
        }
        .section {
            margin-bottom: 30px;
            padding: 20px;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .section h3 {
            margin: 0 0 15px 0;
            color: #2c3e50;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
        }
        .section h3 i {
            margin-right: 10px;
            color: #2ecc71;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-item strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 5px;
        }
        .product-details {
            background: white;
            padding: 20px;
            border-radius: 8px;
            border: 2px solid #2ecc71;
        }
        .price-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .price-table th,
        .price-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #e0e0e0;
        }
        .price-table th {
            background: #2ecc71;
            color: white;
            font-weight: 600;
        }
        .price-table .total {
            font-size: 1.2rem;
            font-weight: 700;
            color: #2ecc71;
        }
        .tracking-info {
            background: #e8f5e8;
            border-left: 4px solid #27ae60;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .tracking-info h4 {
            margin: 0 0 10px 0;
            color: #27ae60;
        }
        .footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            font-size: 0.9rem;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.9rem;
        }
        .status-approved { background: #d4edda; color: #155724; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d1ecf1; color: #0c5460; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <h1><i class="fas fa-star"></i> Special Order Invoice</h1>
            <p>Order #{{ $specialOrder->order_number }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Customer Information -->
            <div class="section">
                <h3><i class="fas fa-user"></i> Customer Information</h3>
                <div class="info-grid">
                    <div>
                        <div class="info-item">
                            <strong>Name:</strong> {{ $specialOrder->customer_name }}
                        </div>
                        <div class="info-item">
                            <strong>Email:</strong> {{ $specialOrder->email }}
                        </div>
                        <div class="info-item">
                            <strong>Phone:</strong> {{ $specialOrder->phone }}
                        </div>
                    </div>
                    <div>
                        <div class="info-item">
                            <strong>Delivery Location:</strong> 
                            {{ $specialOrder->is_inside_dhaka ? 'Inside Dhaka' : 'Outside Dhaka' }}
                        </div>
                        <div class="info-item">
                            <strong>Address:</strong> {{ $specialOrder->address }}
                        </div>
                        <div class="info-item">
                            <strong>Status:</strong> 
                            <span class="status-badge status-{{ $specialOrder->status }}">
                                {{ ucfirst($specialOrder->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Information -->
            <div class="section">
                <h3><i class="fas fa-box"></i> Product Information</h3>
                <div class="product-details">
                    <div class="info-item">
                        <strong>Category:</strong> {{ $specialOrder->category->name }}
                    </div>
                    @if($specialOrder->product)
                        <div class="info-item">
                            <strong>Product:</strong> {{ $specialOrder->product->name }}
                        </div>
                    @else
                        <div class="info-item">
                            <strong>Custom Product:</strong> {{ $specialOrder->product_name }}
                        </div>
                    @endif
                    <div class="info-item">
                        <strong>Quantity:</strong> {{ $specialOrder->quantity }} kg
                    </div>
                    @if($specialOrder->price_notes)
                        <div class="info-item">
                            <strong>Special Requirements:</strong> {{ $specialOrder->price_notes }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Pricing Details -->
            <div class="section">
                <h3><i class="fas fa-dollar-sign"></i> Pricing Details</h3>
                <table class="price-table">
                    <tr>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    <tr>
                        <td>
                            @if($specialOrder->product)
                                {{ $specialOrder->product->name }}
                            @else
                                {{ $specialOrder->product_name }}
                            @endif
                        </td>
                        <td>{{ $specialOrder->quantity }} kg</td>
                        <td>৳{{ number_format($specialOrder->final_price ?? $specialOrder->proposed_price ?? 0, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Delivery Charge</strong></td>
                        <td>৳{{ number_format($specialOrder->delivery_charge, 2) }}</td>
                    </tr>
                    @if($specialOrder->courierService)
                    <tr>
                        <td colspan="2"><strong>Courier Service ({{ $specialOrder->courierService->name }})</strong></td>
                        <td>৳{{ number_format($specialOrder->courier_charge, 2) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td colspan="2"><strong>Total Amount</strong></td>
                        <td class="total">৳{{ number_format($specialOrder->total_price, 2) }}</td>
                    </tr>
                </table>
            </div>

            <!-- Tracking Information -->
            @if($specialOrder->tracking_number || $specialOrder->courier_tracking_number)
                <div class="tracking-info">
                    <h4><i class="fas fa-truck"></i> Tracking Information</h4>
                    @if($specialOrder->tracking_number)
                    <div class="info-item">
                        <strong>Order Tracking Number:</strong> {{ $specialOrder->tracking_number }}
                    </div>
                    @endif
                    @if($specialOrder->courierService)
                    <div class="info-item">
                        <strong>Courier Service:</strong> {{ $specialOrder->courierService->name }}
                        @if($specialOrder->courierService->contact_phone)
                        ({{ $specialOrder->courierService->contact_phone }})
                        @endif
                    </div>
                    @endif
                    @if($specialOrder->courier_tracking_number)
                    <div class="info-item">
                        <strong>Courier Tracking Number:</strong> {{ $specialOrder->courier_tracking_number }}
                    </div>
                    @endif
                    <p>You can track your order status using the tracking number(s) above or by contacting our customer support.</p>
                </div>
            @endif

            <!-- Admin Notes -->
            @if($specialOrder->admin_notes)
                <div class="section">
                    <h3><i class="fas fa-sticky-note"></i> Important Notes</h3>
                    <p>{{ $specialOrder->admin_notes }}</p>
                </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>FruitMart</strong> - Fresh Fruits & Vegetables Delivered to Your Doorstep</p>
            <p>Contact: support@fruitmart.com | Phone: 01641555173</p>
            <p>This is an automatically generated invoice. Please keep it for your records.</p>
        </div>
    </div>
</body>
</html>
