# wintersnowcommerce

## Plugin status

| Software/Plugin     | Role                                      | Status       |
| ------------------- | ----------------------------------------- | ------------ |
| Blonwe Core         | Size Guides, Quick View, Wishlist, Mobile Menu | Ready        |
| WooCommerce 10.4    | Store Management & Orders                 | Update Req.  |
| Variation Swatches  | Visual Attribute Choices (Color/Image)    | Ready        |
| Back In Stock       | Missing Sales Recovery                    | Install Req. |
| Elementor           | Custom Landing Pages                      | Ready        |
| Slider Revolution   | High-end Banners (Optimized)              | Ready        |
| SupportCandy        | Private Support (Buyer Bridge)            | Ready        |

## Senior Architect and Business Analyst roadmap

This roadmap transforms a fresh Ubuntu 22.04 box into a high-availability
fashion enterprise. It balances technical performance, customer support,
and risk management.

### 1) Infrastructure Layer: the "LEMP" foundation

- OS: Ubuntu 22.04 LTS (security patches until 2027/2032).
- Web Server: Nginx (optimized with FastCGI caching for high-res imagery).
- Database: MariaDB 10.11+ (more performant than standard MySQL for WooCommerce).
- Engine: PHP 8.2 or 8.3 (modules: php-fpm, php-imagick, php-redis).
- Accelerator: Redis object caching for instant product filters.

### 2) Management and DevOps Layer (the analyst's choice)

- Command Center: WP-CLI for bulk updates and scripted ops.
- Firewall: UFW + Fail2Ban to auto-block brute-force login attempts.
- SSL/Security: Certbot (Lets Encrypt) for automated $0 cost SSL.
- Version Control: Git for staged deployments (never edit live server).

### 3) Alerting and Monitoring (the zero-downtime system)

- Real-time Monitoring: Netdata for per-second CPU, RAM, Nginx health.
- Alerting Bot: Uptime Kuma (deploy on a separate $5 box or Docker).
  - Pings every 60 seconds.
  - Alert to Telegram or Slack.
- Log Management: GoAccess for a visual traffic dashboard.

### 4) Support Ticket Management (customer experience)

- Recommended: FreeScout (open-source Help Scout clone).
- Alternative: osTicket.
- Private support: SupportCandy (in-dashboard support inside WordPress).
- Deploy on support subdomain (support.yourbrand.com) on the same server.

### 5) Final Senior Architect review and checklist

| Feature            | Requirement         | Recommended Tool                |
| ------------------ | ------------------- | ------------------------------- |
| Speed              | Load time < 2s       | Nginx + Redis + WebP images     |
| Security           | PCI compliance       | Fail2Ban + SSL + non-std SSH    |
| Reliability        | 99.9% uptime         | Uptime Kuma + automated backups |
| Business intel     | User analytics       | GoAccess (server-side)          |
| Scalability        | Handle "drops"       | FastCGI cache (Nginx)           |

### Immediate implementation order

1. Update OS: `sudo apt update && sudo apt upgrade -y`
2. Secure SSH: change default port 22 to a non-standard port (ex: 2299).
3. Install LEMP: Nginx, MariaDB, PHP.
4. Install Uptime Kuma: first business alerting tool.
5. Deploy WordPress/WooCommerce: use the Blonwe setup below.

## Automation coverage in this repo

### What the Ansible setup does

- Installs Nginx, MariaDB, PHP-FPM, and required PHP modules
  (imagick, redis, mysql, xml, mbstring, zip, intl, bcmath, soap).
- Installs WordPress + WooCommerce, Elementor, Variation Swatches,
  Back In Stock notifier, and SupportCandy.
- Deploys and activates the custom **Winter Snow Storefront** plugin
  (layered ecommerce header, offers section, product cards, and styled footer).
- Configures Nginx vhost and optional FastCGI cache.
- Installs and configures Redis object cache (optional).
- Installs and configures UFW + Fail2Ban (optional).
- Installs Netdata and GoAccess (optional).
- Installs Certbot and can request SSL certificates (optional).

### Custom storefront layout included

The provisioning now deploys a local plugin from:

```
provision/files/winter-snow-storefront
```

Key UX and merchandising behaviors:

- 4-layer header:
  1. Flashing offer ticker
  2. Utility strip (Order Tracking, language, currency message row)
  3. Toggle menu + brand + product search + favorites/cart icons
  4. "All Categories" row with primary navigation
- Hero section with category rail + high-visibility collection CTA
- "Deal of the Week" urgency block with countdown timer
- Product grid rendering at least 10 designs for deep-scroll shopping
- Automated data seed: 12 WooCommerce products and minimum 10 reviews per product
- Footer structure matching newsletter/support + multi-column links pattern

On activation, the plugin creates:

- `Winter Snow Home` page with shortcode `[wss_storefront_homepage]`
- `Order Tracking` page with shortcode `[woocommerce_order_tracking]`
- Front page assignment to `Winter Snow Home`

### What is manual or recommended on a separate host

- Uptime Kuma deployment (best on a separate low-cost box).
- FreeScout or osTicket support desk (use a support subdomain).
- SupportCandy private support desk (WordPress plugin).
- Premium plugins (Blonwe Core, Slider Revolution) must be uploaded manually.
- Fashion template import via Starter Templates (from wp-admin).

## One-click provisioning (Ubuntu 22.04)

This repo includes an Ansible-based setup to install the fashion-ready stack.

### 1) Configure variables

Edit the provisioning variables before running the setup:

```
provision/group_vars/all.yml
```

Key items to review:

- `site_domain`, `site_server_name`, `site_root`
- `wp_site_url`, `wp_admin_user`, `wp_admin_password`, `wp_admin_email`
- `db_name`, `db_user`, `db_password`
- `php_version` (8.2/8.3 require `enable_ondrej_php_ppa: true`)
- `enable_fastcgi_cache`, `enable_redis`, `enable_firewall`
- `enable_certbot` and `certbot_domains` if DNS is ready

### 2) Run the setup

```
sudo bash setup.sh
```

### 3) Finish the fashion template import

The playbook installs the Astra theme and the Starter Templates plugin.
Log in to `/wp-admin`, open **Appearance → Starter Templates**, and import
the fashion template you want.

## Variables reference (quick view)

| Variable                    | Purpose                                  | Default |
| --------------------------- | ---------------------------------------- | ------- |
| `php_version`               | PHP engine version                       | 8.1     |
| `enable_ondrej_php_ppa`      | Enable PHP 8.2/8.3 repo                   | false   |
| `enable_fastcgi_cache`       | Nginx FastCGI cache for WP               | true    |
| `enable_redis`               | Redis object cache                       | true    |
| `enable_firewall`            | UFW firewall                             | true    |
| `ssh_port`                   | SSH port for firewall rules              | 22      |
| `enable_fail2ban`            | Brute-force protection                   | true    |
| `enable_certbot`             | Auto SSL via Lets Encrypt                | false   |
| `certbot_domains`            | Domains for SSL cert                     | example |
| `enable_netdata`             | System monitoring                         | false   |
| `enable_goaccess`            | Log analytics dashboard                  | false   |

### Notes

- WooCommerce installs at the latest available version.
- For PHP 8.2 or 8.3 on Ubuntu 22.04, enable the Ondrej PPA in variables.

## Runbook: step-by-step execution (automated + manual)

This runbook is written as a senior Infrastructure + Business Analyst
work-items list. Automated items are executed by the script; manual items
are explicitly marked as **TODO by User**.

### Step 0: Pre-flight checks (manual)

1. Confirm DNS is ready for your domain.
2. Confirm you have sudo/root access.
3. Confirm SSH port policy with your security team.

### Step 1: Configure Ansible variables (manual)

Edit:

```
provision/group_vars/all.yml
```

Minimum required:

- `site_domain`, `site_server_name`, `site_root`
- `wp_site_url`, `wp_admin_user`, `wp_admin_password`, `wp_admin_email`
- `db_name`, `db_user`, `db_password`

Recommended enterprise defaults:

- `php_version: "8.3"`
- `enable_ondrej_php_ppa: true`
- `enable_fastcgi_cache: true`
- `enable_redis: true`
- `enable_firewall: true`
- `enable_fail2ban: true`
- `enable_certbot: true` (only after DNS is live)

### Step 2: Execute the automated provisioning (script)

```
sudo bash setup.sh
```

This installs the LEMP stack, WordPress, WooCommerce, Elementor, Variation
Swatches, Back In Stock notifier, Redis cache (optional), UFW + Fail2Ban
(optional), Netdata/GoAccess (optional), and Nginx FastCGI cache (optional).

### Step 3: Verify service health (manual)

1. `systemctl status nginx mariadb php{{ php_version }}-fpm`
2. `redis-cli ping` (expect `PONG`) if Redis is enabled.
3. Open the site URL and finish WP login.

### Step 4: SSL enablement (if not enabled in Step 1)

If DNS is live and you want Lets Encrypt:

- Set `enable_certbot: true`
- Populate `certbot_domains`
- Re-run `sudo bash setup.sh`

### Step 5: Fashion template import (manual)

- Log in to `/wp-admin`
- Navigate to **Appearance → Starter Templates**
- Import your preferred fashion template

## Manual work items (TODO by User)

These are intentionally left manual due to licensing, data ownership,
and business review requirements.

### Phase 1: Server hardening (Hour 1)

- [ ] **TODO by User** Change SSH port from 22 to a custom port (e.g., 2299).
- [ ] **TODO by User** Confirm UFW rules (SSH + HTTP/HTTPS only).
- [ ] **TODO by User** Confirm Redis exposure policy (local-only preferred).

### Phase 2: Data and visual import (Hour 2)

- [ ] **TODO by User** Run Blonwe demo importer (1-click design).
- [ ] **TODO by User** Import product CSV (variable products with attributes).
- [ ] **TODO by User** Convert attributes to visual swatches.

### Phase 3: Business logic (Hour 3)

- [ ] **TODO by User** Map size charts to categories (dresses, shoes).
- [ ] **TODO by User** Enable mobile bottom menu (home/search/wishlist/cart).
- [ ] **TODO by User** Configure Back In Stock double opt-in (GDPR).

### Phase 4: Monitoring and handover (Hour 4)

- [ ] **TODO by User** Deploy Uptime Kuma (separate box or Docker).
- [ ] **TODO by User** Configure SSL/HTTP checks + Slack/Telegram alerts.
- [ ] **TODO by User** Connect FreeScout to business SMTP email.
- [ ] **TODO by User** Configure SupportCandy mailboxes and workflows.
- [ ] **TODO by User** Run Advanced Database Cleaner to purge demo transients.

## Senior Infrastructure and Business Analyst review

### Readiness gates

- **Security gate**: SSH policy approved, UFW + Fail2Ban active.
- **Performance gate**: FastCGI + Redis enabled; homepage loads < 2s.
- **Reliability gate**: External uptime checks with notifications in < 60s.
- **Compliance gate**: SSL active, backups scheduled, admin access audited.

### Known manual dependencies

- Premium plugin uploads (Blonwe Core, Slider Revolution).
- Uptime Kuma monitoring (external host).
- Support desk (FreeScout or osTicket).
- Fashion template import + business data onboarding.