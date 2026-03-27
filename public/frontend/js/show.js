
document.addEventListener('DOMContentLoaded', function () {
    // Reading progress bar
    const progressBar = document.getElementById('progressBar');

    window.addEventListener('scroll', function () {
        const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (window.scrollY / windowHeight) * 100;
        progressBar.style.width = scrolled + '%';
    });

    // Scroll animations
    const animatedElements = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationDelay = (entries.indexOf(entry) * 0.2) + 's';
                entry.target.classList.add('animate__animated', 'animate__fadeInUp');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Comment form submission
    const commentForm = document.getElementById('commentForm');
    commentForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // In a real app, this would submit to server
        alert('Thank you for your comment! It will be visible after moderation.');
        this.reset();
    });

    // Newsletter form
    const newsletterForm = document.querySelector('.newsletter-form');
    newsletterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const email = this.querySelector('.newsletter-input').value;

        if (email) {
            const button = this.querySelector('.submit-btn');
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

    // Social share buttons
    const shareButtons = document.querySelectorAll('.share-btn');
    shareButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();

            // Animation
            this.style.transform = 'translateY(-5px) scale(1.1)';
            setTimeout(() => {
                this.style.transform = 'translateY(-5px) scale(1)';
            }, 150);

            // In a real app, this would open share dialog
            console.log('Share button clicked:', this.className);
        });
    });

    // Tag hover effect
    const tags = document.querySelectorAll('.tag');
    tags.forEach(tag => {
        tag.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-2px)';
        });

        tag.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
        });
    });

    // Reply button functionality
    const replyButtons = document.querySelectorAll('.reply-btn');
    replyButtons.forEach(button => {
        button.addEventListener('click', function () {
            const commentBox = this.closest('.comment-content');
            const replyForm = document.createElement('div');
            replyForm.className = 'reply-form';
            replyForm.innerHTML = `
                        <div class="form-group mt-3">
                            <textarea class="form-control" rows="3" placeholder="Write your reply..."></textarea>
                        </div>
                        <button type="submit" class="submit-btn btn-sm">
                            <i class="fas fa-reply me-1"></i>Post Reply
                        </button>
                    `;

            commentBox.appendChild(replyForm);
            this.style.display = 'none';
        });
    });

    // Image grid lightbox effect
    const gridImages = document.querySelectorAll('.grid-image');
    gridImages.forEach(image => {
        image.addEventListener('click', function () {
            // Create lightbox
            const lightbox = document.createElement('div');
            lightbox.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0,0,0,0.9);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 9999;
                        cursor: pointer;
                    `;

            const lightboxImg = document.createElement('img');
            lightboxImg.src = this.src;
            lightboxImg.style.cssText = `
                        max-width: 90%;
                        max-height: 90%;
                        border-radius: 10px;
                        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
                    `;

            lightbox.appendChild(lightboxImg);
            document.body.appendChild(lightbox);

            // Close on click
            lightbox.addEventListener('click', function () {
                document.body.removeChild(this);
            });

            // Close on escape key
            document.addEventListener('keydown', function closeOnEscape(e) {
                if (e.key === 'Escape') {
                    document.body.removeChild(lightbox);
                    document.removeEventListener('keydown', closeOnEscape);
                }
            });
        });
    });

    // Back to top functionality for progress bar
    progressBar.addEventListener('click', function () {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
});
