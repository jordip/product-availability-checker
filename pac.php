<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link    https://productavailable.com
 * @since   1.0.0
 * @package Pac
 *
 * @wordpress-plugin
 * Plugin Name:       Amazon Product Availability Tracker
 * Description:       Scans your Amazon Affiliate site for links to products that are out of stock, or no longer available.
 * Version:           1.4.2
 * Author:            ProductAvailable.com
 * Author URI:        https://www.productavailable.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       pac
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PAC_VERSION', '1.4.2' );

/**
 * Plugin name to be used.
 */
define( 'PAC_DB_VERSION', '1.0.0' );

/**
 * Plugin name to be used.
 */
define( 'PAC_TITLE', 'Amazon Product Availability Tracker' );

/**
 * Plugin name to be used for menus.
 */
define( 'PAC_TITLE_SHORT', 'Amazon Products' );

// Plugin Folder Path.
if ( ! defined( 'PAC_PLUGIN_DIR' ) ) {
	define( 'PAC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
}

// Plugin Folder Path.
if ( ! defined( 'PAC_PLUGIN_BASE_NAME' ) ) {
	define( 'PAC_PLUGIN_BASE_NAME', plugin_basename( plugin_dir_path( __FILE__ ) ) );
}

// Availability status.
define( 'PAC_STATUS_AVAILABLE', 1 );
define( 'PAC_STATUS_NOT_AVAILABLE', 0 );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pac-activator.php
 */
function activate_pac() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-pac-activator.php';
	Pac_Activator::activate();
}

/**
 * The code that runs during plugin update.
 * This action is documented in includes/class-pac-update.php
 */
function update_pac() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-pac-activator.php';
	Pac_Activator::update();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pac-deactivator.php
 */
function deactivate_pac() {
	include_once plugin_dir_path( __FILE__ ) . 'includes/class-pac-deactivator.php';
	Pac_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_pac' );
register_deactivation_hook( __FILE__, 'deactivate_pac' );
add_action( 'plugins_loaded', 'update_pac' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-pac.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since 1.0.0
 */
function run_pac() {
	$plugin = new Pac();
	$plugin->run();
}
run_pac();
