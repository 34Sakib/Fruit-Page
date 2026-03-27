<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Form Submission</title>
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
        .field {
            margin-bottom: 15px;
        }
        .field strong {
            display: block;
            margin-bottom: 5px;
            color: #495057;
        }
        .message {
            background: white;
            padding: 15px;
            border-left: 4px solid #28a745;
            white-space: pre-wrap;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍎 New Contact Form Submission</h1>
        <p>FruitMart - Contact Us</p>
    </div>

    <div class="content">
        <h2>Contact Details</h2>
        
        <div class="field">
            <strong>Name:</strong>
            {{ $contact->name }}
        </div>

        <div class="field">
            <strong>Email:</strong>
            <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
        </div>

        @if($contact->phone)
        <div class="field">
            <strong>Phone:</strong>
            {{ $contact->phone }}
        </div>
        @endif

        <div class="field">
            <strong>Subject:</strong>
            {{ $contact->subject }}
        </div>

        <div class="field">
            <strong>Status:</strong>
            <span style="background: #ffc107; color: #212529; padding: 2px 8px; border-radius: 3px; font-size: 12px;">
                {{ ucfirst($contact->status) }}
            </span>
        </div>

        <div class="field">
            <strong>Received:</strong>
            {{ $contact->created_at->format('M d, Y h:i A') }}
        </div>

        <h3>Message</h3>
        <div class="message">
            {{ $contact->message }}
        </div>

        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ route('admin.contacts.show', $contact) }}" style="background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">
                View in Admin Panel
            </a>
        </div>
    </div>

    <div class="footer">
        <p>This email was sent automatically from the FruitMart contact form.</p>
        <p>&copy; {{ date('Y') }} FruitMart. All rights reserved.</p>
    </div>
</body>
</html>
