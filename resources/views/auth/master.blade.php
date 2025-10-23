<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Fruitsmart')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('frontend/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('frontend/css/auth.css') }}" rel="stylesheet">
    <style>
        .auth-page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .auth-main {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 40px 0;
            background-color: #f8f9fa;
            background-image: linear-gradient(rgba(255,255,255,0.9), rgba(255,255,255,0.9)), 
                            url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="%232ecc71" opacity="0.1"/></svg>');
            background-size: 200px;
        }
        
        .auth-container {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
        }
        
        .auth-left {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .auth-right {
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .brand-logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 30px;
            color: #2ecc71;
        }
        
        .brand-logo i {
            margin-right: 10px;
        }
        
        .auth-title {
            font-weight: 700;
            font-size: 32px;
            margin-bottom: 10px;
            color: #2c3e50;
        }
        
        .auth-subtitle {
            color: #6c757d;
            margin-bottom: 30px;
        }
        
        .form-control {
            padding: 12px 15px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #2ecc71;
            box-shadow: 0 0 0 0.2rem rgba(46, 204, 113, 0.25);
        }
        
        .input-group-text {
            background-color: white;
            border: 1px solid #e0e0e0;
            border-right: none;
            border-radius: 8px 0 0 8px;
        }
        
        .input-group .form-control {
            border-left: none;
            border-radius: 0 8px 8px 0;
        }
        
        .btn-auth {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
            transition: background-color 0.3s;
        }
        
        .btn-auth:hover {
            background-color: #27ae60;
            color: white;
        }
        
        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
        }
        
        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        
        .divider-text {
            padding: 0 15px;
            color: #6c757d;
            font-size: 14px;
        }
        
        .social-auth {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .btn-social {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e0e0e0;
            background-color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s;
        }
        
        .btn-social:hover {
            background-color: #f8f9fa;
        }
        
        .auth-links {
            text-align: center;
            margin-top: 20px;
        }
        
        .auth-links a {
            color: #2ecc71;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .auth-links a:hover {
            color: #27ae60;
            text-decoration: underline;
        }
        
        .feature-list {
            list-style-type: none;
            padding: 0;
            margin-top: 30px;
        }
        
        .feature-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        
        .feature-list i {
            background-color: rgba(255,255,255,0.2);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }
        
        .fruit-decoration {
            text-align: center;
            margin-top: 30px;
        }
        
        .fruit-icon {
            display: inline-block;
            margin: 0 10px;
            font-size: 24px;
            animation: float 3s ease-in-out infinite;
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .terms-check {
            margin: 15px 0;
        }
        
        .terms-check a {
            color: #2ecc71;
        }
        
        .password-strength {
            height: 5px;
            border-radius: 5px;
            margin-top: -15px;
            margin-bottom: 15px;
            background-color: #e0e0e0;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0%;
            transition: width 0.3s, background-color 0.3s;
        }
        
        .password-requirements {
            font-size: 12px;
            color: #6c757d;
            margin-top: -10px;
            margin-bottom: 15px;
        }
        
        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 5px;
        }
        
        .requirement i {
            margin-right: 5px;
            font-size: 10px;
        }
        
        .requirement.met {
            color: #2ecc71;
        }
        
        .requirement.met i {
            color: #2ecc71;
        }
        
        @media (max-width: 768px) {
            .auth-container {
                max-width: 90%;
            }
            
            .auth-left, .auth-right {
                padding: 30px 20px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    @include('frontend.body.header')
    <main class="auth-main">
        @yield('content')
    </main>
    @include('frontend.body.footer')    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle password visibility
            const togglePasswordButtons = document.querySelectorAll('.toggle-password');
            togglePasswordButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.previousElementSibling;
                    const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                    input.setAttribute('type', type);
                    const icon = this.querySelector('i');
                    if (icon) {
                        icon.classList.toggle('fa-eye');
                        icon.classList.toggle('fa-eye-slash');
                    }
                });
            });
            
            // Floating animation for fruit icons
            const fruitIcons = document.querySelectorAll('.fruit-icon');
            fruitIcons.forEach((icon, index) => {
                icon.style.animation = `float 3s ease-in-out ${index * 0.5}s infinite`;
            });
        });
    </script>
    @stack('scripts')
</body>
</html>