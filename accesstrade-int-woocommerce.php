<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://example.com
 * @since             1.0.0
 * @package           ACCESSTRADE_Intergration
 *
 * @wordpress-plugin
 * Plugin Name:       ACCESSTRADE Intergration (Woocommerce)
 * Plugin URI:        https://github.com/interspace-vn/accesstrade-int-woocommerce
 * Description:       WordPress plugin for Intergrate Woocommerce system with ACCESSTRADE Vietnam affiliate system.
 * Version:           1.0.0
 * Author:            Interspace Vietnam
 * Author URI:        https://accesstrade.vn
 * Text Domain:       accesstrade-int-woocommerce
 * Domain Path:       /languages
 */
// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}

require plugin_dir_path( __FILE__ ) . 'admin.php';
require plugin_dir_path( __FILE__ ) . 'functions.php';
