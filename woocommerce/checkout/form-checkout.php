<?php
/**
 * Checkout Page Template
 * 2-column layout with sticky order summary
 *
 * @package WinterSnow_Commerce
 */

defined('ABSPATH') || exit;

get_header('shop');
?>

<div class="checkout-wrapper">
    <div class="container">
        <h1 class="page-title"><?php _e('Checkout', 'wintersnow-commerce'); ?></h1>
        
        <?php if (WC()->cart->is_empty()) : ?>
            <div class="woocommerce-info">
                <?php _e('Your cart is currently empty.', 'wintersnow-commerce'); ?>
                <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="button">
                    <?php _e('Return to shop', 'wintersnow-commerce'); ?>
                </a>
            </div>
        <?php else : ?>
            
            <?php do_action('woocommerce_before_checkout_form'); ?>
            
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
                
                <div class="checkout-layout">
                    <div class="checkout-forms">
                        <?php if (WC()->checkout()->get_checkout_fields()) : ?>
                            
                            <?php do_action('woocommerce_checkout_before_customer_details'); ?>
                            
                            <div class="customer-details">
                                <div class="billing-fields">
                                    <h3><?php _e('Billing & Shipping Details', 'wintersnow-commerce'); ?></h3>
                                    <?php do_action('woocommerce_checkout_billing'); ?>
                                </div>
                                
                                <?php if (WC()->cart->needs_shipping() && WC()->cart->show_shipping()) : ?>
                                    <div class="shipping-fields">
                                        <?php do_action('woocommerce_checkout_shipping'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
                            
                        <?php endif; ?>
                    </div>
                    
                    <div class="checkout-sidebar">
                        <div class="order-summary">
                            <h3 class="order-summary-title"><?php _e('Order Summary', 'wintersnow-commerce'); ?></h3>
                            
                            <?php do_action('woocommerce_checkout_before_order_review'); ?>
                            
                            <div id="order_review" class="woocommerce-checkout-review-order">
                                <?php do_action('woocommerce_checkout_order_review'); ?>
                            </div>
                            
                            <?php do_action('woocommerce_checkout_after_order_review'); ?>
                        </div>
                    </div>
                </div>
                
            </form>
            
            <?php do_action('woocommerce_after_checkout_form'); ?>
            
        <?php endif; ?>
    </div>
</div>

<?php
get_footer('shop');
