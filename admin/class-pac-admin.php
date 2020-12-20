<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pac
 * @subpackage Pac/admin
 * @author     ProductAvailable.com <info@productavailable.com>
 */
class Pac_Admin {




	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The options name to be used in this plugin
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string         $option_name     Option name of this plugin
	 */
	private $option_name = 'pac';

	/**
	 * Amazon PA API v5
	 *
	 * @var Pac_Paapi
	 */
	private $paapi;

	/**
	 * Helper methods
	 *
	 * @var Pac_Helper
	 */
	private $helper;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->helper      = new Pac_Helper();
		$this->paapi       = new Pac_Paapi();
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.2.0
	 */
	public function register_styles() {
		 wp_register_script( 'Font_Awesome', 'https://use.fontawesome.com/releases/v5.3.1/js/all.js' );
	}

	/**
	 * Register the scripts for the admin area.
	 *
	 * @since 1.2.0
	 */
	public function register_scripts() {
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {
		// Plugin.
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/pac-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/css/style.css', array(), $this->version, 'all' );

		// External.
		// wp_enqueue_style('Bulma');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {
		 // Plugin.
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . '../assets/js/pac-admin.js', array( 'jquery' ), $this->version, false );

		// External.
		wp_enqueue_script( 'Font_Awesome' );
	}

	/**
	 * Add settings link to plugins page.
	 *
	 * @param mixed $links
	 * @return void
	 */
	public function settings_link( $links ) {
		$url           = get_admin_url() . 'admin.php?page=pac';
		$settings_link = '<a href="' . $url . '">' . __( 'Settings', 'pac' ) . '</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	public function add_plugin_meta_links( $meta_fields, $file ) {
		if ( PAC_PLUGIN_BASE_NAME . '/pac.php' == $file ) {
			$plugin_url    = 'https://wordpress.org/support/plugin/product-availability-checker/reviews/?rate=5#new-post';
			$meta_fields[] = "<a href='" . esc_url( $plugin_url ) . "' target='_blank' title='" . esc_html__( 'Rate', 'pac' ) . "'>
            <i class='ampforwp-rate-stars'>"
				. "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
				. "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
				. "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
				. "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
				. "<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round' class='feather feather-star'><polygon points='12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2'/></svg>"
				. '</i></a>';
		}

		return $meta_fields;
	}

	/**
	 * Add an options page under the Settings submenu
	 *
	 * @since 1.0.0
	 */
	public function add_options_page() {
		$this->plugin_screen_hook_suffix = add_menu_page(
			__( PAC_TITLE, 'pac' ),
			__( PAC_TITLE_SHORT, 'pac' ),
			'manage_options',
			$this->plugin_name,
			array( $this, 'display_options_page' ),
			'dashicons-search',
			30
		);

		$this->plugin_screen_hook_suffix = add_submenu_page(
			$this->plugin_name,
			__( 'Settings', 'pac' ),
			__( 'Settings', 'pac' ),
			'manage_options',
			$this->plugin_name
		);

		$this->plugin_screen_hook_suffix = add_submenu_page(
			$this->plugin_name,
			__( 'Scan', 'pac' ),
			__( 'Scan', 'pac' ),
			'manage_options',
			$this->plugin_name . '-scan',
			array( $this, 'display_scan_page' )
		);

		$this->plugin_screen_hook_suffix = add_submenu_page(
			$this->plugin_name,
			__( 'Reports', 'pac' ),
			__( 'Reports', 'pac' ),
			'manage_options',
			$this->plugin_name . '-report',
			array( $this, 'display_report_page' )
		);
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since 1.0.0
	 */
	public function display_options_page() {
		$page = $this->plugin_name;
		include_once 'partials/pac-admin-display.php';
	}

	/**
	 * Render the scan page for plugin
	 *
	 * @since 1.0.0
	 */
	public function display_scan_page() {
		global $wpdb;
		// Do we have valid API settings?
		$api_status = $this->verify_api_credentials();

		// Get timestamp of last scan
		$table_name_scans = $wpdb->prefix . 'pac_scans';
		$scan             = $wpdb->get_row( "SELECT * FROM $table_name_scans ORDER BY id DESC" );
		if ( $scan ) {
			$last_scan = $scan->time;
		} else {
			$last_scan = '';
		}
		$page = $this->plugin_name . '-scan';

		// Template
		include_once 'partials/pac-scan-display.php';
	}

	/**
	 * Render the report page for plugin
	 *
	 * @since 1.3.0
	 */
	public function display_report_page() {
		 global $wpdb;

		$output = array();

		$table_name_scans    = $wpdb->prefix . 'pac_scans';
		$table_name_results  = $wpdb->prefix . 'pac_results';
		$table_name_products = $wpdb->prefix . 'pac_products';

		// Get last scan
		$scan = $wpdb->get_row( "SELECT * FROM $table_name_scans ORDER BY id DESC" );
		if ( $scan ) {
			$output['scan_time'] = $scan->time;
			$results             = $wpdb->get_results(
				$wpdb->prepare(
					"SELECT
						r.post_id, p.*
					FROM
						$table_name_products p,
						$table_name_results r
					WHERE
						r.product_id = p.id AND
						r.scan_id = %d",
					$scan->id
				)
			);

			$post = array();
			foreach ( $results as $i => $result ) {
				// Get post info
				if ( $i == 0 || $result->post_id != $post->ID ) {
					$post                         = get_post( $result->post_id );
					$output['posts'][ $post->ID ] = array(
						'post_id'   => $post->ID,
						'title'     => $post->post_title,
						// 'base_url' => get_site_url(),
						'url'       => get_permalink( $post ),
						'scan_time' => $result->time,
					);
				}

				// Prepare output
				$output['posts'][ $post->ID ]['products'][] = array(
					'asin'   => $result->asin,
					'title'  => $result->title,
					'url'    => $result->url,
					'status' => $result->status,
				);
			}
		}

		$page = $this->plugin_name . '-report';

		// Template
		include_once 'partials/pac-report-display.php';
	}

	/**
	 * Register settings section
	 *
	 * @since 1.0.0
	 */
	public function register_setting() {
		// Add a General section
		add_settings_section(
			$this->option_name . '_general',
			__( 'Amazon Product Advertising API Settings', 'pac' ),
			array( $this, $this->option_name . '_general_cb' ),
			$this->plugin_name
		);

		// Setting fields
		$fields = array(
			'api_status'    => array(
				'type'  => 'status_info',
				'title' => __( 'Status', 'pac' ),
				'help'  => '',
			),
			'api_key'       => array(
				'type'  => 'text',
				'title' => __( 'API Key', 'pac' ),
				'help'  => '',
			),
			'api_secret'    => array(
				'type'  => 'password',
				'title' => __( 'API Secret', 'pac' ),
				'help'  => '',
			),
			'country'       => array(
				'type'  => 'amazon_country',
				'title' => __( 'Country', 'pac' ),
				'help'  => '',
			),
			'associate_tag' => array(
				'type'  => 'text',
				'title' => __( 'Associate tag', 'pac' ),
				'help'  => "Without the associate tag the conversion can't get assigned to your affiliate account.<br/>Your associate tag should look similar to <strong>xxxxx-21</strong> (may differ depending on the country).",
			),
		);

		foreach ( $fields as $key => $field ) {
			// Register setting fields
			add_settings_field(
				$this->option_name . '_' . $key,
				$field['title'],
				array( $this, $this->option_name . '_render_field_cb' ),
				$this->plugin_name,
				$this->option_name . '_general',
				array(
					'type'        => $field['type'],
					'label_for'   => $this->option_name . '_' . $key,
					'label_title' => $field['title'],
					'label_help'  => $field['help'],
				)
			);

			// Check with sanitization function to use
			switch ( $field['type'] ) {
				case 'text':
				default:
					$sanitize_cb = array( $this, $this->option_name . '_sanitize_text' );
					break;
			}

			// Register settings
			register_setting( $this->plugin_name, $this->option_name . '_' . $key, $sanitize_cb );
		}
	}

	/**
	 * Sanitize user input
	 *
	 * @param  mixed $field
	 * @return void
	 */
	public function pac_sanitize_text( $field ) {
		return sanitize_text_field( $field );
	}

	/**
	 * Render the text for the general section
	 *
	 * @since 1.0.0
	 */
	public function pac_general_cb() {
		// Validate API Credentials (if any)
		$api_status = $this->verify_api_credentials();
		update_option( 'pac_api_status', $api_status );

		echo '<p>' . __( 'In order to be able to use this plugin you need to be registered as an Amazon affiliate, and have a valid API Key.', 'pac' ) . '</p>';
		echo '<ol>';
		echo '<li>' . __( 'Register as an Amazon affiliate <a href="https://affiliate-program.amazon.com/" target="_blank">https://affiliate-program.amazon.com</a>', 'pac' ) . '</li>';
		echo '<li>' . __( 'Create Amazon Product Advertising API credentials <a href="https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html" target="_blank">https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html</a>', 'pac' ) . '</li>';
		echo '</ol>';
	}

	/**
	 * Render the radio input field for api_key option
	 *
	 * @since 1.0.0
	 */
	public function pac_render_field_cb( $args ) {
		$value = get_option( $args['label_for'] );
		switch ( $args['type'] ) {
			case 'status_info':
				$status = array(
					'color' => 'red',
					'icon'  => 'no',
					'label' => __( 'Disconnected', 'pac' ),
				);
				if ( ! empty( $value ) ) {
					$status = array(
						'color' => 'green',
						'icon'  => 'yes',
						'label' => __( 'Connected', 'pac' ),
					);
				}
				?>
				<fieldset>
					<label>
						<span style="color: <?php echo $status['color']; ?>;"><span class="dashicons dashicons-<?php echo $status['icon']; ?>"></span> <?php echo $status['label']; ?></span>
					</label>
				</fieldset>
				<?php
				break;
			case 'amazon_country':
				$country_tags = $this->paapi->get_amazon_stores();
				?>
				<fieldset>
					<select id="<?php echo $args['label_for']; ?>" name="<?php echo $args['label_for']; ?>">
						<?php foreach ( $country_tags as $tag => $label ) { ?>
							<option value="<?php echo $tag; ?>" 
													  <?php
														if ( ( empty( $value ) && $tag == 'com' ) || ( $value == $tag ) ) :
															?>
																 selected 
																<?php
																		endif;
														?>
																			>amazon.<?php echo $tag; ?></option>
						<?php } ?>
					</select>
					<p><small><?php echo $args['label_help']; ?></small></p>
				</fieldset>
				<?php
				break;
			case 'password':
				?>
				<fieldset>
					<label>
						<input type="password" name="<?php echo $args['label_for']; ?>" id="<?php echo $args['label_for']; ?>" value="<?php echo $value; ?>">
						<p><small><?php echo $args['label_help']; ?></small></p>
					</label>
				</fieldset>
				<?php
				break;
			case 'text':
			default:
				?>
				<fieldset>
					<label>
						<input type="text" name="<?php echo $args['label_for']; ?>" id="<?php echo $args['label_for']; ?>" value="<?php echo $value; ?>">
						<p><small><?php echo $args['label_help']; ?></small></p>
					</label>
				</fieldset>
				<?php
		}
	}

	/**
	 * Verify that the Amazon PA API credentials are valid
	 *
	 * @since 1.0.0
	 */
	public function verify_api_credentials() {
		$api = $this->paapi->load_amazon_api_config();
		return $this->paapi->validate_amazon_api( $api );
	}

	/**
	 * Gets a list of posts or pages
	 *
	 * @return void
	 */
	public function ajax_get_post_ids() {
		global $wpdb;
		$allowed_content_types = array( 'post', 'page' );
		$content_type          = sanitize_text_field( $_POST['content_type'] );
		$hash                  = sanitize_text_field( $_POST['hash'] );

		$content = array();
		if ( in_array( $content_type, $allowed_content_types ) ) {
			// Check if we are updating a current scan, or creating a new one.
			$table_name_scans = $wpdb->prefix . 'pac_scans';
			$sql              = $wpdb->prepare( "SELECT * FROM $table_name_scans WHERE `hash` = %s", $hash);
			$scan             = $wpdb->get_row( $sql );
			if ( empty( $scan ) && $content_type == 'post' ) {
				// New scan
				$scan    = $wpdb->insert( $table_name_scans, array( 'hash' => $hash ) );
				$scan_id = $wpdb->insert_id;
			} else {
				// Existing scan
				$scan_id = $scan->id;
			}

			$args = array(
				'post_type'   => $content_type,
				'post_status' => 'publish',
				'numberposts' => -1,
			);

			$posts = get_posts( $args );
		}

		foreach ( $posts as $post ) {
			$content[] = array(
				'id'        => $post->ID,
				'permalink' => get_permalink( $post->ID ),
				'title'     => $post->post_title,
			);
		}

		echo json_encode( $content );

		wp_die(); // this is required to terminate immediately and return a proper response
	}

	/**
	 * Gets all ASIN on a post/page and checks availability.
	 *
	 * @return void
	 */
	public function ajax_get_post_info() {
		global $wpdb;

		$return = array();

		$id   = intval( $_POST['id'] );
		$post = get_post( $id );
		$hash = sanitize_text_field( $_POST['hash'] );

		if ( ! empty( $post ) && ! empty( $hash ) ) {
			$table_name_scans    = $wpdb->prefix . 'pac_scans';
			$table_name_products = $wpdb->prefix . 'pac_products';
			$table_name_results  = $wpdb->prefix . 'pac_results';
			$sql                 = $wpdb->prepare( "SELECT * FROM $table_name_scans WHERE `hash` = '%s'", $hash );
			$scan                = $wpdb->get_row( $sql );

			// Get post content and look for links
			$post_content = apply_filters( 'the_content', $post->post_content );

			// Regular links.
			$amazon_matches = $this->helper->get_amazon_asin( $post_content );
			// Shortlinks.
			$shortlink_matches = $this->helper->get_amazon_asin( $post_content, true );

			$matches = array_merge( $amazon_matches, $shortlink_matches );

			if ( ! empty( $matches ) ) {
				// ASIN found
				$asin_collection = array();
				foreach ( $matches as $match ) {
					if ( ! in_array( $match[1], $asin_collection ) ) {
						$asin_collection[] = $match[1];
					}
				}

				// getItem ASIN
				$this->paapi->set_amazon_api_config_instance();

				// Current getItems limit is 10
				// @docs: https://webservices.amazon.com/paapi5/documentation/get-items.html
				$item_collection = array();
				if ( count( $asin_collection ) > 10 ) {
					foreach ( array_chunk( $asin_collection, 10 ) as $asin_coll ) {
						$items = $this->paapi->api_get_items( $asin_coll );
						if ( $items ) {
							$item_collection = array_merge( $item_collection, $items );
						}
					}
				} else {
					$item_collection = $this->paapi->api_get_items( $asin_collection );
				}

				if ( ! empty( $asin_collection ) && empty( $item_collection ) ) {
					// Something went wrong retrieving the items. Most of the times is a malformed ASIN.
					// @TODO: Return an error.
				}

				foreach ( $item_collection as $item ) {
					$asin   = '';
					$title  = '';
					$url    = '';
					$offers = '';
					if ( $item->getASIN() ) {
						$asin = $item->getASIN();
					}
					if (
						$item->getItemInfo() != null
						&& $item->getItemInfo()->getTitle() != null
						&& $item->getItemInfo()->getTitle()->getDisplayValue() != null
					) {
						$title = $item->getItemInfo()->getTitle()->getDisplayValue();
					}
					if ( $item->getDetailPageURL() != null ) {
						$url = $item->getDetailPageURL();
					}
					if (
						$item->getOffers() != null
						&& $item->getOffers()->getListings() != null
						&& $item->getOffers()->getListings()[0]->getPrice() != null
						&& $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() != null
					) {
						$offers = $item->getOffers()->getListings()[0]->getPrice()->getDisplayAmount();
					}
					/**
					 * Check if product has parent, and thus we need to check offers on the parent
					 *
					 * For more info refer: https://webservices.amazon.com/paapi5/documentation/use-cases/using-offer-information/items-that-do-not-have-offers.html
					 */
					if ( empty( $offers ) && $item->getParentASIN() != null ) {
						// Wait 1 second to avoid throttle
						sleep( 1 );

						$parentItem = $this->paapi->api_get_items( array( $item->getParentASIN() ) )[0];
						if (
							$parentItem != null
							&& $parentItem->getOffers() != null
							&& $parentItem->getOffers()->getListings() != null
							&& $parentItem->getOffers()->getListings()[0]->getPrice() != null
							&& $parentItem->getOffers()->getListings()[0]->getPrice()->getDisplayAmount() != null
						) {
							$offers = $parentItem->getOffers()->getListings()[0]->getPrice()->getDisplayAmount();
						}
					}

					// Building return
					$data = array(
						'asin'   => $asin,
						'title'  => $title,
						'url'    => $url,
						'offers' => $offers,
					);
					if ( empty( $offers ) ) {
						// Not available!
						$data['status'] = PAC_STATUS_NOT_AVAILABLE;
					} else {
						// Still saleable
						$data['status'] = PAC_STATUS_AVAILABLE;
					}
					$return[] = $data;

					// Save results
					if ( ! empty( $scan ) ) {
						// Save product
						$product = $wpdb->insert(
							$table_name_products,
							$data,
							array(
								'%s', // asin
								'%s', // title
								'%s', // url
								'%s', // offers
								'%d', // status
							)
						);
						if ( $product ) {
							// Save result
							$product_id = $wpdb->insert_id;
							$wpdb->insert(
								$table_name_results,
								array(
									'scan_id'    => $scan->id,
									'post_id'    => $post->ID,
									'product_id' => $product_id,
								),
								array(
									'%d', // scan_id
									'%d', // post_id
									'%d', // product_id
								)
							);
						}
					}
				}
			}
		}

		echo json_encode( $return );

		wp_die(); // this is required to terminate immediately and return a proper response
	}
}
