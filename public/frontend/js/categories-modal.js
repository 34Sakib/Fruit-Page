document.addEventListener('DOMContentLoaded', function() {
    // Handle category selection from modal
    const categoryItems = document.querySelectorAll('.subcategory-item');
    const categoryTitleLinks = document.querySelectorAll('.category-title-link');
    const searchCategoryBtn = document.querySelector('.category-popup-btn span');
    
    categoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            // Get category name from link text
            const categoryName = this.textContent.trim();
            
            // Update button text to show selected category
            if (searchCategoryBtn) {
                searchCategoryBtn.textContent = categoryName.length > 15 ? 
                    categoryName.substring(0, 15) + '...' : categoryName;
            }
            
            // Close modal after navigation starts
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('categoriesModal'));
                if (modal) {
                    modal.hide();
                }
            }, 100);
        });
    });
    
    // Handle category title clicks
    categoryTitleLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Get category name from link text
            const categoryName = this.textContent.trim();
            
            // Update button text to show selected category
            if (searchCategoryBtn) {
                searchCategoryBtn.textContent = categoryName.length > 15 ? 
                    categoryName.substring(0, 15) + '...' : categoryName;
            }
            
            // Close modal after navigation starts
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('categoriesModal'));
                if (modal) {
                    modal.hide();
                }
            }, 100);
        });
    });
    
    // Handle featured tag clicks
    const featuredTags = document.querySelectorAll('.featured-tag');
    featuredTags.forEach(tag => {
        tag.addEventListener('click', function(e) {
            // Get category name from tag text
            const categoryName = this.textContent.trim();
            
            // Update button text to show selected category
            if (searchCategoryBtn) {
                searchCategoryBtn.textContent = categoryName.length > 15 ? 
                    categoryName.substring(0, 15) + '...' : categoryName;
            }
            
            // Close modal after navigation starts
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('categoriesModal'));
                if (modal) {
                    modal.hide();
                }
            }, 100);
        });
    });
    
    // Add keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Ctrl/Cmd + K to open categories modal
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            const modal = new bootstrap.Modal(document.getElementById('categoriesModal'));
            modal.show();
        }
        
        // Escape to close modal
        if (e.key === 'Escape') {
            const modal = bootstrap.Modal.getInstance(document.getElementById('categoriesModal'));
            if (modal) {
                modal.hide();
            }
        }
    });
    
    // Add search functionality for categories within modal
    const modalSearchInput = document.createElement('input');
    modalSearchInput.type = 'text';
    modalSearchInput.className = 'form-control mb-2';
    modalSearchInput.placeholder = 'Search categories...';
    modalSearchInput.style.fontSize = '13px';
    modalSearchInput.style.padding = '8px 12px';
    
    // Insert search input at the top of modal body
    const modalBody = document.querySelector('#categoriesModal .modal-body');
    if (modalBody) {
        modalBody.insertBefore(modalSearchInput, modalBody.firstChild);
        
        // Add search functionality
        modalSearchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const categoryCards = document.querySelectorAll('.category-card');
            
            categoryCards.forEach(card => {
                const title = card.querySelector('.category-title')?.textContent.toLowerCase() || '';
                const subcategories = Array.from(card.querySelectorAll('.subcategory-item'))
                    .map(item => item.textContent.toLowerCase())
                    .join(' ');
                
                const isVisible = title.includes(searchTerm) || subcategories.includes(searchTerm);
                card.style.display = isVisible ? 'block' : 'none';
            });
        });
    }
    
    // Add animation to category cards on modal show
    const categoriesModal = document.getElementById('categoriesModal');
    if (categoriesModal) {
        categoriesModal.addEventListener('shown.bs.modal', function() {
            const categoryCards = document.querySelectorAll('.category-card');
            categoryCards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.3s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 50);
            });
        });
    }
});
