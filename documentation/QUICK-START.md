# WinterSnow Commerce - Quick Start Guide

Get your WinterSnow Commerce store up and running in under 2 hours!

## 🚀 30-Minute Quick Start

### Step 1: Install WordPress (5 minutes)
1. Download WordPress from wordpress.org
2. Upload to your hosting
3. Run installation wizard
4. Create admin account

### Step 2: Install Essential Plugins (10 minutes)
```
Dashboard → Plugins → Add New

Install in this order:
1. WooCommerce
2. Elementor
3. Elementor Pro (requires license)
4. Unlimited Elements
```

### Step 3: Configure WooCommerce (10 minutes)
Run the WooCommerce setup wizard:
- Store location: Your country
- Currency: USD
- Products: Physical products
- Theme: Skip (we'll use Elementor)

**Quick Settings:**
```
WooCommerce → Settings → Products:
✓ Enable reviews
✓ Show star ratings
✓ "Verified Purchase" label

WooCommerce → Settings → Shipping:
Add Zone: Domestic
Method: Free shipping ($100 minimum)
Method: Flat rate ($10)
```

### Step 4: Create Categories & Tags (5 minutes)
```
Products → Categories
Add: Outerwear, Sweaters, Bottoms, Dresses, Accessories, Footwear, 
     Winter Collection, Festive Collection, Luxury Collection

Products → Tags
Add: Festive, Winter, Premium
```

**IMPORTANT:** Create "Festive" tag for homepage grid!

## 📦 1-Hour Product Import

### Quick Product Creation
Use the CSV file for fastest import:

```
Products → Import
Choose file: products/products-import.csv
Map columns automatically
Run Importer
```

**Manual Alternative:** Create products one-by-one using `products/products-data.json`

### Add Product Reviews
For each product, add 3-5 reviews from `reviews/product-reviews.json`:

```
Products → [Product Name] → Edit
Scroll to Reviews section
Add review with:
- Name
- Rating (stars)
- Title
- Review text
✓ Verified purchase
```

**Time Saver:** Focus on the festive products first (Party Dress, Scarf, Boots)

## 🎨 1-Hour Template Setup

### Priority Templates (Build These First)

**1. Header (15 minutes)**
```
Elementor → Theme Builder → Header → Add New

Add Sections:
1. Floating Bar: "🎉 Flat 20% OFF — Code: FESTIVE20"
2. Logo | AJAX Search | Dark Mode Toggle
3. Navigation Menu

Save & Publish
```

**2. Single Product Page (20 minutes)**
```
Elementor → Theme Builder → Single Product → Add New

Layout:
Left: Product Images
Right: Title, Price, Add to Cart, Size Guide Button

Bottom: Reviews (Card skin)

Create Size Guide Popup:
Elementor → Popups → Add New
Add table widget with size data

Save & Publish
```

**3. Homepage (15 minutes)**
```
Pages → Add New → "Home"
Edit with Elementor

Add:
- Hero section
- Countdown timer
- Loop Grid (Query: Tag = Festive)
- Categories grid

Set as homepage:
Settings → Reading → Static Page → Home
```

**4. Mini Cart (10 minutes)**
```
Elementor → Site Settings → WooCommerce

Enable: Mini Cart
Style: Slide-out
Position: Right
Checkout button: Large, Primary

Save
```

## ✅ 15-Minute Essential Tests

### Must-Test Features
1. **Dark Mode:** Click toggle → Search bar changes color ✓
2. **Search:** Type "coat" → Shows image & price ✓
3. **Add to Cart:** Select size → Add to cart works ✓
4. **Size Guide:** Click button → Popup opens ✓
5. **Checkout:** Complete test order ✓

## 🎯 2-Hour Complete Setup Timeline

| Time | Task | Duration |
|------|------|----------|
| 0:00 | Install WordPress | 5 min |
| 0:05 | Install plugins | 10 min |
| 0:15 | Configure WooCommerce | 10 min |
| 0:25 | Create categories/tags | 5 min |
| 0:30 | Import/create products | 60 min |
| 1:30 | Build templates | 60 min |
| 2:30 | Test features | 15 min |
| 2:45 | **LIVE!** | ✓ |

## 🔧 Essential Shortcuts

### WooCommerce Quick Settings
Copy and paste these settings:

```
General:
- Currency: $ USD
- Position: Left

Products:
- Reviews: Enabled
- Star ratings: Show
- Verified: "Verified Purchase"

Shipping:
- Free shipping: $100+
- Flat rate: $10

Tax:
- Disable if not needed
```

### Elementor Quick Shortcuts
```
Keyboard Shortcuts:
Ctrl/Cmd + S = Save
Ctrl/Cmd + Shift + L = Library
Ctrl/Cmd + Shift + K = Color Picker
Ctrl/Cmd + D = Duplicate
Ctrl/Cmd + Shift + V = Paste Style
```

### CSS Variables (Copy to Site Settings)
```css
:root {
  --primary-color: #333333;
  --accent-color: #d32f2f;
  --search-bg: #f5f5f5;
  --search-text: #333333;
}

[data-theme="dark"] {
  --search-bg: #2d2d2d;
  --search-text: #ffffff;
}
```

## 📋 Quick Checklist

### Before Launch
- [ ] SSL certificate installed
- [ ] All 10 products visible
- [ ] 3 festive products tagged
- [ ] Reviews added (at least festive products)
- [ ] Header has dark mode toggle
- [ ] Search shows images
- [ ] Size guides work
- [ ] Mini cart slides out
- [ ] Test checkout completes

### Day 1 After Launch
- [ ] Monitor orders
- [ ] Check email notifications
- [ ] Test on mobile
- [ ] Share on social media
- [ ] Set up Google Analytics

## 🆘 Quick Fixes

### Problem: Products not showing
**Fix:** Products → View → Show all statuses → Publish

### Problem: Reviews not visible
**Fix:** Settings → Discussion → Enable comments

### Problem: Checkout errors
**Fix:** Flush permalinks → Settings → Permalinks → Save

### Problem: Images not loading
**Fix:** Settings → Media → Regenerate thumbnails

### Problem: Slow site
**Fix:** Install WP Rocket → Enable caching

## 💡 Pro Tips

### Tip 1: Test with Real Orders
Create a test account and place real orders to ensure everything works.

### Tip 2: Use Staging Site
Test everything on a staging site before pushing to live.

### Tip 3: Backup Before Changes
Always backup before making major changes.

### Tip 4: Mobile First
Test on mobile devices - 60%+ of traffic is mobile.

### Tip 5: Clear Cache Often
Clear all caches (browser, plugin, server) when testing changes.

## 📞 Quick Support

### Common Questions

**Q: Do I need all 10 products to launch?**
A: No, start with 3 festive products to test the system.

**Q: Can I use different products?**
A: Yes! Use the data structure as a template for your products.

**Q: Is Elementor Pro required?**
A: Yes, for Theme Builder and WooCommerce widgets.

**Q: How do I add more reviews?**
A: Products → [Product] → Reviews → Add review

**Q: Can I change the colors?**
A: Yes! Elementor → Site Settings → Global Colors

## 🎉 Launch Checklist

Ready to go live? Complete this final checklist:

### Technical
- [ ] SSL certificate active (https://)
- [ ] Backups configured
- [ ] Security plugin active
- [ ] Analytics tracking set up
- [ ] Error reporting disabled

### Content
- [ ] All product images uploaded
- [ ] Product descriptions complete
- [ ] Legal pages added (Privacy, Terms)
- [ ] Contact page created
- [ ] About page created

### WooCommerce
- [ ] Payment gateway tested
- [ ] Test order completed
- [ ] Email notifications working
- [ ] Shipping calculated correctly
- [ ] Tax settings correct

### Marketing
- [ ] Social media profiles linked
- [ ] Newsletter signup working
- [ ] Promotional codes active
- [ ] Share buttons added
- [ ] SEO basics done

## 🚀 Post-Launch

### Week 1
- Monitor daily sales
- Respond to customer questions
- Fix any bugs quickly
- Gather customer feedback

### Month 1
- Review analytics
- Optimize slow pages
- Add more products
- Run first promotion

### Ongoing
- Update products monthly
- Add new reviews
- Refresh homepage content
- Monitor security scans

---

## Need More Time?

### Extended Timeline (Recommended)
- **Day 1:** WordPress + WooCommerce setup
- **Day 2:** Product import + configuration
- **Day 3:** Template building
- **Day 4:** Testing + refinement
- **Day 5:** Content + final checks
- **Day 6:** Launch! 🎉

### Next Steps
1. Read full [INSTALLATION.md](INSTALLATION.md) guide
2. Review [FEATURES.md](FEATURES.md) documentation
3. Complete [TESTING-CHECKLIST.md](TESTING-CHECKLIST.md)

---

**You've got this! 💪**

**Estimated Total Time:** 2-3 hours for basic setup, 1-2 days for complete implementation.

**Questions?** Check the documentation or open an issue in the repository.

**Last Updated:** February 2026
