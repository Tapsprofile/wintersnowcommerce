# WinterSnow Commerce - Installation Guide

## Table of Contents
1. [System Requirements](#system-requirements)
2. [WordPress Installation](#wordpress-installation)
3. [Plugin Installation](#plugin-installation)
4. [Product Import](#product-import)
5. [Elementor Template Setup](#elementor-template-setup)
6. [Size Guide Configuration](#size-guide-configuration)
7. [Review Import](#review-import)
8. [Final Configuration](#final-configuration)

## System Requirements

### Server Requirements
- **PHP Version:** 7.4 or higher (8.0+ recommended)
- **MySQL Version:** 5.6 or higher (8.0+ recommended)
- **WordPress Version:** 6.0 or higher
- **Memory Limit:** 256MB minimum (512MB recommended)
- **Max Execution Time:** 300 seconds
- **Upload File Size:** 64MB minimum

### Required Plugins
1. **WooCommerce** (7.0+) - Free
2. **Elementor** (3.10+) - Free
3. **Elementor Pro** (3.10+) - Premium ($49+/year)
4. **Unlimited Elements for Elementor** - Free/Pro

### Recommended Plugins
- **Yoast SEO** - For SEO optimization
- **WP Rocket** - For caching and performance
- **Wordfence** - For security

## WordPress Installation

### Step 1: Install WordPress

1. **Download WordPress:**
   ```bash
   wget https://wordpress.org/latest.zip
   unzip latest.zip
   ```

2. **Create Database:**
   ```sql
   CREATE DATABASE wintersnow_commerce;
   CREATE USER 'wintersnow_user'@'localhost' IDENTIFIED BY 'your_secure_password';
   GRANT ALL PRIVILEGES ON wintersnow_commerce.* TO 'wintersnow_user'@'localhost';
   FLUSH PRIVILEGES;
   ```

3. **Configure wp-config.php:**
   ```php
   define('DB_NAME', 'wintersnow_commerce');
   define('DB_USER', 'wintersnow_user');
   define('DB_PASSWORD', 'your_secure_password');
   define('DB_HOST', 'localhost');
   
   // Increase memory limit
   define('WP_MEMORY_LIMIT', '256M');
   define('WP_MAX_MEMORY_LIMIT', '512M');
   ```

4. **Run WordPress Installation:**
   - Navigate to your domain
   - Complete the 5-minute installation
   - Set up admin account

### Step 2: Initial WordPress Configuration

1. **Settings → General:**
   - Set Site Title: "WinterSnow Commerce"
   - Set Tagline: "Premium Winter Clothing & Accessories"
   - Set timezone

2. **Settings → Permalinks:**
   - Select "Post name" structure
   - This creates SEO-friendly URLs

3. **Settings → Reading:**
   - Set "A static page" as homepage
   - We'll create the homepage later

## Plugin Installation

### Step 3: Install Core Plugins

1. **Install WooCommerce:**
   ```
   Dashboard → Plugins → Add New
   Search: "WooCommerce"
   Install and Activate
   ```

2. **Run WooCommerce Setup Wizard:**
   - Store Details: Enter your store information
   - Industry: Fashion & Apparel
   - Product Types: Physical products
   - Business Details: Configure as needed
   - Theme: Skip (we'll use Elementor)
   - Skip Jetpack (optional)

3. **Install Elementor:**
   ```
   Dashboard → Plugins → Add New
   Search: "Elementor"
   Install and Activate both:
   - Elementor Page Builder
   - Elementor Pro (requires license key)
   ```

4. **Install Unlimited Elements:**
   ```
   Dashboard → Plugins → Add New
   Search: "Unlimited Elements"
   Install and Activate
   ```

### Step 4: Configure WooCommerce

1. **WooCommerce → Settings → General:**
   - Base Location: Your location
   - Currency: USD ($)
   - Currency Position: Left

2. **WooCommerce → Settings → Products:**
   - Shop Page: Create new page "Shop"
   - Enable reviews: ✓
   - Enable star ratings: ✓
   - Verified owner label: "Verified Purchase"

3. **WooCommerce → Settings → Inventory:**
   - Enable stock management: ✓
   - Low stock threshold: 5
   - Out of stock threshold: 0

4. **WooCommerce → Settings → Shipping:**
   - Add Shipping Zone: "Domestic"
   - Add shipping methods (Flat rate, Free shipping)
   - Free shipping minimum: $100

5. **WooCommerce → Settings → Payments:**
   - Enable payment methods you want to use
   - Configure payment gateways

## Product Import

### Step 5: Create Product Categories

1. **Navigate to Products → Categories**

2. **Create the following categories:**
   - Outerwear
   - Sweaters
   - Bottoms
   - Dresses
   - Jackets
   - T-Shirts
   - Basics
   - Hoodies
   - Casualwear
   - Blazers
   - Formal Wear
   - Accessories
   - Footwear
   - Winter Collection
   - Luxury Collection
   - Denim
   - Festive Collection

### Step 6: Create Product Tags

1. **Navigate to Products → Tags**

2. **Create the following tags:**
   - Festive (IMPORTANT - used for homepage grid)
   - Winter
   - Premium
   - Coat
   - Cashmere
   - Jeans
   - Denim
   - Classic
   - Party
   - Holiday
   - Evening Wear
   - Leather
   - Biker
   - Cotton
   - Basic
   - Everyday
   - Scarf
   - Accessories
   - Fleece
   - Hoodie
   - Casual
   - Blazer
   - Formal
   - Business
   - Boots
   - Waterproof

### Step 7: Create Product Attributes

1. **Navigate to Products → Attributes**

2. **Create "Size" attribute:**
   - Name: Size
   - Slug: size
   - Enable archives: ✓
   - Click "Add attribute"
   - Add terms: XS, S, M, L, XL, XXL

3. **Create "Color" attribute:**
   - Name: Color
   - Slug: color
   - Add terms based on products (Charcoal, Navy, Camel, Beige, Gray, Black, etc.)

4. **Create "Wash" attribute (for jeans):**
   - Name: Wash
   - Slug: wash
   - Add terms: Light Blue, Dark Blue, Black

### Step 8: Import Products

Use the data from `products/products-data.json` to create each product:

**Example: Winter Wool Coat**

1. **Navigate to Products → Add New**

2. **Basic Information:**
   - Product name: Winter Wool Coat
   - Description: Premium wool blend coat designed to keep you warm during the coldest winter days. Features a classic tailored fit with modern styling. Made from 80% wool and 20% polyester for durability and warmth.
   - Short description: Premium wool blend coat for ultimate winter warmth

3. **Product Data:**
   - Product type: Variable product
   - Regular price: $299.99
   - Sale price: $249.99
   - SKU: WWC-001
   - Stock status: In stock
   - Stock quantity: 50

4. **Attributes:**
   - Add attribute: Size (XS, S, M, L, XL, XXL) - Used for variations ✓
   - Add attribute: Color (Charcoal, Navy, Camel) - Used for variations ✓

5. **Variations:**
   - Create variations for each size/color combination
   - Set individual SKUs (e.g., WWC-001-XS-CH)
   - Set stock for each variation

6. **Categories:**
   - Outerwear
   - Winter Collection

7. **Tags:**
   - Winter, Coat, Premium

8. **Product Image:**
   - Upload or use placeholder image
   - Add gallery images

9. **Publish the product**

**Repeat for all 10 products** using data from `products-data.json`

**IMPORTANT:** Make sure to tag these products with "Festive":
- Festive Party Dress
- Wool Scarf
- Winter Boots

## Elementor Template Setup

### Step 9: Configure Elementor

1. **Navigate to Elementor → Settings**

2. **General Settings:**
   - Enable Flexbox Container: ✓
   - Enable improved CSS loading: ✓

3. **Experiments:**
   - Enable all stable features

### Step 10: Create Header Template

1. **Navigate to Elementor → Theme Builder → Header**

2. **Click "Add New"**

3. **Use configuration from `elementor-templates/header-template.json`:**

   **Section 1: Floating Bar**
   - Add Section
   - Add Text widget: "🎉 Flat 20% OFF — Code: FESTIVE20"
   - Background: #d32f2f (red)
   - Text color: White
   - Position: Sticky at top

   **Section 2: Main Header**
   - Add 3-column section
   - Column 1: Site Logo widget
   - Column 2: Search widget (Unlimited Elements - Woo AJAX Search)
     - Enable: Show product image ✓
     - Enable: Show product price ✓
   - Column 3: Dark Mode Toggle widget (Unlimited Elements)

   **Section 3: Navigation**
   - Add Nav Menu widget
   - Create Main Navigation menu
   - Enable Mega Menu for "Festive Specials" and "New In"

4. **Set Display Conditions:**
   - Include: Entire Site

5. **Publish Template**

### Step 11: Create Single Product Template

1. **Navigate to Elementor → Theme Builder → Single Product**

2. **Click "Add New"**

3. **Build template using `elementor-templates/single-product-template.json`:**

   **Main Product Section (2 columns):**
   - Left: Product Images widget
   - Right: 
     - Product Title
     - Product Rating
     - Product Price
     - Icon List (offers)
     - Product Short Description
     - Add to Cart
     - **Size Guide Button** (Link to Popup)
     - Product Meta

   **Reviews Section:**
   - Product Reviews widget
   - Skin: Card
   - Enable verified badge

4. **Create Size Guide Popup:**
   - Elementor → Theme Builder → Popups → Add New
   - Add Table widget with dynamic size guide data
   - Set trigger: Click on Size Guide button
   - Save as "Size Guide Popup"

5. **Set Display Conditions:**
   - Include: All Products

6. **Publish Template**

### Step 12: Create Homepage

1. **Create New Page: "Home"**

2. **Edit with Elementor**

3. **Build using `elementor-templates/homepage-template.json`:**

   **Hero Section:**
   - Add Hero Slider with 3 slides

   **Countdown Section:**
   - Heading: "🎄 Festive Sale Ends Soon!"
   - Countdown Timer widget
   - Set end date

   **Festive Products Grid:**
   - Add Loop Grid widget
   - Query: Include by Term → Festive (tag)
   - Columns: 3
   - Show product badges

   **Categories Section:**
   - Category Grid
   - Show all product categories

   **New Arrivals:**
   - Products widget
   - Order by: Date (newest first)

4. **Publish Page**

5. **Set as Homepage:**
   - Settings → Reading → Static Page → Home

### Step 13: Create Cart & Checkout Templates

1. **Configure Mini Cart:**
   - Elementor → Site Settings → WooCommerce → Mini Cart
   - Enable slide-out cart
   - Make checkout button larger and more prominent

2. **Create Checkout Template:**
   - Pages → Checkout → Edit with Elementor
   - 2-column layout (60/40)
   - Left: Billing/Shipping forms
   - Right: Order Summary (sticky)

### Step 14: Create My Account Template

1. **Navigate to Elementor → Theme Builder → My Account**

2. **Use My Account widget:**
   - Layout: Horizontal Tabs
   - Tab style: Modern

3. **Configure Orders Tab:**
   - Add custom CSS for status badges:
   ```css
   .order-status.processing {
     background: #ff9800;
     color: white;
     padding: 5px 10px;
     border-radius: 4px;
   }
   .order-status.shipped {
     background: #2196f3;
   }
   .order-status.delivered {
     background: #4caf50;
   }
   ```

4. **Publish Template**

## Size Guide Configuration

### Step 15: Create Size Guide Popups

For each product category, create a size guide popup:

1. **Create Popup: "Size Guide - Tops"**
   - Use data from `size-guides/size-guide-data.json`
   - Add Table widget with measurements
   - Add "How to Measure" accordion

2. **Create Popup: "Size Guide - Bottoms"**
   - Similar to above, with bottoms data

3. **Create Popup: "Size Guide - Outerwear"**
   - With outerwear measurements

4. **Continue for all categories:**
   - Dresses
   - Footwear
   - Accessories (one size note)

### Step 16: Link Size Guides to Products

For each product:
1. Edit product page template
2. Set Size Guide button popup based on product category
3. Use conditional logic if needed

## Review Import

### Step 17: Add Product Reviews

For each product, use data from `reviews/product-reviews.json`:

**Manual Method:**
1. Navigate to product in admin
2. Scroll to Reviews section
3. Click "Add review"
4. Enter reviewer name, rating, title, and review text
5. Check "Verified purchase" if applicable
6. Set review date

**Programmatic Method (Advanced):**
Create a simple import script using WooCommerce API or WordPress functions.

## Final Configuration

### Step 18: Configure Dark Mode

1. **Customize Dark Mode Toggle:**
   - Edit Header template
   - Style sun/moon icons to match brand
   - Test color transitions

2. **Set CSS Variables:**
   ```css
   :root {
     --search-bg: #f5f5f5;
     --search-text: #333333;
   }
   
   [data-theme="dark"] {
     --search-bg: #2d2d2d;
     --search-text: #ffffff;
   }
   ```

### Step 19: Test All Features

Run through the complete testing checklist:
- [ ] Dark mode toggle works
- [ ] Search shows images and prices
- [ ] Mega menu displays correctly
- [ ] All products visible and purchasable
- [ ] Size guides open in popups
- [ ] Reviews display correctly
- [ ] Cart slides out properly
- [ ] Checkout is functional
- [ ] My Account tabs work
- [ ] Order status badges visible

### Step 20: Performance Optimization

1. **Install Caching Plugin:**
   - WP Rocket or similar
   - Enable page caching
   - Minify CSS/JS

2. **Optimize Images:**
   - Use WebP format
   - Compress images
   - Enable lazy loading

3. **Configure CDN:**
   - Optional but recommended
   - Cloudflare or similar

### Step 21: Security Configuration

1. **Install Security Plugin:**
   - Wordfence or similar
   - Enable firewall
   - Enable malware scanning

2. **SSL Certificate:**
   - Install SSL certificate
   - Force HTTPS
   - Update WooCommerce settings

3. **Backup Configuration:**
   - Set up automated backups
   - UpdraftPlus or similar
   - Daily backups recommended

## Post-Launch Checklist

- [ ] All products imported and visible
- [ ] All reviews added
- [ ] Size guides functional
- [ ] Payment gateways configured
- [ ] Shipping methods set up
- [ ] Email notifications working
- [ ] SSL certificate installed
- [ ] Analytics tracking configured (Google Analytics)
- [ ] SEO settings configured
- [ ] Backup system in place
- [ ] Security measures implemented
- [ ] Performance optimized
- [ ] Mobile responsiveness tested
- [ ] Cross-browser testing completed

## Troubleshooting

### Common Issues

**Products not showing:**
- Check product visibility settings
- Ensure products are published
- Check stock status

**Size guide popup not opening:**
- Verify Elementor Pro is active
- Check popup conditions
- Clear cache

**Dark mode not switching:**
- Verify Unlimited Elements is active
- Check widget settings
- Clear browser cache

**Reviews not displaying:**
- Enable reviews in WooCommerce settings
- Check product review settings
- Verify reviews are approved

## Support Resources

- [WooCommerce Documentation](https://woocommerce.com/documentation/)
- [Elementor Documentation](https://elementor.com/help/)
- [WordPress Support](https://wordpress.org/support/)

## Next Steps

After installation:
1. Add real product images
2. Configure payment processors
3. Set up shipping rates
4. Configure email templates
5. Add legal pages (Privacy Policy, Terms of Service)
6. Set up Google Analytics
7. Launch marketing campaigns

---

**Installation Time Estimate:** 6-8 hours for complete setup

**Difficulty Level:** Intermediate

**Required Skills:** WordPress administration, basic PHP knowledge helpful

For questions or issues, please refer to the main README or open an issue in the repository.
