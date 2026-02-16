# WooCommerce Configuration Settings for WinterSnow Commerce

## General Settings

### Store Details
```
WooCommerce → Settings → General

Store Address: [Your Street Address]
City: [Your City]
Country / State: [Your Country]
Postcode / ZIP: [Your ZIP]
```

### Currency Options
```
Currency: US Dollar ($)
Currency Position: Left
Thousand Separator: ,
Decimal Separator: .
Number of Decimals: 2
```

## Product Settings

### General Product Options
```
WooCommerce → Settings → Products → General

Shop Page: [Select "Shop" page]
Add to cart behaviour:
  ☐ Redirect to cart page after successful addition
  ☐ Enable AJAX add to cart buttons on archives

Placeholder Image: [Upload default product image]
```

### Inventory Settings
```
WooCommerce → Settings → Products → Inventory

Manage Stock: ✓ Enable stock management
Hold Stock (minutes): 60
Notifications:
  ✓ Enable low stock notifications
  Low stock threshold: 5
  ✓ Enable out of stock notifications
  Out of stock threshold: 0

Stock Display:
  ☐ Hide out of stock items from the catalog
```

### Review Settings
```
Enable Reviews: ✓
Show "verified owner" label: ✓
Reviews can only be left by "verified owners": ☐
Star ratings should be required: ✓
```

### Download Settings
```
File Download Method: X-Accel-Redirect/X-Sendfile
Access Restriction: Downloads require login
Grant Access: ✓ Grant access to downloadable products after payment
```

## Shipping Settings

### Shipping Zones

**Zone 1: Domestic (United States)**
```
WooCommerce → Settings → Shipping → Add Shipping Zone

Zone Name: Domestic Shipping
Regions: United States

Shipping Methods:
1. Free Shipping
   - Minimum order amount: $100.00
   - Requires: A minimum order amount

2. Flat Rate
   - Cost: $10.00
   - Tax status: Taxable
```

**Zone 2: International**
```
Zone Name: International Shipping
Regions: Select countries you ship to

Shipping Methods:
1. Flat Rate
   - Cost: $25.00
   - Tax status: Taxable
```

### Shipping Options
```
Shipping Calculations:
  ✓ Enable the shipping calculator on the cart page
  ☐ Hide shipping costs until an address is entered

Shipping Destination:
  ○ Default to customer shipping address
  ● Default to customer billing address
  ○ Force shipping to the customer billing address
```

## Payment Settings

### Payment Gateways

**1. Direct Bank Transfer**
```
Enable: ✓
Title: Direct Bank Transfer
Description: Make your payment directly into our bank account.
Instructions: [Add your bank details here]
```

**2. Check Payments**
```
Enable: ☐ (Disabled by default)
Title: Check Payments
Description: Please send a check to Store Name, Store Street, Store Town, Store State, Store Postcode.
```

**3. Cash on Delivery**
```
Enable: ☐ (Optional)
Title: Cash on Delivery
Description: Pay with cash upon delivery.
```

**Note:** For production, integrate real payment gateways:
- Stripe
- PayPal
- Square
- Authorize.Net

## Tax Settings

### Standard Tax Rates
```
WooCommerce → Settings → Tax

Enable Taxes: ✓ (if applicable in your region)

Tax Options:
  Prices entered with tax: ● Exclusive of tax
  Calculate tax based on: ● Customer billing address
  Shipping tax class: ● Based on cart items
  Rounding: ☐ Round tax at subtotal level
  Additional tax classes: Reduced rate, Zero rate

Display Prices:
  Display prices in the shop: ● Including tax
  Display prices during cart/checkout: ● Including tax
  Display tax totals: ● As a single total
```

### Standard Tax Rates (Example for US)
```
Country Code: US
State Code: * (for all states)
Postcode / ZIP: 
City: 
Rate %: 0.00 (Varies by state - update as needed)
Tax Name: Sales Tax
Priority: 1
Compound: ☐
Shipping: ✓ (if applicable)
```

## Account & Privacy Settings

### Account Options
```
WooCommerce → Settings → Accounts & Privacy

Guest Checkout:
  ✓ Allow customers to place orders without an account
  ✓ Allow customers to log into an existing account during checkout

Account Creation:
  ✓ Allow customers to create an account during checkout
  ✓ Allow customers to create an account on the "My account" page
  ☐ Automatically create accounts for customers

Account Erasure Requests:
  ☐ Remove personal data from orders (Recommended: Leave unchecked)
  ☐ Remove access to downloads

Privacy Policy:
  Privacy Policy Page: [Select your privacy policy page]
```

## Email Settings

### Email Sender Options
```
WooCommerce → Settings → Emails

"From" name: WinterSnow Commerce
"From" email address: orders@yourstore.com

Email Template:
  Header image: [Upload logo, recommended 600px wide]
  Footer text: WinterSnow Commerce - Premium Winter Clothing & Accessories
  Base color: #333333
  Background color: #f5f5f5
  Body background color: #ffffff
  Body text color: #333333
```

### Enabled Emails
```
✓ New Order (to admin)
✓ Cancelled Order (to admin)
✓ Failed Order (to admin)
✓ Order On-Hold (to customer)
✓ Processing Order (to customer)
✓ Completed Order (to customer)
✓ Refunded Order (to customer)
✓ Customer Invoice (to customer)
✓ Customer Note (to customer)
✓ Customer Reset Password (to customer)
✓ Customer New Account (to customer)
```

### Email Customization (New Order)
```
Recipients: your-email@yourstore.com
Subject: [WinterSnow] New order #{order_number}
Email Heading: New Order
✓ Enable this email notification
```

### Email Customization (Order Completed)
```
Subject: Your order on WinterSnow Commerce is complete
Email Heading: Thank you for your purchase!
✓ Enable this email notification
Additional content: Thank you for shopping with WinterSnow Commerce. Your order has been shipped and should arrive within 5-7 business days.
```

## Advanced Settings

### Page Setup
```
WooCommerce → Settings → Advanced → Page Setup

Cart Page: [Select "Cart" page]
Checkout Page: [Select "Checkout" page]
My Account Page: [Select "My Account" page]
Terms and Conditions: [Select your T&C page]
```

### Checkout Endpoints
```
Pay: order-pay
Order Received: order-received
Add Payment Method: add-payment-method
Delete Payment Method: delete-payment-method
Set Default Payment Method: set-default-payment-method
```

### Account Endpoints
```
Orders: orders
View Order: view-order
Downloads: downloads
Edit Account: edit-account
Addresses: edit-address
Payment Methods: payment-methods
Lost Password: lost-password
Logout: customer-logout
```

### REST API
```
Enable the REST API: ✓
```

### Webhooks
```
(Configure as needed for integrations)
```

## Additional WooCommerce Extensions

### Recommended Settings for Extensions

**WooCommerce PDF Invoices**
```
Invoice Number Format: {order_number}
Next Invoice Number: 1
Invoice Date Format: F j, Y
```

**YITH WooCommerce Wishlist**
```
Wishlist Page: [Create "Wishlist" page]
Add to Wishlist Text: Add to Wishlist
Show on: Single Product Page
Position: After Add to Cart
```

## Performance Settings

### Geolocation
```
WooCommerce → Settings → General

Default Customer Location: Shop base address
(Recommended for better performance than geolocation)
```

### Background Processing
```
Enable background processing: ✓
(Recommended for better checkout performance)
```

## Security Settings

### Checkout Security
```
Force secure checkout: ✓ (if SSL is enabled)
Force HTTP when leaving checkout: ☐
```

### Account Security
```
Minimum password strength: 3 (Strong)
Require strong passwords: ✓
```

## Coupon Settings

### Create "FESTIVE20" Coupon
```
WooCommerce → Marketing → Coupons → Add Coupon

Coupon Code: FESTIVE20
Description: Festive Season Discount

General:
  Discount Type: Percentage discount
  Coupon Amount: 20
  ✓ Allow free shipping
  Coupon expiry date: [Set to end of festive season]

Usage Restriction:
  Minimum spend: 50 (optional)
  Maximum spend: 
  Individual use only: ☐
  Exclude sale items: ☐

Usage Limits:
  Usage limit per coupon: 
  Usage limit per user: 1
  ✓ Limit usage to X items: [leave blank for unlimited]
```

### Additional Promotional Coupons (Optional)
```
WELCOME10 - 10% off first order
BULK10 - 10% off on 3+ items
FREESHIP - Free shipping on any order
```

## Notification Settings

### Stock Email Notifications
```
Low Stock Email Recipients: inventory@yourstore.com
Out of Stock Email Recipients: inventory@yourstore.com
```

### Review Notifications
```
Review Moderation Email: reviews@yourstore.com
```

## Import/Export Settings

### Product Import Settings
```
WooCommerce → Products → Import

Update existing products: ✓
Skip unknown products: ☐
```

## Recommended Third-Party Integrations

### Google Analytics Enhanced Ecommerce
```
Track:
  - Product impressions
  - Product clicks
  - Add to cart
  - Remove from cart
  - Checkout steps
  - Purchases
  - Refunds
```

### Facebook Pixel
```
Events to track:
  - ViewContent
  - AddToCart
  - InitiateCheckout
  - Purchase
```

## Maintenance Mode Settings

### Before Launch
```
WP Maintenance Mode Plugin:
  ✓ Enable maintenance mode
  Countdown to launch date
  Show "Coming Soon" page
```

### After Launch
```
☐ Disable maintenance mode
✓ Enable search engine visibility
  Settings → Reading → ✓ Discourage search engines (UNCHECK THIS)
```

## Backup Settings

### Automated Backups
```
UpdraftPlus Settings:
  Backup Schedule: Daily
  Include in backup: ✓ Database, ✓ Files
  Remote Storage: [Configure cloud storage]
  Retention: Keep last 30 backups
```

## Testing Configuration

### Test Mode Settings (Before Launch)
```
Payment Gateways: Set to TEST/SANDBOX mode
Email: Test all email templates
Tax Calculations: Verify with test orders
Shipping: Test all shipping calculations
Coupons: Verify all discounts apply correctly
```

## Go-Live Checklist

- [ ] Switch payment gateways from TEST to LIVE mode
- [ ] Verify SSL certificate is active
- [ ] Test complete checkout process
- [ ] Confirm email notifications working
- [ ] Verify tax calculations
- [ ] Test shipping methods
- [ ] Enable search engine visibility
- [ ] Disable maintenance mode
- [ ] Place test order and complete full cycle
- [ ] Monitor error logs for 24 hours

---

**Configuration Version:** 1.0.0  
**Last Updated:** February 2026  
**Compatible with:** WooCommerce 7.0+

**Note:** Always backup your database before changing settings.
