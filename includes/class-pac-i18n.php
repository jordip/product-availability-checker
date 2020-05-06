<?php

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Pac
 * @subpackage Pac/includes
 * @author     Jordi Plana <hello@jordiplana.com>
 */
class Pac_i18n {



	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since 1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'pac',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);
	}
}
