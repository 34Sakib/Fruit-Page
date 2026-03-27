
document.addEventListener('DOMContentLoaded', function () {
    // Real-time form validation
    const formInputs = document.querySelectorAll('.form-control, .form-select');
    const submitBtn = document.querySelector('.btn-submit');
    
    // Add input event listeners for real-time validation
    formInputs.forEach(input => {
        input.addEventListener('input', function() {
            validateField(this);
            checkFormValidity();
        });
        
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
    
    // Field validation function
    function validateField(field) {
        const fieldName = field.name;
        const fieldValue = field.value.trim();
        const formGroup = field.closest('.form-group');
        
        // Remove existing validation classes
        field.classList.remove('is-valid', 'is-invalid');
        removeValidationFeedback(formGroup);
        
        let isValid = true;
        let errorMessage = '';
        
        // Required field validation
        if (field.hasAttribute('required') && !fieldValue) {
            isValid = false;
            errorMessage = `${getFieldLabel(fieldName)} is required`;
        }
        // Email validation
        else if (fieldName === 'email' && fieldValue) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(fieldValue)) {
                isValid = false;
                errorMessage = 'Please enter a valid email address';
            }
        }
        // Phone validation (optional)
        else if (fieldName === 'phone' && fieldValue) {
            const phoneRegex = /^[+]?[\d\s\-\(\)]+$/;
            if (!phoneRegex.test(fieldValue)) {
                isValid = false;
                errorMessage = 'Please enter a valid phone number';
            }
        }
        // Name validation
        else if (fieldName === 'name' && fieldValue) {
            if (fieldValue.length < 2) {
                isValid = false;
                errorMessage = 'Name must be at least 2 characters long';
            }
        }
        // Message validation
        else if (fieldName === 'message' && fieldValue) {
            if (fieldValue.length < 10) {
                isValid = false;
                errorMessage = 'Message must be at least 10 characters long';
            }
        }
        
        // Apply validation styling
        if (fieldValue) {
            if (isValid) {
                field.classList.add('is-valid');
                addValidationFeedback(formGroup, '✓ Looks good!', 'success');
            } else {
                field.classList.add('is-invalid');
                addValidationFeedback(formGroup, errorMessage, 'error');
            }
        }
        
        return isValid;
    }
    
    // Get field label for error messages
    function getFieldLabel(fieldName) {
        const labels = {
            'name': 'Full Name',
            'email': 'Email Address',
            'phone': 'Phone Number',
            'subject': 'Subject',
            'message': 'Message'
        };
        return labels[fieldName] || fieldName.charAt(0).toUpperCase() + fieldName.slice(1);
    }
    
    // Add validation feedback
    function addValidationFeedback(formGroup, message, type) {
        removeValidationFeedback(formGroup);
        
        const feedback = document.createElement('div');
        feedback.className = `field-feedback field-feedback-${type}`;
        feedback.textContent = message;
        
        formGroup.appendChild(feedback);
        
        // Animate feedback
        setTimeout(() => {
            feedback.style.opacity = '1';
            feedback.style.transform = 'translateY(0)';
        }, 10);
    }
    
    // Remove validation feedback
    function removeValidationFeedback(formGroup) {
        const existingFeedback = formGroup.querySelector('.field-feedback');
        if (existingFeedback) {
            existingFeedback.remove();
        }
    }
    
    // Check overall form validity
    function checkFormValidity() {
        const requiredFields = document.querySelectorAll('[required]');
        let allValid = true;
        
        requiredFields.forEach(field => {
            if (!field.value.trim() || field.classList.contains('is-invalid')) {
                allValid = false;
            }
        });
        
        // Update submit button state
        if (submitBtn) {
            if (allValid) {
                submitBtn.disabled = false;
                submitBtn.style.opacity = '1';
                submitBtn.style.cursor = 'pointer';
            } else {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'not-allowed';
            }
        }
        
        return allValid;
    }
    // Enhanced FAQ Accordion
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
        question.addEventListener('click', function () {
            const faqItem = this.closest('.faq-item');
            const answer = faqItem.querySelector('.faq-answer');
            const icon = this.querySelector('i');
            const allFaqItems = document.querySelectorAll('.faq-item');
            const allAnswers = document.querySelectorAll('.faq-answer');
            const allIcons = document.querySelectorAll('.faq-question i');

            // Close all other FAQ items
            allFaqItems.forEach(item => {
                if (item !== faqItem && item.classList.contains('active')) {
                    item.classList.remove('active');
                    const itemAnswer = item.querySelector('.faq-answer');
                    const itemIcon = item.querySelector('.faq-question i');
                    itemAnswer.classList.remove('show');
                    itemIcon.classList.remove('fa-minus');
                    itemIcon.classList.add('fa-plus');
                }
            });

            // Toggle current FAQ item
            faqItem.classList.toggle('active');
            
            if (answer.classList.contains('show')) {
                answer.classList.remove('show');
                icon.classList.remove('fa-minus');
                icon.classList.add('fa-plus');
            } else {
                answer.classList.add('show');
                icon.classList.remove('fa-plus');
                icon.classList.add('fa-minus');
            }
        });
    });

    // Enhanced Contact Form Submission
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function (e) {
            // Validate all fields before submission
            let formIsValid = true;
            formInputs.forEach(input => {
                if (!validateField(input)) {
                    formIsValid = false;
                }
            });
            
            if (!formIsValid) {
                e.preventDefault();
                showNotification('Please correct the errors before submitting', 'error');
                return;
            }
            
            // Add loading state to button
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
                submitBtn.disabled = true;
            }
            
            // Form will submit normally to the server
            console.log('Form validated and submitting to server');
        });
    }

    // Show notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
                <span>${message}</span>
            </div>
            <button class="notification-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;
        
        document.body.appendChild(notification);
        
        // Animate in
        setTimeout(() => {
            notification.classList.add('show');
        }, 10);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.remove('show');
                setTimeout(() => notification.remove(), 300);
            }
        }, 5000);
    }
    
    // Initialize form validity on load
    checkFormValidity();
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function (entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Animate all elements with animation classes
    const animatedElements = document.querySelectorAll('.animate-fade-in');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(el);
    });

    // Smooth scroll for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            const targetId = this.getAttribute('href');
            if (targetId === '#') return;

            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                window.scrollTo({
                    top: targetElement.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Add hover animation to contact cards
    const contactCards = document.querySelectorAll('.contact-card');
    contactCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function () {
            this.style.zIndex = '1';
        });
    });
});
