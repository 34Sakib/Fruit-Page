document.addEventListener('DOMContentLoaded', function() {
    // Enhanced form interactions
    const form = document.getElementById('specialOrderForm');
    const locationSelect = document.getElementById('location');
    const deliveryInfo = document.querySelector('.charge-details');
    const categorySelect = document.getElementById('category_id');
    const productSelect = document.getElementById('product_id');
    const submitBtn = document.querySelector('.btn-submit');
    
    // Animate elements on page load
    animateOnLoad();
    
    // Enhanced delivery charge display with animation
    if (locationSelect && deliveryInfo) {
        locationSelect.addEventListener('change', function() {
            const isInsideDhaka = this.value === '1';
            const charge = isInsideDhaka ? '50' : '120';
            const location = isInsideDhaka ? 'Inside Dhaka' : 'Outside Dhaka';
            
            // Add animation class
            deliveryInfo.style.opacity = '0';
            deliveryInfo.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                deliveryInfo.innerHTML = `
                    <div class="charge-item">
                        <span class="location">${location}</span>
                        <span class="price">৳${charge}</span>
                    </div>
                    <div class="charge-item">
                        <span class="location">${isInsideDhaka ? 'Outside Dhaka' : 'Inside Dhaka'}</span>
                        <span class="price">৳${isInsideDhaka ? '120' : '50'}</span>
                    </div>
                `;
                deliveryInfo.style.opacity = '1';
                deliveryInfo.style.transform = 'translateY(0)';
            }, 200);
        });
    }
    
    // Enhanced product loading with better UX
    if (categorySelect && productSelect) {
        categorySelect.addEventListener('change', function() {
            const categoryId = this.value;
            productSelect.innerHTML = '<option value="">Select Product (if available)</option>';
            
            if (categoryId) {
                // Show loading state
                productSelect.disabled = true;
                productSelect.innerHTML += '<option value="" disabled>Loading products...</option>';
                
                // Fetch products with better error handling
                fetch(`/special-order/products/${categoryId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(products => {
                        productSelect.innerHTML = '<option value="">Select Product (if available)</option>';
                        
                        if (Array.isArray(products) && products.length > 0) {
                            products.forEach(product => {
                                productSelect.innerHTML += `<option value="${product.id}">${product.name}</option>`;
                            });
                        } else {
                            productSelect.innerHTML += '<option value="" disabled>No products found in this category</option>';
                        }
                        productSelect.disabled = false;
                    })
                    .catch(error => {
                        console.log('Using mock data due to:', error.message);
                        // Enhanced mock data
                        const mockProducts = {
                            1: [
                                {id: 1, name: 'Organic Strawberries'},
                                {id: 2, name: 'Fresh Blueberries'},
                                {id: 3, name: 'Fresh Avocados'},
                                {id: 4, name: 'Raspberries'},
                                {id: 5, name: 'Blackberries'}
                            ],
                            2: [
                                {id: 6, name: 'Organic Spinach'},
                                {id: 7, name: 'Fresh Tomatoes'},
                                {id: 8, name: 'Organic Carrots'},
                                {id: 9, name: 'Bell Peppers'},
                                {id: 10, name: 'Cucumbers'}
                            ],
                            3: [
                                {id: 11, name: 'Organic Honey'},
                                {id: 12, name: 'Organic Quinoa'},
                                {id: 13, name: 'Almond Butter'},
                                {id: 14, name: 'Coconut Oil'}
                            ]
                        };
                        
                        productSelect.innerHTML = '<option value="">Select Product (if available)</option>';
                        
                        if (mockProducts[categoryId]) {
                            mockProducts[categoryId].forEach(product => {
                                productSelect.innerHTML += `<option value="${product.id}">${product.name}</option>`;
                            });
                        } else {
                            productSelect.innerHTML += '<option value="" disabled>No products available</option>';
                        }
                        productSelect.disabled = false;
                    });
            } else {
                productSelect.disabled = false;
            }
        });
    }
    
    // Enhanced input interactions with visual feedback
    const inputs = form.querySelectorAll('input, select, textarea');
    inputs.forEach(input => {
        // Clear errors on input
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
            const errorEl = this.parentElement.querySelector('.error-message');
            if (errorEl) {
                errorEl.textContent = '';
            }
            
            // Add visual feedback for valid inputs
            if (this.value.trim() && this.hasAttribute('required')) {
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
        
        // Add focus effects
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Enhanced form validation with better UX
    form.addEventListener('submit', function(e) {
        let isValid = true;
        let firstErrorField = null;
        
        // Show loading state on submit button
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Processing...</span>';
        }
        
        // Clear previous errors with animation
        document.querySelectorAll('.error-message').forEach(el => {
            el.style.opacity = '0';
            setTimeout(() => {
                el.textContent = '';
                el.style.opacity = '1';
            }, 200);
        });
        document.querySelectorAll('.is-invalid').forEach(el => {
            el.classList.remove('is-invalid');
        });
        
        // Enhanced validation with better feedback
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim() || (field.type === 'number' && parseFloat(field.value) <= 0)) {
                isValid = false;
                const errorEl = field.parentElement.querySelector('.error-message');
                if (errorEl) {
                    let errorMessage = 'This field is required';
                    if (field.id === 'quantity') {
                        errorMessage = 'Please enter a valid quantity greater than 0';
                    } else if (field.type === 'email') {
                        errorMessage = 'Please enter a valid email address';
                    }
                    
                    setTimeout(() => {
                        errorEl.textContent = errorMessage;
                        errorEl.style.color = 'var(--secondary)';
                    }, 300);
                    
                    field.classList.add('is-invalid');
                    
                    if (!firstErrorField) {
                        firstErrorField = field;
                    }
                }
            } else {
                field.classList.remove('is-invalid');
                field.classList.add('is-valid');
            }
        });
        
        // Enhanced email validation
        const emailField = document.getElementById('email');
        if (emailField && emailField.value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailField.value)) {
                isValid = false;
                const errorEl = emailField.parentElement.querySelector('.error-message');
                if (errorEl) {
                    setTimeout(() => {
                        errorEl.textContent = 'Please enter a valid email address';
                        errorEl.style.color = 'var(--secondary)';
                    }, 300);
                    emailField.classList.add('is-invalid');
                    
                    if (!firstErrorField) {
                        firstErrorField = emailField;
                    }
                }
            }
        }
        
        // Enhanced product validation
        const productId = document.getElementById('product_id').value;
        const productName = document.getElementById('product_name').value.trim();
        
        if (!productId && !productName) {
            isValid = false;
            const productErrorEl = document.getElementById('product_name').parentElement.querySelector('.error-message');
            if (productErrorEl) {
                setTimeout(() => {
                    productErrorEl.textContent = 'Please select a product or enter a custom product name';
                    productErrorEl.style.color = 'var(--secondary)';
                }, 300);
                document.getElementById('product_name').classList.add('is-invalid');
                
                if (!firstErrorField) {
                    firstErrorField = document.getElementById('product_name');
                }
            }
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Reset submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> <span>Submit Special Order</span>';
            }
            
            // Enhanced error scrolling
            if (firstErrorField) {
                setTimeout(() => {
                    firstErrorField.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'center',
                        inline: 'nearest'
                    });
                    firstErrorField.focus();
                    
                    // Add pulse animation to error field
                    firstErrorField.style.animation = 'pulse 0.5s ease-in-out 2';
                    setTimeout(() => {
                        firstErrorField.style.animation = '';
                    }, 1000);
                }, 500);
            }
        }
    });
    
    // Add pulse animation
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        
        .form-control.is-valid {
            border-color: var(--primary);
            background-color: rgba(46, 204, 113, 0.05);
        }
        
        .focused {
            transform: translateY(-2px);
        }
        
        .charge-details {
            transition: all 0.3s ease;
        }
    `;
    document.head.appendChild(style);
});

// Animate elements on page load
function animateOnLoad() {
    const elements = document.querySelectorAll('.form-section, .tracking-info, .success-notification');
    elements.forEach((el, index) => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'all 0.6s ease';
        
        setTimeout(() => {
            el.style.opacity = '1';
            el.style.transform = 'translateY(0)';
        }, index * 200);
    });
}
