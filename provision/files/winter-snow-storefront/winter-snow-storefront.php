<?php
/**
 * Plugin Name: Winter Snow Storefront
 * Description: Custom WooCommerce storefront layout with layered header, offers, product grid, and conversion-focused footer.
 * Version: 1.0.0
 * Author: Winter Snow Commerce
 * License: GPL-2.0-or-later
 * Text Domain: winter-snow-storefront
 */

if (! defined('ABSPATH')) {
	exit;
}

define('WSS_VERSION', '1.0.0');
define('WSS_PLUGIN_URL', plugin_dir_url(__FILE__));

register_activation_hook(__FILE__, 'wss_activate_plugin');

/**
 * Activation bootstrap.
 */
function wss_activate_plugin() {
	wss_create_storefront_pages();

	if (post_type_exists('product') && function_exists('wc_get_product')) {
		wss_seed_products_and_reviews();
		delete_option('wss_seed_products_pending');
	} else {
		update_option('wss_seed_products_pending', 1, false);
	}
}

/**
 * Late seed in case WooCommerce loaded after activation.
 */
function wss_maybe_seed_products() {
	if (! get_option('wss_seed_products_pending')) {
		return;
	}

	if (! post_type_exists('product') || ! function_exists('wc_get_product')) {
		return;
	}

	wss_seed_products_and_reviews();
	delete_option('wss_seed_products_pending');
}
add_action('init', 'wss_maybe_seed_products', 25);

/**
 * Registers shortcode.
 */
function wss_register_shortcodes() {
	add_shortcode('wss_storefront_homepage', 'wss_render_storefront_homepage');
}
add_action('init', 'wss_register_shortcodes');

/**
 * Frontend assets.
 */
function wss_enqueue_assets() {
	wp_enqueue_style('dashicons');
	wp_enqueue_style(
		'wss-storefront',
		WSS_PLUGIN_URL . 'assets/storefront.css',
		array(),
		WSS_VERSION
	);
	wp_enqueue_script(
		'wss-storefront',
		WSS_PLUGIN_URL . 'assets/storefront.js',
		array(),
		WSS_VERSION,
		true
	);
}

/**
 * Load assets when shortcode is present.
 */
function wss_enqueue_assets_if_needed() {
	if (! is_singular()) {
		return;
	}

	$post = get_post();
	if (! $post instanceof WP_Post) {
		return;
	}

	if (! has_shortcode($post->post_content, 'wss_storefront_homepage')) {
		return;
	}

	wss_enqueue_assets();
}
add_action('wp_enqueue_scripts', 'wss_enqueue_assets_if_needed');

/**
 * Returns top categories.
 *
 * @param int $limit Max categories.
 * @return array<WP_Term>
 */
function wss_get_top_categories($limit = 8) {
	$categories = get_terms(
		array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
			'parent'     => 0,
			'number'     => $limit,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);

	if (is_wp_error($categories)) {
		return array();
	}

	return $categories;
}

/**
 * Returns all category counts combined.
 *
 * @param array<WP_Term> $categories Categories list.
 * @return int
 */
function wss_get_total_category_item_count($categories) {
	$total = 0;
	foreach ($categories as $category) {
		$total += (int) $category->count;
	}
	return $total;
}

/**
 * Offer ticker messages.
 *
 * @return array<string>
 */
function wss_get_offer_messages() {
	return array(
		'SUMMER SALE FOR ALL SWIM SUITS - OFF 50% - SHOP NOW',
		'FREE EXPRESS INTERNATIONAL DELIVERY ON ORDERS OVER $199',
		'LIMITED WEEKEND DEALS ON MEN, WOMEN, KIDS, AND FOOTWEAR',
	);
}

/**
 * Simple nav model.
 *
 * @return array<int, array<string, string>>
 */
function wss_get_primary_nav_items() {
	$shop_url = function_exists('wc_get_page_permalink') ? wc_get_page_permalink('shop') : home_url('/');

	return array(
		array(
			'label' => 'HOME',
			'url'   => home_url('/'),
		),
		array(
			'label' => 'SHOP',
			'url'   => $shop_url,
		),
		array(
			'label' => 'WOMEN',
			'url'   => wss_get_category_link_by_name('Women', $shop_url),
		),
		array(
			'label' => 'MEN',
			'url'   => wss_get_category_link_by_name('Men', $shop_url),
		),
		array(
			'label' => 'OUTERWEAR',
			'url'   => wss_get_category_link_by_name('Outerwear', $shop_url),
		),
		array(
			'label' => 'BLOG',
			'url'   => home_url('/blog'),
		),
		array(
			'label' => 'CONTACT',
			'url'   => home_url('/contact'),
		),
	);
}

/**
 * Finds category URL by name.
 *
 * @param string $name Category name.
 * @param string $fallback URL fallback.
 * @return string
 */
function wss_get_category_link_by_name($name, $fallback) {
	$term = get_term_by('name', $name, 'product_cat');
	if ($term instanceof WP_Term) {
		return wss_get_term_url($term, $fallback);
	}
	return $fallback;
}

/**
 * Converts term to safe URL.
 *
 * @param WP_Term $term Term object.
 * @param string  $fallback URL fallback.
 * @return string
 */
function wss_get_term_url($term, $fallback = '#') {
	$link = get_term_link($term);
	if (is_wp_error($link) || ! is_string($link)) {
		return $fallback;
	}
	return $link;
}

/**
 * Deal deadline as ISO string.
 *
 * @return string
 */
function wss_get_deal_deadline() {
	$stored = get_option('wss_deal_deadline');
	if (is_string($stored) && '' !== $stored) {
		return $stored;
	}

	$deadline = gmdate('c', strtotime('+22 days'));
	update_option('wss_deal_deadline', $deadline, false);
	return $deadline;
}

/**
 * Resolves order tracking URL.
 *
 * @return string
 */
function wss_get_order_tracking_url() {
	$page = get_page_by_path('order-tracking');
	if ($page instanceof WP_Post) {
		return get_permalink($page);
	}

	if (function_exists('wc_get_endpoint_url') && function_exists('wc_get_page_permalink')) {
		return wc_get_endpoint_url('orders', '', wc_get_page_permalink('myaccount'));
	}

	return home_url('/');
}

/**
 * Render product card.
 *
 * @param WC_Product $product Product object.
 * @return string
 */
function wss_render_product_card($product) {
	$product_id        = $product->get_id();
	$product_name      = $product->get_name();
	$product_url       = get_permalink($product_id);
	$product_image     = $product->get_image('woocommerce_thumbnail', array('loading' => 'lazy'));
	$product_price     = $product->get_price_html();
	$review_count      = max(0, (int) $product->get_review_count());
	$average_rating    = (float) $product->get_average_rating();
	$cart_url          = $product->add_to_cart_url();
	$cart_button_text  = $product->add_to_cart_text();
	$cart_button_class = implode(
		' ',
		array_filter(
			array(
				'button',
				'wss-add-to-cart',
				'product_type_' . $product->get_type(),
				$product->supports('ajax_add_to_cart') ? 'ajax_add_to_cart' : '',
				'add_to_cart_button',
			)
		)
	);

	ob_start();
	?>
	<article class="wss-product-card">
		<a class="wss-product-thumb" href="<?php echo esc_url($product_url); ?>">
			<?php echo wp_kses_post($product_image); ?>
		</a>
		<div class="wss-product-body">
			<h3 class="wss-product-title">
				<a href="<?php echo esc_url($product_url); ?>"><?php echo esc_html($product_name); ?></a>
			</h3>
			<p class="wss-product-meta">
				Rating <?php echo esc_html(number_format($average_rating, 1)); ?>/5 - <?php echo esc_html($review_count); ?> reviews
			</p>
			<p class="wss-product-price"><?php echo wp_kses_post($product_price); ?></p>
			<a
				class="<?php echo esc_attr($cart_button_class); ?>"
				href="<?php echo esc_url($cart_url); ?>"
				data-quantity="1"
				data-product_id="<?php echo esc_attr($product_id); ?>"
				rel="nofollow"
			><?php echo esc_html($cart_button_text); ?></a>
		</div>
	</article>
	<?php

	return (string) ob_get_clean();
}

/**
 * Main shortcode renderer.
 *
 * @return string
 */
function wss_render_storefront_homepage() {
	if (! class_exists('WooCommerce') || ! function_exists('wc_get_products')) {
		return '<p>Activate WooCommerce to display the custom storefront.</p>';
	}

	$categories           = wss_get_top_categories(10);
	$total_category_items = wss_get_total_category_item_count($categories);
	$primary_nav_items    = wss_get_primary_nav_items();
	$offer_messages       = wss_get_offer_messages();
	$shop_url             = wc_get_page_permalink('shop');
	$account_url          = wc_get_page_permalink('myaccount');
	$order_tracking_url   = wss_get_order_tracking_url();
	$wishlist_url         = home_url('/wishlist');
	$cart_url             = wc_get_cart_url();
	$cart_count           = function_exists('WC') && WC()->cart ? WC()->cart->get_cart_contents_count() : 0;
	$mobile_panel_id      = wp_unique_id('wss-menu-panel-');
	$deal_deadline        = wss_get_deal_deadline();
	$deal_deadline_text   = gmdate('F j, Y', strtotime($deal_deadline));

	$products = wc_get_products(
		array(
			'status'  => 'publish',
			'limit'   => 10,
			'orderby' => 'date',
			'order'   => 'DESC',
		)
	);

	$sale_ids     = function_exists('wc_get_product_ids_on_sale') ? wc_get_product_ids_on_sale() : array();
	$deal_product = null;

	if (! empty($sale_ids)) {
		$deal_product = wc_get_product((int) $sale_ids[0]);
	} elseif (! empty($products)) {
		$deal_product = $products[0];
	}

	$deal_image = '';
	$deal_url   = $shop_url;
	$deal_name  = 'Deal of the Week';
	if ($deal_product instanceof WC_Product) {
		$deal_image = $deal_product->get_image('large', array('loading' => 'lazy'));
		$deal_url   = get_permalink($deal_product->get_id());
		$deal_name  = $deal_product->get_name();
	}

	ob_start();
	?>
	<div class="wss-site-shell">
		<header class="wss-header">
			<div class="wss-offer-bar" aria-label="Offers">
				<div class="wss-offer-track">
					<?php foreach ($offer_messages as $message) : ?>
						<span class="wss-offer-message"><?php echo esc_html($message); ?></span>
					<?php endforeach; ?>
					<?php foreach ($offer_messages as $message) : ?>
						<span class="wss-offer-message"><?php echo esc_html($message); ?></span>
					<?php endforeach; ?>
				</div>
			</div>

			<div class="wss-utility-bar">
				<p class="wss-utility-left">Free Shipping World wide for all orders over $199. Click and Shop Now.</p>
				<div class="wss-utility-right">
					<a href="<?php echo esc_url($order_tracking_url); ?>">Order Tracking</a>
					<a href="#">English</a>
					<a href="#">USD</a>
				</div>
			</div>

			<div class="wss-main-header">
				<button class="wss-menu-toggle" type="button" aria-expanded="false" aria-controls="<?php echo esc_attr($mobile_panel_id); ?>">
					<span></span>
					<span></span>
					<span></span>
					<span class="screen-reader-text">Toggle Menu</span>
				</button>

				<a class="wss-brand" href="<?php echo esc_url(home_url('/')); ?>">Clotya</a>

				<form class="wss-search-form" role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
					<input type="hidden" name="post_type" value="product">
					<label for="wss-product-search" class="screen-reader-text">Search products</label>
					<input id="wss-product-search" type="search" name="s" placeholder="Search your favorite product..." value="">
					<label for="wss-product-category" class="screen-reader-text">Filter by category</label>
					<select id="wss-product-category" name="product_cat">
						<option value="">Select Category</option>
						<?php foreach ($categories as $category) : ?>
							<option value="<?php echo esc_attr($category->slug); ?>"><?php echo esc_html($category->name); ?></option>
						<?php endforeach; ?>
					</select>
					<button type="submit">Search</button>
				</form>

				<div class="wss-header-actions">
					<a class="wss-icon-link" href="<?php echo esc_url($account_url); ?>" aria-label="My account">
						<span class="dashicons dashicons-admin-users"></span>
					</a>
					<a class="wss-icon-link" href="<?php echo esc_url($wishlist_url); ?>" aria-label="Favorites">
						<span class="dashicons dashicons-heart"></span>
						<em class="wss-icon-count">0</em>
					</a>
					<a class="wss-icon-link" href="<?php echo esc_url($cart_url); ?>" aria-label="Cart">
						<span class="dashicons dashicons-cart"></span>
						<em class="wss-icon-count"><?php echo esc_html($cart_count); ?></em>
					</a>
				</div>
			</div>

			<div id="<?php echo esc_attr($mobile_panel_id); ?>" class="wss-mobile-panel" hidden>
				<nav class="wss-mobile-nav" aria-label="Mobile navigation">
					<?php foreach ($primary_nav_items as $item) : ?>
						<a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>

			<div class="wss-category-layer">
				<div class="wss-all-categories">
					<span>All Categories</span>
					<strong><?php echo esc_html($total_category_items); ?></strong>
				</div>
				<nav class="wss-primary-nav" aria-label="Primary navigation">
					<?php foreach ($primary_nav_items as $item) : ?>
						<a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['label']); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>
		</header>

		<main class="wss-main-content">
			<section class="wss-hero">
				<aside class="wss-side-categories">
					<?php foreach ($categories as $category) : ?>
						<a href="<?php echo esc_url(wss_get_term_url($category, $shop_url)); ?>">
							<span><?php echo esc_html($category->name); ?></span>
							<span class="wss-category-count"><?php echo esc_html($category->count); ?></span>
						</a>
					<?php endforeach; ?>
				</aside>
				<div class="wss-hero-banner">
					<p class="wss-kicker">WINTER 2026 COLLECTION</p>
					<h1>Street Fashion</h1>
					<p>Build high-conversion visual collections with clear category entry points and one-click add to cart.</p>
					<a class="button" href="<?php echo esc_url($shop_url); ?>">Shop Collection</a>
				</div>
			</section>

			<section class="wss-deal-section">
				<div class="wss-deal-media">
					<?php if ('' !== $deal_image) : ?>
						<a href="<?php echo esc_url($deal_url); ?>"><?php echo wp_kses_post($deal_image); ?></a>
					<?php else : ?>
						<div class="wss-deal-placeholder"></div>
					<?php endif; ?>
				</div>
				<div class="wss-deal-copy">
					<p class="wss-kicker">DEAL OF THE WEEK</p>
					<h2><?php echo esc_html($deal_name); ?></h2>
					<p>Limited inventory promotion to create urgency, improve conversion, and increase average order value.</p>
					<div class="wss-countdown" data-expiry="<?php echo esc_attr($deal_deadline); ?>">
						<div><strong data-unit="days">00</strong><span>d</span></div>
						<div><strong data-unit="hours">00</strong><span>h</span></div>
						<div><strong data-unit="minutes">00</strong><span>m</span></div>
						<div><strong data-unit="seconds">00</strong><span>s</span></div>
					</div>
					<a class="button" href="<?php echo esc_url($deal_url); ?>">Shop Now</a>
					<p class="wss-deal-expiry">Limited time offer. Deal expires on <strong><?php echo esc_html($deal_deadline_text); ?></strong>.</p>
				</div>
			</section>

			<section class="wss-design-section">
				<div class="wss-section-heading">
					<h2>Designs You Can Shop Right Now</h2>
					<p>At least 10 curated product designs are displayed below with rating and quick cart actions.</p>
				</div>
				<div class="wss-product-grid">
					<?php if (! empty($products)) : ?>
						<?php foreach ($products as $product) : ?>
							<?php echo wss_render_product_card($product); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
						<?php endforeach; ?>
					<?php else : ?>
						<p>No published products yet. Add products in WooCommerce to populate this section.</p>
					<?php endif; ?>
				</div>
			</section>
		</main>

		<footer class="wss-footer">
			<div class="wss-footer-top">
				<div class="wss-newsletter">
					<h3>Get our emails for info on new items, sales and more.</h3>
					<p>We will email you a voucher worth $10 off your first order over $50.</p>
					<form action="#" method="post" class="wss-newsletter-form">
						<label for="wss-newsletter-email" class="screen-reader-text">Email</label>
						<input id="wss-newsletter-email" type="email" name="email" placeholder="Enter your email address">
						<button type="submit">Subscribe</button>
					</form>
					<small>By subscribing you agree to our Terms and Conditions and Privacy Policy.</small>
				</div>
				<div class="wss-support">
					<h3>Need help? (+800) 1234 5678 90</h3>
					<p>We are available 8:00am to 7:00pm.</p>
					<p><a href="mailto:info@example.com">info@example.com</a></p>
				</div>
			</div>
			<div class="wss-footer-bottom">
				<div class="wss-footer-brand">
					<h4>Clotya</h4>
					<p>Focused on clean shopping flows, visible trust signals, and fast route-to-product navigation.</p>
					<p>(+800) 1234 5678 90 - info@example.com</p>
				</div>
				<div>
					<h5>Information</h5>
					<ul>
						<li><a href="<?php echo esc_url(home_url('/about-us')); ?>">About Us</a></li>
						<li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
						<li><a href="<?php echo esc_url(home_url('/returns-policy')); ?>">Returns Policy</a></li>
						<li><a href="<?php echo esc_url(home_url('/shipping-policy')); ?>">Shipping Policy</a></li>
					</ul>
				</div>
				<div>
					<h5>Account</h5>
					<ul>
						<li><a href="<?php echo esc_url($account_url); ?>">Dashboard</a></li>
						<li><a href="<?php echo esc_url($account_url); ?>">My Orders</a></li>
						<li><a href="<?php echo esc_url($wishlist_url); ?>">My Wishlist</a></li>
						<li><a href="<?php echo esc_url($order_tracking_url); ?>">Track My Orders</a></li>
					</ul>
				</div>
				<div>
					<h5>Shop</h5>
					<ul>
						<li><a href="<?php echo esc_url($shop_url); ?>">Latest Products</a></li>
						<li><a href="<?php echo esc_url($shop_url); ?>">Bestsellers</a></li>
						<li><a href="<?php echo esc_url($shop_url); ?>">Discount Deals</a></li>
						<li><a href="<?php echo esc_url($shop_url); ?>">Sale Products</a></li>
					</ul>
				</div>
				<div>
					<h5>Categories</h5>
					<ul>
						<?php foreach ($categories as $category) : ?>
							<li><a href="<?php echo esc_url(wss_get_term_url($category, $shop_url)); ?>"><?php echo esc_html($category->name); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</footer>
	</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Creates pages and front page mapping.
 */
function wss_create_storefront_pages() {
	$home_page_id = wss_get_or_create_page(
		'winter-snow-home',
		'Winter Snow Home',
		'[wss_storefront_homepage]'
	);
	wss_get_or_create_page(
		'order-tracking',
		'Order Tracking',
		'[woocommerce_order_tracking]'
	);

	if ($home_page_id > 0) {
		update_option('show_on_front', 'page');
		update_option('page_on_front', $home_page_id);
	}
}

/**
 * Returns an existing page or creates one.
 *
 * @param string $slug Page slug.
 * @param string $title Page title.
 * @param string $content Page content.
 * @return int
 */
function wss_get_or_create_page($slug, $title, $content) {
	$page = get_page_by_path($slug);
	if ($page instanceof WP_Post) {
		return (int) $page->ID;
	}

	$page_id = wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_title'   => $title,
			'post_name'    => $slug,
			'post_content' => $content,
			'post_status'  => 'publish',
		)
	);

	if (is_wp_error($page_id)) {
		return 0;
	}

	return (int) $page_id;
}

/**
 * Seeds product catalog and review data.
 */
function wss_seed_products_and_reviews() {
	if (! function_exists('wc_get_product')) {
		return;
	}

	$catalog = array(
		array('name' => 'Roland Grand White Short Checkered T-shirt', 'category' => 'Men', 'regular_price' => 129, 'sale_price' => 99, 'stock' => 11),
		array('name' => 'Soft Knit Oversized Women Pullover', 'category' => 'Women', 'regular_price' => 119, 'sale_price' => 94, 'stock' => 15),
		array('name' => 'Urban Cargo Jogger Pants', 'category' => 'Men', 'regular_price' => 109, 'sale_price' => 82, 'stock' => 9),
		array('name' => 'Premium Streetwear Hoodie', 'category' => 'Women', 'regular_price' => 139, 'sale_price' => 109, 'stock' => 13),
		array('name' => 'Kids Graphic Comfort Tee', 'category' => 'Kids', 'regular_price' => 59, 'sale_price' => 44, 'stock' => 17),
		array('name' => 'Baby Cotton Layered Set', 'category' => 'Baby', 'regular_price' => 49, 'sale_price' => 39, 'stock' => 22),
		array('name' => 'All Season Lightweight Jacket', 'category' => 'Outerwear', 'regular_price' => 149, 'sale_price' => 119, 'stock' => 10),
		array('name' => 'Minimal Leather City Bag', 'category' => 'Bags', 'regular_price' => 169, 'sale_price' => 139, 'stock' => 12),
		array('name' => 'Platform Fashion Sneakers', 'category' => 'Shoes', 'regular_price' => 159, 'sale_price' => 126, 'stock' => 18),
		array('name' => 'Relaxed Linen Shirt Dress', 'category' => 'Women', 'regular_price' => 144, 'sale_price' => 112, 'stock' => 8),
		array('name' => 'Classic Denim Everyday Jeans', 'category' => 'Men', 'regular_price' => 129, 'sale_price' => 103, 'stock' => 14),
		array('name' => 'Performance Training Shorts', 'category' => 'Men', 'regular_price' => 79, 'sale_price' => 61, 'stock' => 20),
	);

	foreach ($catalog as $index => $item) {
		$product_id = wss_get_or_create_seeded_product($item, $index + 1);
		if ($product_id > 0) {
			wss_ensure_product_reviews($product_id, 10);
		}
	}

	update_option('wss_seed_completed', gmdate('c'), false);
}

/**
 * Creates or updates a seeded product.
 *
 * @param array<string, mixed> $item Product source data.
 * @param int                  $seed_number Seed sequence.
 * @return int
 */
function wss_get_or_create_seeded_product($item, $seed_number) {
	$seed_key         = 'wss_seed_' . sanitize_title((string) $item['name']);
	$existing_product = get_posts(
		array(
			'post_type'      => 'product',
			'post_status'    => array('publish', 'draft', 'pending', 'private'),
			'fields'         => 'ids',
			'posts_per_page' => 1,
			'meta_key'       => '_wss_seed_key',
			'meta_value'     => $seed_key,
		)
	);

	$product = null;
	if (! empty($existing_product)) {
		$product = wc_get_product((int) $existing_product[0]);
	}

	if (! $product) {
		$product = new WC_Product_Simple();
	}

	$category_name = (string) $item['category'];
	$category_id   = wss_get_or_create_product_category($category_name);

	$product->set_name((string) $item['name']);
	$product->set_status('publish');
	$product->set_catalog_visibility('visible');
	$product->set_regular_price((string) $item['regular_price']);
	$product->set_sale_price((string) $item['sale_price']);
	$product->set_manage_stock(true);
	$product->set_stock_quantity((int) $item['stock']);
	$product->set_stock_status(((int) $item['stock'] > 0) ? 'instock' : 'outofstock');
	$product->set_sku('WSS-' . strtoupper(substr(md5($seed_key), 0, 8)));
	$product->set_short_description('Designed for fast browsing with clear sizing and quick checkout action.');
	$product->set_description('Seeded by Winter Snow Storefront plugin to provide a ready catalog with conversion-focused layout testing.');
	$product->set_reviews_allowed(true);

	$product_id = $product->save();
	if (! $product_id) {
		return 0;
	}

	if ($category_id > 0) {
		wp_set_post_terms($product_id, array($category_id), 'product_cat', false);
	}

	wp_set_post_terms($product_id, array('simple'), 'product_type', false);
	update_post_meta($product_id, '_wss_seed_key', $seed_key);

	return (int) $product_id;
}

/**
 * Ensure product category exists.
 *
 * @param string $category_name Category name.
 * @return int
 */
function wss_get_or_create_product_category($category_name) {
	$term = term_exists($category_name, 'product_cat');
	if (is_array($term) && ! empty($term['term_id'])) {
		return (int) $term['term_id'];
	}

	$new_term = wp_insert_term($category_name, 'product_cat');
	if (is_wp_error($new_term) || empty($new_term['term_id'])) {
		return 0;
	}

	return (int) $new_term['term_id'];
}

/**
 * Ensures a minimum review volume per product.
 *
 * @param int $product_id Product ID.
 * @param int $minimum_reviews Count floor.
 */
function wss_ensure_product_reviews($product_id, $minimum_reviews = 10) {
	$current_reviews = (int) get_comments(
		array(
			'post_id' => $product_id,
			'status'  => 'approve',
			'type'    => 'review',
			'count'   => true,
		)
	);

	if ($current_reviews >= $minimum_reviews) {
		return;
	}

	$authors = array(
		'Amanda',
		'Noah',
		'Liam',
		'Olivia',
		'Emma',
		'Lucas',
		'Harper',
		'Mason',
		'Charlotte',
		'Elijah',
		'Sophia',
		'Ethan',
	);

	$comments = array(
		'Fabric quality is excellent and sizing is accurate.',
		'Fast delivery and the fit is exactly what I expected.',
		'Great value for price and looks premium in person.',
		'Very comfortable for daily wear, I will reorder.',
		'Color and stitching are both strong after multiple washes.',
		'Good style and lightweight feel, ideal for regular use.',
		'Love this product, support team was also very responsive.',
		'Matches product photos and performs well during use.',
		'Packaging was neat and product arrived in perfect condition.',
		'High quality material and overall great shopping experience.',
	);

	for ($offset = $current_reviews; $offset < $minimum_reviews; $offset++) {
		$author  = $authors[$offset % count($authors)];
		$content = $comments[$offset % count($comments)];
		$rating  = ($offset % 2 === 0) ? 5 : 4;
		$days    = max(1, $offset + 2);

		$comment_id = wp_insert_comment(
			array(
				'comment_post_ID'      => $product_id,
				'comment_author'       => $author,
				'comment_author_email' => strtolower($author) . '@example.com',
				'comment_content'      => $content,
				'comment_type'         => 'review',
				'comment_approved'     => 1,
				'comment_date'         => gmdate('Y-m-d H:i:s', strtotime('-' . $days . ' days')),
				'comment_date_gmt'     => gmdate('Y-m-d H:i:s', strtotime('-' . $days . ' days')),
			)
		);

		if ($comment_id) {
			update_comment_meta($comment_id, 'rating', $rating);
			update_comment_meta($comment_id, 'verified', 1);
		}
	}

	if (function_exists('wc_update_product_rating_counts')) {
		wc_update_product_rating_counts($product_id);
		wc_update_product_average_rating($product_id);
		wc_update_product_review_count($product_id);
	}

	if (function_exists('wc_delete_product_transients')) {
		wc_delete_product_transients($product_id);
	}
}
