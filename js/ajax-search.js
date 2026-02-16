/**
 * AJAX Product Search
 * Real-time product search with image and price display
 */

(function($) {
    'use strict';
    
    let searchTimeout;
    let currentRequest = null;
    
    $(document).ready(function() {
        initAjaxSearch();
    });
    
    /**
     * Initialize AJAX search functionality
     */
    function initAjaxSearch() {
        // Check if AJAX vars are available
        if (typeof wintersnowAjax === 'undefined') {
            return;
        }
        
        // Create search container if it doesn't exist
        const searchContainer = createSearchContainer();
        
        // Bind search input event
        $(document).on('input', '.woo-ajax-search input[type="search"]', function() {
            const query = $(this).val().trim();
            handleSearchInput(query, $(this));
        });
        
        // Close search results when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.woo-ajax-search').length) {
                $('.search-results-dropdown').remove();
            }
        });
        
        // Close on escape key
        $(document).on('keydown', function(e) {
            if (e.key === 'Escape') {
                $('.search-results-dropdown').remove();
            }
        });
    }
    
    /**
     * Create search container HTML
     */
    function createSearchContainer() {
        // Check if search already exists
        if ($('.woo-ajax-search').length > 0) {
            return $('.woo-ajax-search');
        }
        
        const searchHTML = `
            <div class="woo-ajax-search">
                <input type="search" placeholder="Search products..." aria-label="Search products">
                <button type="submit" class="search-submit" aria-label="Submit search">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="20" height="20">
                        <path fill-rule="evenodd" d="M10.5 3.75a6.75 6.75 0 100 13.5 6.75 6.75 0 000-13.5zM2.25 10.5a8.25 8.25 0 1114.59 5.28l4.69 4.69a.75.75 0 11-1.06 1.06l-4.69-4.69A8.25 8.25 0 012.25 10.5z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
        
        // Insert into header
        const header = $('.site-header .container').first();
        if (header.length) {
            header.append(searchHTML);
        }
        
        return $('.woo-ajax-search');
    }
    
    /**
     * Handle search input with debouncing
     */
    function handleSearchInput(query, $input) {
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Cancel previous AJAX request if still pending
        if (currentRequest) {
            currentRequest.abort();
        }
        
        // Remove results if query is too short
        if (query.length < 2) {
            $('.search-results-dropdown').remove();
            return;
        }
        
        // Show loading state
        showLoadingState($input);
        
        // Debounce search
        searchTimeout = setTimeout(function() {
            performSearch(query, $input);
        }, 300);
    }
    
    /**
     * Show loading state
     */
    function showLoadingState($input) {
        const $container = $input.closest('.woo-ajax-search');
        let $dropdown = $container.find('.search-results-dropdown');
        
        if ($dropdown.length === 0) {
            $dropdown = $('<div class="search-results-dropdown"></div>');
            $container.append($dropdown);
        }
        
        $dropdown.html('<div class="search-loading">Searching...</div>');
    }
    
    /**
     * Perform AJAX search
     */
    function performSearch(query, $input) {
        currentRequest = $.ajax({
            url: wintersnowAjax.ajaxurl,
            type: 'POST',
            data: {
                action: 'wintersnow_product_search',
                query: query,
                nonce: wintersnowAjax.nonce
            },
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    displayResults(response.data, $input);
                } else {
                    displayNoResults($input);
                }
            },
            error: function(xhr) {
                if (xhr.statusText !== 'abort') {
                    displayError($input);
                }
            },
            complete: function() {
                currentRequest = null;
            }
        });
    }
    
    /**
     * Display search results
     */
    function displayResults(results, $input) {
        const $container = $input.closest('.woo-ajax-search');
        let $dropdown = $container.find('.search-results-dropdown');
        
        if ($dropdown.length === 0) {
            $dropdown = $('<div class="search-results-dropdown"></div>');
            $container.append($dropdown);
        }
        
        let html = '';
        
        results.forEach(function(product) {
            const imageUrl = product.image || 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Crect fill="%23ddd" width="100" height="100"/%3E%3C/svg%3E';
            
            html += `
                <a href="${product.url}" class="search-result-item">
                    <img src="${imageUrl}" alt="${product.title}" class="search-result-image">
                    <div class="search-result-info">
                        <div class="search-result-title">${product.title}</div>
                        <div class="search-result-price">${product.price}</div>
                    </div>
                </a>
            `;
        });
        
        $dropdown.html(html);
    }
    
    /**
     * Display no results message
     */
    function displayNoResults($input) {
        const $container = $input.closest('.woo-ajax-search');
        let $dropdown = $container.find('.search-results-dropdown');
        
        if ($dropdown.length === 0) {
            $dropdown = $('<div class="search-results-dropdown"></div>');
            $container.append($dropdown);
        }
        
        $dropdown.html('<div class="search-no-results">No products found</div>');
    }
    
    /**
     * Display error message
     */
    function displayError($input) {
        const $container = $input.closest('.woo-ajax-search');
        let $dropdown = $container.find('.search-results-dropdown');
        
        if ($dropdown.length === 0) {
            $dropdown = $('<div class="search-results-dropdown"></div>');
            $container.append($dropdown);
        }
        
        $dropdown.html('<div class="search-error">An error occurred. Please try again.</div>');
    }
    
})(jQuery);
