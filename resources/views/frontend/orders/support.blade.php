@extends('frontend.layouts.master')

@section('title', 'Contact Support - ' . config('app.name'))

@section('content')

@push('styles')
<style>
    .support-card {
        border: none;
        border-radius: 1rem;
        box-shadow: 0 0.5rem 2rem 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
    }

    .support-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem 0 rgba(0, 0, 0, 0.15);
    }

    .support-icon {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 2rem;
        margin: 0 auto 1.5rem;
        transition: all 0.3s ease;
    }

    .contact-method {
        transition: all 0.3s ease;
        border: 2px solid transparent;
        border-radius: 1rem;
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        position: relative;
        overflow: hidden;
    }

    .contact-method::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #ff6b6b, #ffa726, #66bb6a, #42a5f5, #ab47bc);
    }

    .contact-method:hover {
        transform: translateY(-5px);
        border-color: #42a5f5;
        box-shadow: 0 0.5rem 1.5rem rgba(66, 165, 245, 0.2);
    }

    .contact-method:hover .support-icon {
        transform: scale(1.1);
    }

    .form-control:focus {
        border-color: #42a5f5;
        box-shadow: 0 0 0 0.25rem rgba(66, 165, 245, 0.25);
    }

    .card-header {
        background: linear-gradient(135deg, #2ecc71 0%, #20c997 100%) !important;
        color: white !important;
        border-radius: 1rem 1rem 0 0 !important;
    }

    .card-header.bg-success {
        background: #2ecc71 !important;
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 0.75rem;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(102, 126, 234, 0.3);
    }

    .btn-outline-primary {
        border-color: #667eea;
        color: #667eea;
        border-radius: 0.75rem;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        transform: translateY(-2px);
    }

    .btn-outline-success {
        border-color: #66bb6a;
        color: #66bb6a;
        border-radius: 0.75rem;
    }

    .btn-outline-success:hover {
        background: linear-gradient(135deg, #66bb6a 0%, #43a047 100%);
        border-color: #66bb6a;
        transform: translateY(-2px);
    }

    .btn-outline-info {
        border-color: #42a5f5;
        color: #42a5f5;
        border-radius: 0.75rem;
    }

    .btn-outline-info:hover {
        background: linear-gradient(135deg, #42a5f5 0%, #1976d2 100%);
        border-color: #42a5f5;
        transform: translateY(-2px);
    }

    .btn-outline-secondary {
        border-radius: 0.75rem;
    }

    .accordion-button {
        background: linear-gradient(135deg, #f8f9ff 0%, #e3f2fd 100%);
        border: 1px solid #e3f2fd;
        border-radius: 0.75rem !important;
        margin-bottom: 0.5rem;
        font-weight: 600;
        color: #2c3e50;
        transition: all 0.3s ease;
    }

    .accordion-button:not(.collapsed) {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        box-shadow: 0 0.25rem 0.75rem rgba(102, 126, 234, 0.3);
    }

    .accordion-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }

    .accordion-body {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%);
        border-radius: 0 0 0.75rem 0.75rem;
        border: 1px solid #e3f2fd;
        border-top: none;
    }

    .form-check-input:checked {
        background-color: #667eea;
        border-color: #667eea;
    }

    .form-check-input:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
    }

    .bg-soft-primary {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%) !important;
        color: #667eea;
    }

    .bg-soft-success {
        background: linear-gradient(135deg, rgba(102, 187, 106, 0.1) 0%, rgba(67, 160, 71, 0.1) 100%) !important;
        color: #66bb6a;
    }

    .bg-soft-info {
        background: linear-gradient(135deg, rgba(66, 165, 245, 0.1) 0%, rgba(25, 118, 210, 0.1) 100%) !important;
        color: #42a5f5;
    }

    .text-primary {
        color: #667eea !important;
    }

    .text-success {
        color: #66bb6a !important;
    }

    .text-info {
        color: #42a5f5 !important;
    }

    .bg-light {
        background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%) !important;
    }

    .shadow-sm {
        box-shadow: 0 0.25rem 1rem rgba(0, 0, 0, 0.1) !important;
    }

    /* Gradient text effect */
    .gradient-text {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 50%, #ff6b6b 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    /* Floating animation */
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .floating {
        animation: float 3s ease-in-out infinite;
    }
</style>
@endpush

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header Card --}}
            <div class="card support-card mb-5 floating">
                <div class="card-header bg-success py-4">
                    <div class="d-flex align-items-center">
                        <a href="{{ route('profile.show') }}" class="btn btn-sm btn-outline-light me-3">
                            <i class="fas fa-arrow-left me-1"></i> Back to Profile
                        </a>
                        <h4 class="mb-0 text-white"><i class="fas fa-headset me-2"></i>Contact Support</h4>
                    </div>
                </div>

                <div class="card-body p-4">
                    {{-- Contact Methods --}}
                    <div class="row mb-5">
                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="contact-method text-center p-4 rounded-3 h-100">
                                <div class="support-icon bg-soft-primary">
                                    <i class="fas fa-phone-alt floating"></i>
                                </div>
                                <h5 class="mb-3 text-dark">Call Us</h5>
                                <p class="mb-2 text-muted">Speak directly with our support team</p>
                                <a href="tel:+1234567890" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-phone-alt me-1"></i> 01641655173
                                </a>
                                <p class="small text-muted mt-2 mb-0">Mon-Fri, 9am-6pm EST</p>
                            </div>
                        </div>

                        <div class="col-md-4 mb-4 mb-md-0">
                            <div class="contact-method text-center p-4 rounded-3 h-100">
                                <div class="support-icon bg-soft-success">
                                    <i class="fas fa-envelope floating"></i>
                                </div>
                                <h5 class="mb-3 text-dark">Email Us</h5>
                                <p class="mb-2 text-muted">We'll respond within 24 hours</p>
                                <a href="mailto:support@fruitmart.com" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-envelope me-1"></i> support@fruitmart.com
                                </a>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="contact-method text-center p-4 rounded-3 h-100">
                                <div class="support-icon bg-soft-info">
                                    <i class="fas fa-comment-dots floating"></i>
                                </div>
                                <h5 class="mb-3 text-dark">Live Chat</h5>
                                <p class="mb-2 text-muted">Chat with our support team</p>
                                <button class="btn btn-outline-info btn-sm" id="startChat">
                                    <i class="fas fa-comment-dots me-1"></i> Start Chat
                                </button>
                                <p class="small text-muted mt-2 mb-0">Available 24/7</p>
                            </div>
                        </div>
                    </div>

                    {{-- Message Form --}}
                    <div class="card border-0 shadow-sm support-card">
                        <div class="card-header bg-light py-3">
                            <h5 class="mb-0 gradient-text"><i class="fas fa-paper-plane me-2"></i>Send us a Message</h5>
                        </div>

                        <div class="card-body">
                            <form id="supportForm" action="#" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Your Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" required>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" required>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Subject <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="subject" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Order Number (Optional)</label>
                                    <input type="text" class="form-control" name="order_number">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Your Message <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="message" rows="5" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="priority" name="priority">
                                        <label class="form-check-label" for="priority">
                                            <i class="fas fa-bolt text-warning me-1"></i> Mark as Urgent (24-hour response guaranteed)
                                        </label>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button type="reset" class="btn btn-outline-secondary me-md-2">
                                        <i class="fas fa-redo me-1"></i> Reset
                                    </button>
                                    <button type="submit" class="btn btn-primary">
                                        <span class="spinner-border spinner-border-sm d-none me-2"></span> 
                                        <i class="fas fa-paper-plane me-1"></i> Send Message
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

            {{-- FAQ Section --}}
            <div class="card support-card">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-white"><i class="fas fa-question-circle me-2"></i>Frequently Asked Questions</h5>
                </div>

                <div class="card-body">
                    <div class="accordion" id="faqAccordion">

                        {{-- FAQ #1 --}}
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                    <i class="fas fa-truck text-primary me-2"></i> How can I track my order?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Track your order from the "My Orders" section in your account.
                                </div>
                            </div>
                        </div>

                        {{-- FAQ #2 --}}
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                    <i class="fas fa-undo text-success me-2"></i> What is your return policy?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We accept returns within 30 days (except perishables).
                                </div>
                            </div>
                        </div>

                        {{-- FAQ #3 --}}
                        <div class="accordion-item border-0 mb-2">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                    <i class="fas fa-times-circle text-danger me-2"></i> How do I change or cancel my order?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    You can cancel within 1 hour by contacting support.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const supportForm = document.getElementById('supportForm');

        if (supportForm) {
            supportForm.addEventListener('submit', async function (e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const spinner = submitBtn.querySelector('.spinner-border');

                try {
                    submitBtn.disabled = true;
                    spinner.classList.remove('d-none');

                    // Simulate request delay (replace with actual POST request)
                    await new Promise(res => setTimeout(res, 1500));

                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent!',
                        text: 'Thank you for contacting us! We will get back to you soon.',
                        confirmButtonColor: '#667eea',
                        background: 'linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%)',
                        color: '#2c3e50'
                    });

                    this.reset();

                } catch (error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Something went wrong. Please try again.',
                        confirmButtonColor: '#667eea',
                        background: 'linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%)',
                        color: '#2c3e50'
                    });

                } finally {
                    submitBtn.disabled = false;
                    spinner.classList.add('d-none');
                }

            });
        }

        // Live chat button animation
        const startChatBtn = document.getElementById('startChat');
        if (startChatBtn) {
            startChatBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Live Chat',
                    html: 'Our live chat feature is coming soon!<br>In the meantime, please use email or phone support.',
                    icon: 'info',
                    confirmButtonColor: '#42a5f5',
                    background: 'linear-gradient(135deg, #ffffff 0%, #f8f9ff 100%)',
                    color: '#2c3e50'
                });
            });
        }

    });
</script>
@endpush

@endsection