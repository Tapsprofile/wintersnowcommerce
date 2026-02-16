# WinterSnow Commerce - Implementation Guide

## Architecture Overview

This theme implements a high-conversion e-commerce experience following the problem statement's four-phase approach.

## Phase 1: Global Header Implementation

### Dark/Light Mode Toggle
**Location**: `js/dark-mode.js`

**How it works:**
1. Checks `localStorage` for saved preference
2. Falls back to system preference (`prefers-color-scheme`)
3. Creates toggle button dynamically
4. Switches data-theme attribute on `<html>`
5. Saves preference to `localStorage`

**Integration:**
- Button auto-created in header
- SVG icons (sun/moon) change based on theme
- CSS variables update automatically

### AJAX Search
**Location**: `js/ajax-search.js`, `functions.php`

**How it works:**
1. Input debouncing (300ms)
2. AJAX request to `wintersnow_product_search` action
3. Returns product data (title, image, price, URL)
4. Displays results in dropdown
5. Closes on outside click or Esc key

**Backend:**
- WP_Query searches product post type
- Returns first 10 results
- Includes product thumbnail and price HTML

### Mega Menu
**Location**: `style.css`, `js/main.js`

**How it works:**
1. Detects `.menu-item-has-children`
2. Adds `.mega-menu` class
3. CSS creates 3-column dropdown on hover
4. Grid layout for categories
5. Responsive: single column on mobile

## Phase 2: Festive & Offers Implementation

### Festive Product Tagging
**Location**: `functions.php`

**How it works:**
1. Registers custom taxonomy `festive_tag`
2. Attached to product post type
3. Admin can tag products as festive
4. Hook adds badge to product loop
5. Badge shows "🎄 Special Offer"

**Usage:**
```php
// Query festive products in Elementor
tax_query => [
    [
        'taxonomy' => 'festive_tag',
        'field' => 'slug',
        'terms' => 'festive'
    ]
]
```

### Countdown Timer
**Location**: `js/countdown.js`

**How it works:**
1. Finds elements with `.countdown-timer` class
2. Reads `data-end-date` attribute
3. Calculates time difference
4. Updates display every second
5. Shows "Offer Expired" when done

**HTML Structure:**
```html
<div class="countdown-timer" 
     data-end-date="2026-12-31T23:59:59"
     data-title="Sale Ends In:"></div>
```

### Floating Promo Bar
**Location**: `functions.php`, `js/main.js`

**How it works:**
1. PHP function adds bar via `wp_body_open` hook
2. JavaScript adds close button
3. Close action saves to `localStorage`
4. Bar hidden if user previously closed it
5. Sticky position at top of page

## Phase 3: Product Page Implementation

### Price & Offers
**Location**: `functions.php`

**How it works:**
1. Hook: `woocommerce_single_product_summary` at priority 25
2. Displays icon list of offers
3. Icons via `data-icon` attribute
4. Conditional display (e.g., free delivery if price > $50)

### Size Guide Modal
**Location**: `js/product-page.js`, `functions.php`

**How it works:**
1. PHP adds button on variable products
2. PHP adds modal HTML to footer
3. JavaScript handles open/close events
4. Modal shows size table
5. Accessible: Esc key, click outside to close

**Benefits:**
- No page reload
- Instant display
- User stays on product page
- Better conversion

### Product Reviews
**Styling**: `style.css`

**CSS Classes:**
- `.review-card` - Card container
- `.review-header` - Author and rating
- `.review-rating` - Star display
- `.review-text` - Review content

## Phase 4: Cart, Orders & Checkout Implementation

### Mini Cart
**Location**: `js/product-page.js`, `style.css`

**How it works:**
1. Side overlay (400px width)
2. Slides in from right on add-to-cart event
3. Large checkout button (primary action)
4. Smaller view cart link (secondary)
5. Close button and overlay click to dismiss

**CSS:**
- Initially positioned off-screen (`right: -400px`)
- `.active` class slides to `right: 0`
- Transition for smooth animation

### My Account - Horizontal Tabs
**Location**: `woocommerce/myaccount/my-account.php`, `js/main.js`

**How it works:**
1. Custom template overrides default
2. Horizontal tab navigation
3. JavaScript handles tab switching
4. URL hash updates without scroll
5. Direct URL access via hash

**Tab Management:**
- First tab active by default
- Click handler switches content
- Hash navigation supported
- Mobile: scrollable tabs

### Order Status Badges
**Location**: `functions.php`

**How it works:**
1. Filter: `woocommerce_order_status_name`
2. Function returns styled badge HTML
3. Color coding:
   - Processing: Orange
   - Shipped: Blue
   - Delivered: Green
   - Cancelled: Red

### 2-Column Checkout
**Location**: `woocommerce/checkout/form-checkout.php`

**How it works:**
1. Custom template overrides default
2. CSS Grid: 2 columns (auto, 400px)
3. Left: Billing/shipping forms
4. Right: Sticky order summary
5. Mobile: single column layout

**Sticky Summary:**
```css
.checkout-sidebar {
    position: sticky;
    top: 2rem;
}
```

## CSS Architecture

### CSS Variables
All colors use CSS custom properties for easy theming:
```css
:root {
    --primary-color: #2c3e50;
    --secondary-color: #3498db;
    --accent-color: #e74c3c;
    --text-color: #333;
    --bg-color: #fff;
}
```

### Dark Mode
Data attribute triggers dark theme:
```css
[data-theme="dark"] {
    --text-color: #f4f4f4;
    --bg-color: #1a1a1a;
}
```

## JavaScript Architecture

### Module Pattern
All JS files use IIFE to avoid global scope pollution:
```javascript
(function() {
    'use strict';
    // Code here
})();
```

### Event Delegation
Uses event delegation for dynamic elements:
```javascript
$(document).on('click', '.selector', handler);
```

### Debouncing
Search input debounced to reduce server requests:
```javascript
clearTimeout(searchTimeout);
searchTimeout = setTimeout(performSearch, 300);
```

## Performance Optimizations

1. **Conditional Loading**
   - AJAX search only on shop pages
   - Product page JS only on product pages

2. **Debouncing**
   - Search input: 300ms delay
   - Prevents excessive AJAX calls

3. **CSS Transitions**
   - Hardware-accelerated transforms
   - Smooth 0.3s transitions

4. **Lazy Initialization**
   - Scripts wait for DOMContentLoaded
   - No blocking operations

## Responsive Design

### Breakpoints
- Mobile: < 480px
- Tablet: < 768px
- Desktop: > 768px

### Mobile Optimizations
- Single column layouts
- Scrollable tabs
- Touch-friendly buttons
- Reduced padding

## Browser Compatibility

- Modern browsers (ES6)
- CSS Grid support required
- CSS Custom Properties required
- localStorage API required

## Security

1. **Nonce Verification**
   - AJAX requests use nonces
   - Prevents CSRF attacks

2. **Sanitization**
   - All input sanitized
   - Output escaped

3. **Capability Checks**
   - Admin functions check permissions

## Extensibility

### Child Theme Support
All functions use filters/actions for modification:
```php
apply_filters('wintersnow_product_offers', $offers);
do_action('wintersnow_after_size_guide');
```

### Template Overrides
All templates can be overridden in child theme.

### CSS Custom Properties
Easy color scheme changes without touching CSS.

## Testing Checklist

### Functional Tests
- [ ] Dark mode toggle works
- [ ] Dark mode persists on reload
- [ ] Search returns results
- [ ] Search shows images and prices
- [ ] Festive badge appears on tagged products
- [ ] Countdown updates every second
- [ ] Promo bar dismisses and stays dismissed
- [ ] Size guide opens and closes
- [ ] Mini cart slides in on add to cart
- [ ] My Account tabs switch correctly
- [ ] Order badges show correct colors
- [ ] Checkout summary stays sticky

### Browser Tests
- [ ] Chrome
- [ ] Firefox
- [ ] Safari
- [ ] Edge
- [ ] Mobile Safari
- [ ] Chrome Mobile

### Responsive Tests
- [ ] Header layout on mobile
- [ ] Mega menu on tablet/mobile
- [ ] Product grid on mobile
- [ ] Checkout layout on mobile
- [ ] My Account tabs on mobile

### Accessibility Tests
- [ ] Keyboard navigation works
- [ ] Focus visible on interactive elements
- [ ] ARIA labels present
- [ ] Color contrast adequate
- [ ] Screen reader friendly

## Future Enhancements

1. **Wishlist Integration**
2. **Compare Products**
3. **Quick View Modal**
4. **Instagram Feed**
5. **Advanced Filters**
6. **Multi-currency Support**
7. **RTL Support**
8. **More Payment Gateways**

## Maintenance

### Regular Updates
- WordPress core
- WooCommerce plugin
- Elementor plugin
- PHP version

### Performance Monitoring
- Page load times
- AJAX response times
- JavaScript errors
- CSS render times

### Security Audits
- Regular security scans
- Plugin updates
- Code reviews
- Penetration testing
