<?php
/**
 * WinterSnow Commerce Theme Functions
 *
 * @package WinterSnow_Commerce
 * @version 1.0.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Theme Setup
function wintersnow_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    add_theme_support('elementor');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'wintersnow-commerce'),
        'footer' => __('Footer Menu', 'wintersnow-commerce'),
    ));
}
add_action('after_setup_theme', 'wintersnow_theme_setup');

// Enqueue Scripts and Styles
function wintersnow_enqueue_scripts() {
    // Main stylesheet
    wp_enqueue_style('wintersnow-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Main JavaScript
    wp_enqueue_script('wintersnow-main', get_template_directory_uri() . '/js/main.js', array('jquery'), '1.0.0', true);
    
    // Dark mode functionality
    wp_enqueue_script('wintersnow-dark-mode', get_template_directory_uri() . '/js/dark-mode.js', array(), '1.0.0', true);
    
    // AJAX search
    if (is_front_page() || is_shop() || is_product_category() || is_product_tag()) {
        wp_enqueue_script('wintersnow-ajax-search', get_template_directory_uri() . '/js/ajax-search.js', array('jquery'), '1.0.0', true);
        wp_localize_script('wintersnow-ajax-search', 'wintersnowAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('wintersnow-search-nonce')
        ));
    }
    
    // Product page enhancements
    if (is_product()) {
        wp_enqueue_script('wintersnow-product', get_template_directory_uri() . '/js/product-page.js', array('jquery'), '1.0.0', true);
    }
    
    // Countdown timer
    wp_enqueue_script('wintersnow-countdown', get_template_directory_uri() . '/js/countdown.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'wintersnow_enqueue_scripts');

// AJAX Product Search Handler
function wintersnow_ajax_product_search() {
    check_ajax_referer('wintersnow-search-nonce', 'nonce');
    
    $search_query = isset($_POST['query']) ? sanitize_text_field($_POST['query']) : '';
    
    if (empty($search_query) || strlen($search_query) < 2) {
        wp_send_json_error('Query too short');
    }
    
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 10,
        's' => $search_query,
        'post_status' => 'publish',
    );
    
    $products = new WP_Query($args);
    $results = array();
    
    if ($products->have_posts()) {
        while ($products->have_posts()) {
            $products->the_post();
            $product = wc_get_product(get_the_ID());
            
            $results[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail'),
                'price' => $product->get_price_html(),
            );
        }
        wp_reset_postdata();
    }
    
    wp_send_json_success($results);
}
add_action('wp_ajax_wintersnow_product_search', 'wintersnow_ajax_product_search');
add_action('wp_ajax_nopriv_wintersnow_product_search', 'wintersnow_ajax_product_search');

// Add Festive Product Tag
function wintersnow_register_festive_taxonomy() {
    $labels = array(
        'name' => __('Festive Tags', 'wintersnow-commerce'),
        'singular_name' => __('Festive Tag', 'wintersnow-commerce'),
        'search_items' => __('Search Festive Tags', 'wintersnow-commerce'),
        'all_items' => __('All Festive Tags', 'wintersnow-commerce'),
        'edit_item' => __('Edit Festive Tag', 'wintersnow-commerce'),
        'update_item' => __('Update Festive Tag', 'wintersnow-commerce'),
        'add_new_item' => __('Add New Festive Tag', 'wintersnow-commerce'),
        'new_item_name' => __('New Festive Tag Name', 'wintersnow-commerce'),
        'menu_name' => __('Festive Tags', 'wintersnow-commerce'),
    );

    register_taxonomy('festive_tag', 'product', array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'festive'),
    ));
}
add_action('init', 'wintersnow_register_festive_taxonomy');

// Add Festive Badge to Products
function wintersnow_add_festive_badge() {
    global $product;
    
    if (!$product) {
        return;
    }
    
    $terms = get_the_terms($product->get_id(), 'festive_tag');
    
    if ($terms && !is_wp_error($terms)) {
        echo '<span class="festive-badge">🎄 Special Offer</span>';
    }
}
add_action('woocommerce_before_shop_loop_item_title', 'wintersnow_add_festive_badge', 10);

// Customize WooCommerce Product Loop
function wintersnow_custom_loop_product_thumbnail() {
    echo '<div class="product-thumbnail-wrapper">';
    woocommerce_template_loop_product_thumbnail();
    wintersnow_add_festive_badge();
    echo '</div>';
}

// Add Order Status Badges
function wintersnow_order_status_badge($status) {
    $badge_class = 'order-status-badge';
    
    switch ($status) {
        case 'processing':
            $badge_class .= ' status-processing';
            $label = __('Processing', 'wintersnow-commerce');
            break;
        case 'on-hold':
            $badge_class .= ' status-processing';
            $label = __('On Hold', 'wintersnow-commerce');
            break;
        case 'completed':
            $badge_class .= ' status-delivered';
            $label = __('Delivered', 'wintersnow-commerce');
            break;
        case 'shipped':
            $badge_class .= ' status-shipped';
            $label = __('Shipped', 'wintersnow-commerce');
            break;
        case 'cancelled':
            $badge_class .= ' status-cancelled';
            $label = __('Cancelled', 'wintersnow-commerce');
            break;
        default:
            $label = ucfirst($status);
    }
    
    return sprintf('<span class="%s">%s</span>', esc_attr($badge_class), esc_html($label));
}

// Customize My Account Order Table
function wintersnow_custom_order_status($status, $order) {
    return wintersnow_order_status_badge($order->get_status());
}
add_filter('woocommerce_order_status_name', 'wintersnow_custom_order_status', 10, 2);

// Add Size Guide Button to Product Page
function wintersnow_add_size_guide_button() {
    global $product;
    
    // Check if product has size variations
    if ($product && $product->is_type('variable')) {
        echo '<button type="button" class="size-guide-button" id="size-guide-trigger">';
        echo __('📏 Size Guide', 'wintersnow-commerce');
        echo '</button>';
    }
}
add_action('woocommerce_before_add_to_cart_button', 'wintersnow_add_size_guide_button');

// Add Product Offers Icons
function wintersnow_add_product_offers() {
    global $product;
    
    if (!$product) {
        return;
    }
    
    echo '<ul class="product-offers">';
    
    // Bulk buy discount (example: if quantity > 5)
    echo '<li data-icon="💰">' . __('Save 10% on Bulk Buy (5+ items)', 'wintersnow-commerce') . '</li>';
    
    // Free delivery
    if ($product->get_price() > 50) { // Example threshold
        echo '<li data-icon="🚚">' . __('Free Delivery Today', 'wintersnow-commerce') . '</li>';
    }
    
    // Money back guarantee
    echo '<li data-icon="✅">' . __('30-Day Money Back Guarantee', 'wintersnow-commerce') . '</li>';
    
    echo '</ul>';
}
add_action('woocommerce_single_product_summary', 'wintersnow_add_product_offers', 25);

// Customize Checkout Fields
function wintersnow_customize_checkout_fields($fields) {
    // Remove unnecessary fields
    unset($fields['billing']['billing_company']);
    unset($fields['billing']['billing_address_2']);
    unset($fields['shipping']['shipping_company']);
    unset($fields['shipping']['shipping_address_2']);
    
    // Make phone required
    $fields['billing']['billing_phone']['required'] = true;
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wintersnow_customize_checkout_fields');

// Add Floating Promo Bar
function wintersnow_floating_promo_bar() {
    ?>
    <div class="floating-promo-bar">
        <span>🎉 Festive Sale Live!</span>
        <span>Flat 20% OFF — Code: <span class="promo-bar-code">FESTIVE20</span></span>
        <span>⏰ Limited Time Offer</span>
    </div>
    <?php
}
add_action('wp_body_open', 'wintersnow_floating_promo_bar');

// Add Size Guide Modal to Footer
function wintersnow_size_guide_modal() {
    ?>
    <div class="modal-overlay" id="size-guide-modal">
        <div class="modal-content">
            <button class="modal-close" id="modal-close">&times;</button>
            <h2><?php _e('Size Guide', 'wintersnow-commerce'); ?></h2>
            <table class="size-guide-table">
                <thead>
                    <tr>
                        <th><?php _e('Size', 'wintersnow-commerce'); ?></th>
                        <th><?php _e('Chest (inches)', 'wintersnow-commerce'); ?></th>
                        <th><?php _e('Waist (inches)', 'wintersnow-commerce'); ?></th>
                        <th><?php _e('Length (inches)', 'wintersnow-commerce'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>XS</td>
                        <td>32-34</td>
                        <td>26-28</td>
                        <td>26</td>
                    </tr>
                    <tr>
                        <td>S</td>
                        <td>35-37</td>
                        <td>29-31</td>
                        <td>27</td>
                    </tr>
                    <tr>
                        <td>M</td>
                        <td>38-40</td>
                        <td>32-34</td>
                        <td>28</td>
                    </tr>
                    <tr>
                        <td>L</td>
                        <td>41-43</td>
                        <td>35-37</td>
                        <td>29</td>
                    </tr>
                    <tr>
                        <td>XL</td>
                        <td>44-46</td>
                        <td>38-40</td>
                        <td>30</td>
                    </tr>
                    <tr>
                        <td>XXL</td>
                        <td>47-49</td>
                        <td>41-43</td>
                        <td>31</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'wintersnow_size_guide_modal');

// Elementor Support
function wintersnow_register_elementor_locations($elementor_theme_manager) {
    $elementor_theme_manager->register_all_core_location();
}
add_action('elementor/theme/register_locations', 'wintersnow_register_elementor_locations');

// Widget Areas
function wintersnow_widgets_init() {
    register_sidebar(array(
        'name' => __('Header Widget Area', 'wintersnow-commerce'),
        'id' => 'header-widget-area',
        'description' => __('Widgets in this area will be shown in the header.', 'wintersnow-commerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => __('Footer Widget Area', 'wintersnow-commerce'),
        'id' => 'footer-widget-area',
        'description' => __('Widgets in this area will be shown in the footer.', 'wintersnow-commerce'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'wintersnow_widgets_init');
