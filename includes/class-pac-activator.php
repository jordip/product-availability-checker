<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Pac
 * @subpackage Pac/includes
 * @author     ProductAvailable.com <info@productavailable.com>
 */
class Pac_Activator {


	/**
	 * Activate register hook.
	 *
	 * Activate register hook.
	 *
	 * @since 1.0.0
	 */
	public static function activate() {
		self::check_db_version();
	}

	/**
	 * Update function.
	 *
	 * Update function.
	 *
	 * @since 1.3.0
	 */
	public static function update() {
		self::check_db_version();
	}

	/**
	 * Checks if tables exist, if not creates them.
	 *
	 * Checks if tables exist, if not creates them.
	 *
	 * @since 1.3.0
	 */
	public static function check_db_version() {
		$installed_ver = get_option( 'pac_db_version' );

		// If plugin was installed, prior to 1.3.0 run install method.
		if ( ! $installed_ver || $installed_ver != PAC_DB_VERSION ) {
			self::install();
		}
	}

	/**
	 * Install function.
	 *
	 * Creates plugin tables.
	 *
	 * @since 1.0.0
	 */
	public static function install() {
		global $wpdb;
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		$charset_collate = $wpdb->get_charset_collate();

		// Scan table.
		$table_name_scans = $wpdb->prefix . 'pac_scans';
		$sql              = "CREATE TABLE $table_name_scans (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			hash varchar(100) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
		dbDelta( $sql );

		// Product table.
		$table_name_products = $wpdb->prefix . 'pac_products';
		$sql                 = "CREATE TABLE $table_name_products (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			asin varchar(100) NOT NULL,
			title LONGTEXT NOT NULL,
			url varchar(255) NOT NULL,
			offers LONGTEXT,
			status mediumint(10) NOT NULL,
			PRIMARY KEY  (id)
		) $charset_collate;";
		dbDelta( $sql );

		// Scan result table.
		$table_name_results = $wpdb->prefix . 'pac_results';
		$sql                = "CREATE TABLE $table_name_results (
			id bigint(20) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
			scan_id bigint(20) NOT NULL,
			post_id bigint(20) NOT NULL,
			product_id bigint(20) NOT NULL,
			PRIMARY KEY  (id),
			FOREIGN KEY (scan_id)
      			REFERENCES $table_name_scans(id),
			FOREIGN KEY (product_id)
      			REFERENCES $table_name_products(id)
		) $charset_collate;";
		dbDelta( $sql );

		add_option( 'pac_db_version', PAC_DB_VERSION );
	}

}
