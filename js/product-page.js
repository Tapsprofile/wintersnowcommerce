/**
 * Product Page Enhancements
 * Size guide modal and other product page features
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        initSizeGuideModal();
        initMiniCart();
    });
    
    /**
     * Initialize size guide modal
     */
    function initSizeGuideModal() {
        const sizeGuideButton = document.getElementById('size-guide-trigger');
        const modal = document.getElementById('size-guide-modal');
        const closeButton = document.getElementById('modal-close');
        
        if (sizeGuideButton && modal) {
            // Open modal
            sizeGuideButton.addEventListener('click', function(e) {
                e.preventDefault();
                modal.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
            
            // Close modal
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    closeModal(modal);
                });
            }
            
            // Close on overlay click
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
            
            // Close on escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('active')) {
                    closeModal(modal);
                }
            });
        }
    }
    
    /**
     * Close modal
     */
    function closeModal(modal) {
        modal.classList.remove('active');
        document.body.style.overflow = '';
    }
    
    /**
     * Initialize mini cart functionality
     */
    function initMiniCart() {
        // Create mini cart trigger button
        createMiniCartTrigger();
        
        // Listen for add to cart events
        document.addEventListener('added_to_cart', function() {
            openMiniCart();
        });
        
        // Close mini cart
        const closeButtons = document.querySelectorAll('.mini-cart-close');
        closeButtons.forEach(function(button) {
            button.addEventListener('click', closeMiniCart);
        });
        
        // Close on overlay click
        const miniCartOverlay = document.querySelector('.mini-cart-overlay');
        if (miniCartOverlay) {
            miniCartOverlay.addEventListener('click', function(e) {
                if (e.target === miniCartOverlay) {
                    closeMiniCart();
                }
            });
        }
    }
    
    /**
     * Create mini cart trigger button
     */
    function createMiniCartTrigger() {
        // This would typically be created in the header via PHP/Elementor
        // This is a fallback for demonstration
        const cartTriggers = document.querySelectorAll('.cart-trigger, .mini-cart-trigger');
        
        cartTriggers.forEach(function(trigger) {
            trigger.addEventListener('click', function(e) {
                e.preventDefault();
                openMiniCart();
            });
        });
    }
    
    /**
     * Open mini cart
     */
    function openMiniCart() {
        const miniCart = document.querySelector('.mini-cart-overlay');
        if (miniCart) {
            miniCart.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }
    
    /**
     * Close mini cart
     */
    function closeMiniCart() {
        const miniCart = document.querySelector('.mini-cart-overlay');
        if (miniCart) {
            miniCart.classList.remove('active');
            document.body.style.overflow = '';
        }
    }
    
})();
