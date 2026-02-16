<?php
/**
 * My Account Page Template
 * Horizontal tabs layout
 *
 * @package WinterSnow_Commerce
 */

defined('ABSPATH') || exit;

get_header();
?>

<div class="my-account-wrapper">
    <div class="container">
        <h1 class="page-title"><?php _e('My Account', 'wintersnow-commerce'); ?></h1>
        
        <div class="account-tabs-wrapper">
            <div class="account-tabs">
                <button class="account-tab active" data-tab="dashboard">
                    <?php _e('Dashboard', 'wintersnow-commerce'); ?>
                </button>
                <button class="account-tab" data-tab="orders">
                    <?php _e('My Orders', 'wintersnow-commerce'); ?>
                </button>
                <button class="account-tab" data-tab="downloads">
                    <?php _e('Downloads', 'wintersnow-commerce'); ?>
                </button>
                <button class="account-tab" data-tab="addresses">
                    <?php _e('Addresses', 'wintersnow-commerce'); ?>
                </button>
                <button class="account-tab" data-tab="account-details">
                    <?php _e('Account Details', 'wintersnow-commerce'); ?>
                </button>
                <a href="<?php echo esc_url(wc_logout_url()); ?>" class="account-tab">
                    <?php _e('Logout', 'wintersnow-commerce'); ?>
                </a>
            </div>
            
            <div class="account-content">
                <div class="account-tab-content active" id="dashboard">
                    <?php wc_get_template('myaccount/dashboard.php'); ?>
                </div>
                
                <div class="account-tab-content" id="orders">
                    <?php wc_get_template('myaccount/orders.php'); ?>
                </div>
                
                <div class="account-tab-content" id="downloads">
                    <?php wc_get_template('myaccount/downloads.php'); ?>
                </div>
                
                <div class="account-tab-content" id="addresses">
                    <?php wc_get_template('myaccount/my-address.php'); ?>
                </div>
                
                <div class="account-tab-content" id="account-details">
                    <?php wc_get_template('myaccount/form-edit-account.php'); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
