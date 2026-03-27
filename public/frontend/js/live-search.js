document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearch');
    const searchResults = document.getElementById('searchResults');
    const searchBtn = document.querySelector('.search-btn');
    let searchTimeout;
    
    // Debug: Check if elements are found
    console.log('Search input found:', !!searchInput);
    console.log('Search results found:', !!searchResults);
    console.log('Search button found:', !!searchBtn);
    
    if (!searchInput || !searchResults) {
        console.warn('Search elements not found');
        return;
    }
    
    // Utility function to escape HTML
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }
    
    // Live search functionality - show dropdown suggestions
    searchInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        if (query.length < 1) {
            hideResults();
            return;
        }
        
        // Show loading state
        showLoading();
        
        // Debounce search requests
        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });
    
    // Handle search button click
    searchBtn?.addEventListener('click', function() {
        const query = searchInput.value.trim();
        if (query.length >= 1) {
            window.location.href = `/live-search?q=${encodeURIComponent(query)}`;
        }
    });
    
    // Handle Enter key
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            const query = this.value.trim();
            if (query.length >= 1) {
                window.location.href = `/live-search?q=${encodeURIComponent(query)}`;
                hideResults();
            }
        }
    });
    
    // Hide results when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.search-container')) {
            hideResults();
        }
    });
    
    // Enhanced keyboard navigation
    let currentFocus = -1;
    
    searchInput.addEventListener('keydown', function(e) {
        const items = searchResults.querySelectorAll('.search-result-item');
        if (items.length === 0) return;
        
        if (e.key === 'ArrowDown') {
            e.preventDefault();
            currentFocus++;
            if (currentFocus >= items.length) currentFocus = 0;
            setActive(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            currentFocus--;
            if (currentFocus < 0) currentFocus = items.length - 1;
            setActive(items);
        } else if (e.key === 'Enter') {
            e.preventDefault();
            if (currentFocus > -1) {
                items[currentFocus].click();
            } else {
                const query = this.value.trim();
                if (query.length >= 1) {
                    window.location.href = `/live-search?q=${encodeURIComponent(query)}`;
                }
            }
        } else if (e.key === 'Escape') {
            hideResults();
            this.blur();
        }
    });
    
    function setActive(items) {
        if (!items) return;
        removeActive(items);
        if (currentFocus > -1) {
            items[currentFocus].classList.add('search-result-active');
            items[currentFocus].style.background = 'linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(34, 153, 84, 0.05))';
            // Scroll into view if needed
            items[currentFocus].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }
    
    function removeActive(items) {
        for (let item of items) {
            item.classList.remove('search-result-active');
            item.style.background = '';
        }
    }
    
    // Show results on focus if there's content
    searchInput.addEventListener('focus', function() {
        const query = this.value.trim();
        if (query.length > 0 && searchResults.classList.contains('active')) {
            searchResults.classList.add('active');
        }
    });
    
    // Keep results open when clicking inside
    searchResults.addEventListener('click', function(e) {
        e.stopPropagation();
        // Hide results after a short delay to allow for navigation
        setTimeout(() => {
            hideResults();
        }, 300);
    });
    
    // Add CSS for keyboard navigation
    const style = document.createElement('style');
    style.textContent = `
        .search-result-active {
            background: linear-gradient(135deg, rgba(39, 174, 96, 0.1), rgba(34, 153, 84, 0.05)) !important;
            transform: translateX(8px) !important;
            padding-left: 25px !important;
        }
        .search-result-active::before {
            transform: scaleY(1) !important;
        }
        .search-result-active .search-result-name {
            color: #27ae60 !important;
        }
        .search-result-active .search-result-image {
            transform: scale(1.05) !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12) !important;
        }
        .search-result-active .search-result-image::before {
            opacity: 1 !important;
        }
        .search-result-active .search-result-image img {
            transform: scale(1.1) !important;
        }
        .search-result-active .search-result-price {
            transform: scale(1.05) !important;
        }
    `;
    document.head.appendChild(style);
    
    function performSearch(query) {
        console.log('Performing search for:', query);
        const searchUrl = `/live-search?q=${encodeURIComponent(query)}`;
        console.log('Search URL:', searchUrl);
        
        // Use Axios for AJAX request (already loaded in layout)
        axios.get(searchUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Search response:', response.data);
            displayResults(response.data);
        })
        .catch(error => {
            console.error('Search error:', error);
            showError();
        });
    }
    
    function displayResults(data) {
        console.log('Displaying results:', data);
        
        if (!data || !Array.isArray(data.products) || data.products.length === 0) {
            console.log('No results found');
            showNoResults();
            return;
        }

        const resultsHtml = data.products.map((product, index) => `
            <a href="${product.url || `/product/${product.slug}`}" class="search-result-item" style="animation-delay: ${index * 0.05}s">
                <div class="search-result-image">
                    ${product.image_url && !product.image_url.includes('default-product')
                        ? `<img src="${product.image_url}" alt="${escapeHtml(product.name)}" loading="lazy" 
                            onerror="this.onerror=null; this.src='/images/default-product.svg';">` 
                        : `<div class="search-result-placeholder"><i class="fas fa-image"></i></div>`
                    }
                </div>
                <div class="search-result-info">
                    <div class="search-result-name">${escapeHtml(product.name)}</div>
                    <div class="search-result-details">
                        <div class="search-result-cat">${escapeHtml(product.category || 'General')}</div>
                        <div class="search-result-price">
                            ${product.sale_price && Number(product.sale_price) > 0
                                ? `${product.sale_price}`
                                : product.price
                                    ? `${product.price}`
                                    : 'N/A'
                            }
                        </div>
                    </div>
                </div>
            </a>
        `).join('');

        // Add "View all results" link at the bottom
        const viewAllHtml = `
            <a href="/live-search?q=${encodeURIComponent(data.query || searchInput.value.trim())}" class="search-result-item search-view-all">
                <div class="search-result-image">
                    <i class="fas fa-arrow-right" style="color: #27ae60; font-size: 20px;"></i>
                </div>
                <div class="search-result-info text-center">
                    <div class="search-result-name">View All Results</div>
                    <div class="search-result-details">
                        <div class="search-result-cat">See all matching products</div>
                    </div>
                </div>
            </a>
        `;

        searchResults.innerHTML = resultsHtml + viewAllHtml;
        
        // Add staggered animation
        setTimeout(() => {
            searchResults.classList.add('active');
            // Add animation to result items
            const items = searchResults.querySelectorAll('.search-result-item:not(.search-view-all)');
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(10px)';
                setTimeout(() => {
                    item.style.transition = 'all 0.3s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, index * 50);
            });
        }, 50);
        
        console.log('Results displayed, dropdown should be visible');
    }
    
    function showLoading() {
        searchResults.innerHTML = `
            <div class="search-loading">
                <div style="display: flex; align-items: center; justify-content: center; gap: 10px;">
                    <div class="search-spinner" style="width: 20px; height: 20px; border: 2px solid rgba(39, 174, 96, 0.3); border-radius: 50%; border-top-color: #27ae60; animation: spin 1s linear infinite;"></div>
                    <span>Finding amazing products...</span>
                </div>
            </div>
        `;
        searchResults.classList.add('active');
    }
    
    function showNoResults() {
        searchResults.innerHTML = `
            <div class="search-no-results">
                <div style="margin-bottom: 10px;">
                    <i class="fas fa-search" style="font-size: 24px; color: #999; margin-bottom: 10px;"></i>
                </div>
                <div style="font-weight: 600; margin-bottom: 5px;">No products found</div>
                <div style="font-size: 13px; color: #666;">Try searching with different keywords</div>
            </div>
        `;
        searchResults.classList.add('active');
    }
    
    function showError() {
        searchResults.innerHTML = `
            <div class="search-no-results" style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.05), rgba(192, 57, 43, 0.02)); border-color: rgba(231, 76, 60, 0.2);">
                <div style="margin-bottom: 10px;">
                    <i class="fas fa-exclamation-triangle" style="font-size: 24px; color: #e74c3c; margin-bottom: 10px;"></i>
                </div>
                <div style="font-weight: 600; margin-bottom: 5px;">Search error</div>
                <div style="font-size: 13px; color: #666;">Please try again in a moment</div>
            </div>
        `;
        searchResults.classList.add('active');
    }
    
    function hideResults() {
        searchResults.classList.remove('active');
        searchResults.innerHTML = '';
    }
});

