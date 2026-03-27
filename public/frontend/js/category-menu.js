document.addEventListener('DOMContentLoaded', function() {
    // Category interaction
    const categoryItems = document.querySelectorAll('.category-item');
    
    categoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            
            // Remove active class from all categories
            categoryItems.forEach(cat => {
                cat.classList.remove('active');
            });
            
            // Add active class to clicked category
            this.classList.add('active');
            
            // Toggle subcategories visibility
            const subcategories = this.nextElementSibling;
            if (subcategories && subcategories.classList.contains('subcategories')) {
                // Close all other subcategories
                document.querySelectorAll('.subcategories').forEach(sub => {
                    if (sub !== subcategories) {
                        sub.classList.remove('show');
                    }
                });
                
                // Toggle current subcategories
                subcategories.classList.toggle('show');
            }
        });
    });
    
    // Subcategory interaction
    const subcategoryItems = document.querySelectorAll('.subcategory-item');
    
    subcategoryItems.forEach(item => {
        item.addEventListener('click', function(e) {
            
            // Remove active class from all subcategories
            subcategoryItems.forEach(sub => {
                sub.classList.remove('active');
            });
            
            // Add active class to clicked subcategory
            this.classList.add('active');
            
            // Here you can add code to load the subcategory content
            console.log('Subcategory clicked:', this.textContent.trim());
        });
    });
    
    // Initialize - show subcategories for active category
    const activeCategory = document.querySelector('.category-item.active');
    if (activeCategory) {
        const subcategories = activeCategory.nextElementSibling;
        if (subcategories && subcategories.classList.contains('subcategories')) {
            subcategories.classList.add('show');
        }
    }
    
    // Feature box interaction
    const featureBoxes = document.querySelectorAll('.feature-box');
    
    featureBoxes.forEach((box, index) => {
        box.addEventListener('click', function() {
            // Here you can add code to handle feature box clicks
            console.log('Feature clicked:', this.querySelector('.feature-title').textContent.trim());
        });
    });
});
