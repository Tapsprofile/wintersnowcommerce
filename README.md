# WinterSnow Commerce Theme

A high-conversion WooCommerce theme built with Elementor integration, featuring dark mode, AJAX search, festive offers, and optimized checkout flow.

## Features

### Phase 1: Global Header (Search, Theme & Navigation)

#### Dark/Light Mode Toggle
- Automatic system preference detection
- Manual override capability
- Smooth transitions between themes
- Persistent user preference (localStorage)

#### Intelligent AJAX Search
- Real-time product search
- Results display product image and price
- Debounced search (300ms delay)
- Keyboard navigation support

#### Mega Menu
- Nested element support
- 3-column dropdown layout
- Category organization
- Responsive design

### Phase 2: Festive & Offers Layer

#### Festive Product Tagging
- Custom taxonomy for festive products
- Visual badges on product images
- Loop grid query filtering
- Easy management from admin panel

#### Countdown Timer
- Customizable end date
- Days, hours, minutes, seconds display
- Automatic expiration handling
- Multiple timer support on single page

#### Floating Promotional Bar
- Sticky top position
- Dismissible with localStorage persistence
- Prominent coupon code display
- Eye-catching gradient background

### Phase 3: High-Conversion Product Page

#### Price & Offers Display
- Prominent price display
- Icon-based offers list
- Bulk buy discounts
- Free delivery threshold
- Money-back guarantee badge

#### Size Guide Modal
- Instant popup (no page reload)
- Comprehensive size table
- Keyboard accessible (Esc to close)
- Click-outside to close

#### Product Reviews
- Card-style layout
- Star ratings
- Author and date display
- Modern, clean design

### Phase 4: Logistics & Retention

#### Slide-Out Mini Cart
- Right-side overlay
- Large checkout button
- Smaller view cart link
- Automatic display on add-to-cart

#### My Account - Horizontal Tabs
- Dashboard
- My Orders with status badges
- Downloads
- Addresses
- Account details
- Mobile-optimized

#### Order Status Badges
- Processing (orange)
- Shipped (blue)
- Delivered (green)
- Cancelled (red)
- Clear visual indicators

#### 2-Column Checkout
- Left: Billing & shipping forms
- Right: Sticky order summary
- Simplified fields
- Always-visible total

## Installation

1. **Prerequisites**
   - WordPress 5.8 or higher
   - PHP 7.4 or higher
   - WooCommerce plugin
   - Elementor Page Builder (Free or Pro)

2. **Install Theme**
   ```bash
   # Upload theme to WordPress themes directory
   wp-content/themes/wintersnow-commerce/
   ```

3. **Activate Theme**
   - Go to Appearance > Themes
   - Click "Activate" on WinterSnow Commerce

4. **Configure WooCommerce**
   - Complete WooCommerce setup wizard
   - Configure payment gateways
   - Set up shipping zones

5. **Elementor Configuration**
   - Install Elementor plugin
   - Create templates for header, footer, and product pages
   - Use Theme Builder for WooCommerce templates

## Quality Assurance Checklist

- [ ] **Dark Mode Test**: Search bar background changes correctly
- [ ] **Size Guide Test**: Popup opens instantly without page reload
- [ ] **Festive Grid Test**: Special offer badges visible on products
- [ ] **Mobile Test**: My Orders clearly visible on mobile devices
- [ ] **Cart Test**: Mini cart slides out on add-to-cart
- [ ] **Checkout Test**: Order summary stays visible when scrolling
- [ ] **Search Test**: Results show product images and prices
- [ ] **Countdown Test**: Timer updates every second

## Documentation

- See [IMPLEMENTATION.md](IMPLEMENTATION.md) for detailed technical documentation
- See inline code comments for specific implementation details

## License

GNU General Public License v2 or later

## Support

For issues and questions, please open an issue on GitHub.