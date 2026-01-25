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

## One-click provisioning (Ubuntu 22.04)

This repo includes an Ansible-based setup that installs a fashion-ready
WooCommerce store with Elementor and a popular starter template flow.

### 1) Configure variables

Edit the provisioning variables before running the setup:

```
provision/group_vars/all.yml
```

Set your domain, admin credentials, and database password.

### 2) Run the setup

```
sudo bash setup.sh
```

### 3) Finish the fashion template import

The playbook installs the Astra theme and the Starter Templates plugin.
Log in to `/wp-admin`, open **Appearance → Starter Templates**, and import
any fashion template you like.

### Notes

- Premium plugins (Blonwe Core, Slider Revolution) must be uploaded manually.
- WooCommerce is installed and activated at the latest version available.