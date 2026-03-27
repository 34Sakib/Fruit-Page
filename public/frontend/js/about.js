
document.addEventListener('DOMContentLoaded', function () {
    // Animate numbers counting up
    function animateCounter() {
        const counters = document.querySelectorAll('.stat-number');
        if (!counters.length) return;
        
        counters.forEach(counter => {
            const target = parseInt(counter.getAttribute('data-count') || '0');
            if (isNaN(target)) return;
            
            const increment = target / 100;
            let current = 0;

            const updateCounter = () => {
                if (current < target) {
                    current += increment;
                    counter.textContent = Math.ceil(current).toLocaleString() +
                        (counter.textContent && counter.textContent.includes('+') ? '+' : '');
                    setTimeout(updateCounter, 20);
                } else {
                    counter.textContent = target.toLocaleString() +
                        (counter.textContent && counter.textContent.includes('+') ? '+' : '');
                }
            };

            updateCounter();
        });
    }

    // Scroll animation for elements
    function animateOnScroll() {
        const elements = document.querySelectorAll('.animate-on-scroll');
        if (!elements.length) return;

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');

                    // Animate counters when stats section is visible
                    if (entry.target.classList.contains('stat-card')) {
                        setTimeout(animateCounter, 300);
                    }
                }
            });
        }, {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Team card hover effect
    const teamCards = document.querySelectorAll('.team-card');
    if (teamCards.length) {
        teamCards.forEach(card => {
            card.addEventListener('mouseenter', function () {
                this.style.zIndex = '10';
            });

            card.addEventListener('mouseleave', function () {
                this.style.zIndex = '1';
            });
        });
    }

    // Initialize animations
    animateOnScroll();

    // Animate floating elements
    const floatingElements = document.querySelectorAll('.floating-element');
    if (floatingElements.length) {
        floatingElements.forEach((el, index) => {
            el.style.animationDelay = `${index * 5}s`;
        });
    }

    // Add click animation to CTA button
    const ctaBtn = document.querySelector('.cta-btn');
    if (ctaBtn) {
        ctaBtn.addEventListener('click', function (e) {
            e.preventDefault();

            // Add click animation
            this.style.transform = 'scale(0.95)';
            setTimeout(() => {
                this.style.transform = '';
            }, 200);

            // Navigate to the shop URL
            const url = this.getAttribute('href');
            if (url && url !== '#') {
                window.location.href = url;
            }
        });
    }

    // Add scroll to top functionality
    const logo = document.querySelector('.footer-logo');
    if (logo) {
        logo.addEventListener('click', function (e) {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
});
