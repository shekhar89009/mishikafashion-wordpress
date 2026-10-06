<?php
/**
 * Plugin Name: DealNest Affiliate Manager
 * Description: Affiliate product catalog manager with GitHub-based plugin updates.
 * Version: 1.2.1
 * Author: DealNest
 * Text Domain: dealnest-affiliate-manager
 */
if (!defined('ABSPATH')) exit;

define('DEALNEST_AM_VERSION', '1.2.1');
define('DEALNEST_AM_FILE', __FILE__);
define('DEALNEST_AM_DIR', plugin_dir_path(__FILE__));
define('DEALNEST_AM_URL', plugin_dir_url(__FILE__));

require_once DEALNEST_AM_DIR . 'includes/class-dn-product.php';
require_once DEALNEST_AM_DIR . 'includes/class-dn-admin.php';
require_once DEALNEST_AM_DIR . 'includes/class-dn-github-updater.php';

register_activation_hook(__FILE__, function(){
    DN_Product::register();
    flush_rewrite_rules();
});
register_deactivation_hook(__FILE__, function(){ flush_rewrite_rules(); });

add_action('plugins_loaded', function(){
    DN_Product::init();
    DN_Admin::init();
    new DN_GitHub_Updater(DEALNEST_AM_FILE, array(
        'slug' => 'dealnest-affiliate-manager',
        'name' => 'DealNest Affiliate Manager',
        'version' => DEALNEST_AM_VERSION,
        'asset' => 'dealnest-affiliate-manager.zip',
        'option_prefix' => 'dealnest_am_github_'
    ));
});
