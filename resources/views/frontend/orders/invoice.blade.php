<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $order->order_number }}</title>

    <style>
        /* Base Styles */
        body {
            font-family: 'DejaVu Sans', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 10px;
            color: #2c3e50;
            line-height: 1.3;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .container {
            width: 100%;
            max-width: 750px;
            margin: 0 auto;
            padding: 15px;
            background: white;
            border-radius: 10px;
        }

        /* Colors */
        :root {
            --primary: #2ecc71;
            --primary-dark: #27ae60;
            --secondary: #3498db;
            --accent: #ff9f43;
            --danger: #e74c3c;
            --warning: #f39c12;
            --dark: #2c3e50;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .company-info h2 {
            margin: 0;
            font-size: 16px;
        }

        .company-details {
            font-size: 8px;
            opacity: 0.9;
            margin-top: 5px;
        }

        .invoice-info h1 {
            margin: 0 0 5px 0;
            font-size: 18px;
            font-weight: 700;
        }

        .invoice-details {
            font-size: 9px;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 15px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            margin-top: 2px;
        }

        .status-completed { background: var(--primary); color: white; }
        .status-processing { background: var(--secondary); color: white; }
        .status-shipped { background: var(--accent); color: white; }
        .status-pending { background: var(--warning); color: white; }
        .status-cancelled { background: var(--danger); color: white; }

        /* ADDRESS CARDS */
        .address-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        .address-card {
            width: 48%;
            background: #fff;
            border-radius: 6px;
            padding: 10px;
            border-left: 4px solid var(--primary);
            font-size: 8px;
        }

        .address-card.billing { border-left-color: var(--secondary); }

        .address-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        /* PRODUCT TABLE */
        .table-container {
            overflow-x: auto;
            margin-bottom: 15px;
        }

        .product-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
        }

        .product-table th, .product-table td {
            padding: 6px 4px;
            border: 1px solid #dee2e6;
        }

        .product-table th {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            font-weight: 600;
        }

        .product-table td {
            vertical-align: middle;
        }

        .product-row {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .product-img-small {
            width: 35px;
            height: 35px;
            border-radius: 4px;
            object-fit: cover;
        }

        .product-name-small { font-size: 8px; font-weight: bold; }
        .product-options-small { font-size: 7px; color: #6c757d; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* TOTALS */
        .totals-section {
            padding: 10px;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            font-size: 9px;
        }

        .total-row { display: flex; justify-content: space-between; padding: 4px 0; }
        .total-final { background: var(--primary); color: white; padding: 6px 10px; border-radius: 4px; font-weight: bold; }

        /* FOOTER */
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 15px;
            color: #6c757d;
        }

        /* PRINT */
        @media print {
            body { font-size: 9px; }
            .container { box-shadow: none; padding: 5px; }
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
<div class="container">

    <!-- HEADER -->
    <div class="header">
        <div class="company-info">
            <h2><i class="fas fa-leaf"></i> {{ config('app.name') }}</h2>
            <div class="company-details">
                @if($order->shippingAddress)
                    <div>{{ $order->shippingAddress->address_line1 }}</div>
                    <div>{{ $order->shippingAddress->city }}, {{ $order->shippingAddress->state }} {{ $order->shippingAddress->postal_code }}</div>
                    <div>{{ $order->shippingAddress->phone }}</div>
                @endif
            </div>
        </div>

        <div class="invoice-info">
            <h1>INVOICE</h1>
            <div class="invoice-details">
                <div><strong>#:</strong> {{ $order->order_number }}</div>
                <div><strong>Date:</strong> {{ $order->created_at->format('F j, Y') }}</div>
                <div><strong>Status:</strong>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ADDRESSES -->
    <div class="address-section">
        <div class="address-card">
            <div class="address-title">From:</div>
            <div>{{ $order->shippingAddress->address_line1 ?? '123 Organic St' }}</div>
            <div>{{ $order->shippingAddress->city ?? 'Freshville' }}, {{ $order->shippingAddress->state ?? 'CA' }}</div>
            <div>{{ config('mail.from.address', 'contact@fruitspage.com') }}</div>
        </div>

        <div class="address-card billing">
            <div class="address-title">Bill To:</div>
            @if($order->billingAddress)
                <div>{{ $order->billingAddress->full_name }}</div>
                <div>{{ $order->billingAddress->address_line1 }}</div>
                <div>{{ $order->billingAddress->city }}, {{ $order->billingAddress->state }}</div>
            @else
                <div>No billing address provided</div>
            @endif
        </div>
    </div>

    <!-- PRODUCT TABLE -->
    <div class="table-container">
        <table class="product-table">
            <thead>
            <tr>
                <th class="text-center" style="width:5%;">#</th>
                <th style="width:50%;">Item</th>
                <th style="width:15%;">Price</th>
                <th class="text-center" style="width:10%;">Qty</th>
                <th class="text-right" style="width:20%;">Total</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <div class="product-row">
                            @php
                                $imagePath = $item->product && $item->product->image 
                                    ? (str_starts_with($item->product->image, 'http') 
                                        ? $item->product->image 
                                        : (str_starts_with($item->product->image, 'products/') 
                                            ? asset('storage/' . $item->product->image)
                                            : asset('storage/products/' . $item->product->image)))
                                    : asset('images/default-product.png');
                            @endphp
                            <img class="product-img-small"
                                 src="{{ $imagePath }}"
                                 alt="{{ $item->product->name ?? 'Product' }}"
                                 onerror="this.onerror=null; this.src='{{ asset('images/default-product.png') }}';">
                            <div>
                                <div class="product-name-small">{{ $item->product->name ?? 'Product '.$item->product_id }}</div>
                                @if($item->options)
                                    <div class="product-options-small">
                                        @foreach($item->options as $key => $value)
                                            {{ ucfirst($key) }}: {{ $value }}@if(!$loop->last), @endif
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>${{ number_format($item->price, 2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <!-- TOTALS -->
    <div class="totals-section">
        <div class="total-row">
            <span>Subtotal</span>
            <span>${{ number_format($order->subtotal, 2) }}</span>
        </div>
        @if($order->discount > 0)
            <div class="total-row">Discount: -${{ number_format($order->discount, 2) }}</div>
        @endif
        <div class="total-row">Shipping: ${{ number_format($order->shipping_cost, 2) }}</div>
        <div class="total-row">Tax: ${{ number_format($order->tax, 2) }}</div>
        <div class="total-row total-final">
            <span>TOTAL</span>
            <span>${{ number_format($order->total, 2) }}</span>
        </div>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        Thank you for your purchase! • {{ config('mail.from.address', 'contact@fruitspage.com') }}
    </div>
</div>
</body>
</html>
