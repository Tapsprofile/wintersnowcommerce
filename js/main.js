/**
 * Main JavaScript
 * General site functionality
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        initMegaMenu();
        initAccountTabs();
        initFloatingPromoBar();
    });
    
    /**
     * Initialize mega menu functionality
     */
    function initMegaMenu() {
        // Add mega menu classes to navigation items with children
        $('.menu-item-has-children').addClass('mega-menu');
        
        // Handle mobile menu toggle
        $(document).on('click', '.mobile-menu-toggle', function() {
            $(this).toggleClass('active');
            $('.primary-navigation').toggleClass('active');
        });
    }
    
    /**
     * Initialize My Account horizontal tabs
     */
    function initAccountTabs() {
        const $tabs = $('.account-tab');
        const $contents = $('.account-tab-content');
        
        if ($tabs.length === 0) {
            return;
        }
        
        // Set first tab as active by default
        $tabs.first().addClass('active');
        $contents.first().addClass('active');
        
        // Tab click handler
        $tabs.on('click', function(e) {
            e.preventDefault();
            
            const $this = $(this);
            const targetId = $this.data('tab');
            
            // Remove active class from all tabs and contents
            $tabs.removeClass('active');
            $contents.removeClass('active');
            
            // Add active class to clicked tab
            $this.addClass('active');
            
            // Show corresponding content
            $('#' + targetId).addClass('active');
            
            // Update URL hash without scrolling
            if (history.pushState) {
                history.pushState(null, null, '#' + targetId);
            }
        });
        
        // Handle direct URL hash navigation
        if (window.location.hash) {
            const hash = window.location.hash.substring(1);
            const $targetTab = $('.account-tab[data-tab="' + hash + '"]');
            
            if ($targetTab.length) {
                $targetTab.trigger('click');
            }
        }
    }
    
    /**
     * Initialize floating promo bar
     */
    function initFloatingPromoBar() {
        const $promoBar = $('.floating-promo-bar');
        
        if ($promoBar.length === 0) {
            return;
        }
        
        // Add close button
        const $closeButton = $('<button class="promo-bar-close" aria-label="Close">&times;</button>');
        $promoBar.append($closeButton);
        
        // Handle close
        $closeButton.on('click', function() {
            $promoBar.fadeOut(300, function() {
                $(this).remove();
            });
            
            // Remember user closed it (optional)
            localStorage.setItem('promoBarClosed', 'true');
        });
        
        // Check if user previously closed it
        if (localStorage.getItem('promoBarClosed') === 'true') {
            $promoBar.hide();
        }
    }
    
    /**
     * Smooth scroll for anchor links (excluding tabs and modals)
     */
    $('a[href^="#"]:not(.account-tab):not([data-tab])').on('click', function(e) {
        const target = $(this.hash);
        
        // Only smooth scroll if target exists and is not a tab content
        if (target.length && !target.hasClass('account-tab-content')) {
            e.preventDefault();
            
            $('html, body').animate({
                scrollTop: target.offset().top - 100
            }, 500);
        }
    });
    
})(jQuery);
