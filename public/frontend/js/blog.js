
document.addEventListener('DOMContentLoaded', function () {
    // Scroll animation for blog cards
    const blogCards = document.querySelectorAll('.blog-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('visible');
                }, index * 100); // Stagger animation
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    blogCards.forEach(card => {
        observer.observe(card);
    });

    // Newsletter form submission
    const newsletterForm = document.getElementById('newsletterForm');
    newsletterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = this.querySelector('.newsletter-input').value;

        if (email) {
            // Show success message
            const button = this.querySelector('.newsletter-btn');
            const originalText = button.innerHTML;

            button.innerHTML = '<i class="fas fa-check"></i> Subscribed!';
            button.style.background = 'var(--gradient-secondary)';

            setTimeout(() => {
                button.innerHTML = originalText;
                button.style.background = '';
                this.reset();
            }, 3000);

            console.log('Newsletter subscription:', email);
        }
    });

    // Category link animations
    const categoryLinks = document.querySelectorAll('.category-link');
    categoryLinks.forEach(link => {
        link.addEventListener('mouseenter', function () {
            this.style.transform = 'translateX(5px)';
        });

        link.addEventListener('mouseleave', function () {
            this.style.transform = 'translateX(0)';
        });
    });

    // Read more button animation
    const readMoreLinks = document.querySelectorAll('.read-more');
    readMoreLinks.forEach(link => {
        link.addEventListener('mouseenter', function () {
            this.querySelector('i').style.transform = 'translateX(5px)';
        });

        link.addEventListener('mouseleave', function () {
            this.querySelector('i').style.transform = 'translateX(0)';
        });
    });

    // Social link hover effect
    const socialLinks = document.querySelectorAll('.social-link');
    socialLinks.forEach(link => {
        link.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-5px) scale(1.1)';
        });

        link.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Blog card hover effect
    blogCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function () {
            this.style.zIndex = '1';
        });
    });

    // Pagination animation
    const pageLinks = document.querySelectorAll('.page-link');
    pageLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();

            // Remove active class from all
            pageLinks.forEach(l => l.classList.remove('active'));

            // Add active class to clicked
            this.classList.add('active');

            // Add click animation
            this.style.transform = 'translateY(-3px) scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'translateY(-3px) scale(1)';
            }, 150);

            // In a real application, this would load the page content
            console.log('Page clicked:', this.textContent);
        });
    });

    // Featured post click handler
    const featuredPosts = document.querySelectorAll('.featured-post');
    featuredPosts.forEach(post => {
        post.addEventListener('click', function () {
            // Add click animation
            this.style.transform = 'translateY(-10px) scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'translateY(-10px) scale(1)';
            }, 150);

            // In a real application, this would navigate to the article
            console.log('Featured post clicked');
        });
    });
});
