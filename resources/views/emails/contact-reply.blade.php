<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Response to Your Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: #28a745;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 5px 5px;
        }
        .original-message {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .reply {
            background: #d4edda;
            padding: 15px;
            border-left: 4px solid #28a745;
            white-space: pre-wrap;
            border-radius: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 12px;
        }
        .btn {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍎 Thank You for Contacting FruitMart!</h1>
        <p>We've received your message and here's our response</p>
    </div>

    <div class="content">
        <p>Dear {{ $contact->name }},</p>
        
        <p>Thank you for reaching out to FruitMart. We've received your message regarding "<strong>{{ $contact->subject }}</strong>" and our team has reviewed your inquiry.</p>

        <h3>Your Original Message:</h3>
        <div class="original-message">
            {{ $contact->message }}
        </div>

        <h3>Our Response:</h3>
        <div class="reply">
            {{ $contact->admin_reply }}
        </div>

        <p>If you have any further questions or need additional assistance, please don't hesitate to contact us again.</p>

        <div style="text-align: center;">
            <a href="{{ url('/contact') }}" class="btn">Visit Our Contact Page</a>
        </div>

        <p>Best regards,<br>
        The FruitMart Team<br>
        🍎 Fresh from Farm to Your Table</p>
    </div>

    <div class="footer">
        <p>This email was sent in response to your contact form submission on {{ $contact->created_at->format('M d, Y') }}.</p>
        <p>&copy; {{ date('Y') }} FruitMart. All rights reserved.</p>
        <p>
            <a href="{{ url('/contact') }}">Contact Us</a> | 
            <a href="{{ url('/') }}">Visit Website</a>
        </p>
    </div>
</body>
</html>
