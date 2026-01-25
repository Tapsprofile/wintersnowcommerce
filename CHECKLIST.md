# Infrastructure and Business Analyst Checklist

This document is the end-to-end checklist for a fashion commerce launch
on Ubuntu 22.04. It includes infrastructure, security, performance,
application, and business operations.

Use it as the authoritative runbook. Check items off in order.

## Phase 0: Pre-flight

- [ ] Confirm domain ownership and DNS control.
- [ ] Confirm server sizing (4 CPU / 8 GB RAM minimum).
- [ ] Confirm root or sudo access.
- [ ] Confirm change window and rollback plan.

## Phase 1: Core infrastructure (LEMP foundation)

- [ ] Update OS packages: `sudo apt update && sudo apt upgrade -y`
- [ ] Install Nginx (latest from repo or upstream if required).
- [ ] Install MariaDB (10.11+ required for enterprise spec).
- [ ] Install PHP (8.3 recommended) with:
  - [ ] php-fpm
  - [ ] php-imagick
  - [ ] php-redis
  - [ ] php-mysql
  - [ ] php-xml
  - [ ] php-mbstring
  - [ ] php-zip
  - [ ] php-intl
  - [ ] php-bcmath
  - [ ] php-soap
- [ ] Install Redis server and verify connectivity.

## Phase 2: Security and hardening

- [ ] Change SSH port from 22 to a custom port (example: 2299).
- [ ] Apply UFW firewall rules:
  - [ ] Allow SSH on the custom port.
  - [ ] Allow HTTP 80 and HTTPS 443.
  - [ ] Deny all other inbound by default.
- [ ] Install and enable Fail2Ban.
- [ ] Confirm server time, NTP sync, and log retention.

## Phase 3: Performance and caching

- [ ] Enable Nginx FastCGI cache for WordPress.
- [ ] Enable Redis object cache for WordPress.
- [ ] Confirm static asset caching headers.
- [ ] Validate homepage load time < 2 seconds.

## Phase 4: SSL and certificates

- [ ] Install Certbot.
- [ ] Issue Lets Encrypt certificates for primary and www domains.
- [ ] Confirm SSL auto-renewal.
- [ ] Validate HTTPS redirect and HSTS policy.

## Phase 5: WordPress and WooCommerce core

- [ ] Install WordPress core and set admin credentials.
- [ ] Install and activate WooCommerce (target 10.4.x).
- [ ] Configure store location, currency, taxes, shipping, payments.
- [ ] Confirm health checks and scheduled tasks.

## Phase 6: Fashion solution stack

### Foundations
- [ ] Install and activate Elementor.
- [ ] Install and activate Blonwe Core (premium upload).

### Visual and conversion enhancements
- [ ] Install Variation Swatches (Emran Ahmed).
- [ ] Install Back In Stock Notifier.
- [ ] Validate Smart Size Charts (Blonwe built-in).

### Template and design
- [ ] Import Blonwe demo template for fashion catalog.
- [ ] Configure homepage hero banners and featured collections.
- [ ] Optimize product imagery (WebP where possible).

## Phase 7: Product data and merchandising

- [ ] Import product CSV (variable products with color and size).
- [ ] Convert attributes to visual swatches:
  - [ ] Color as circles.
  - [ ] Size as buttons.
- [ ] Map size charts to categories (dresses, shoes).
- [ ] Enable mobile bottom menu (home, search, wishlist, cart).

## Phase 8: Monitoring and alerting

- [ ] Install Netdata (optional but recommended).
- [ ] Install GoAccess (optional for log analytics).
- [ ] Deploy Uptime Kuma on a separate host or Docker.
- [ ] Configure checks:
  - [ ] HTTP 200 every 60 seconds.
  - [ ] SSL expiry alerts.
  - [ ] CPU and RAM threshold alerts (80%).
- [ ] Connect alerts to Slack or Telegram.

## Phase 9: Support operations

- [ ] Deploy FreeScout or osTicket on support subdomain.
- [ ] Configure SMTP for ticketing inbox.
- [ ] Install SupportCandy (private support inside WordPress).
- [ ] Configure SupportCandy mailboxes, SLA, and workflows.

## Phase 10: Business continuity

- [ ] Configure automated backups (database + wp-content).
- [ ] Validate restore procedure.
- [ ] Document emergency contacts and escalation path.
- [ ] Run Advanced Database Cleaner to remove demo transients.

## Final readiness gate

- [ ] Security gate: SSH policy approved, UFW + Fail2Ban active.
- [ ] Performance gate: FastCGI + Redis enabled, < 2s load time.
- [ ] Reliability gate: external uptime checks alert within 60s.
- [ ] Compliance gate: SSL active, backups scheduled, admin audited.
