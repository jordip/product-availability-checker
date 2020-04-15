<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pac
 * @subpackage Pac/admin
 * @author     Jordi Plana <hello@jordiplana.com>
 */

class Pac_Admin
{

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
     * Initialize the class and set its properties.
     *
     * @since 1.0.0
     * @param string $plugin_name The name of this plugin.
     * @param string $version     The version of this plugin.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
        $this->paapi = new Pac_Paapi();
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/pac-admin.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since 1.0.0
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/pac-admin.js', array('jquery'), $this->version, false);
    }

    /**
     * Add an options page under the Settings submenu
     *
     * @since 1.0.0
     */
    public function add_options_page()
    {
        $this->plugin_screen_hook_suffix = add_menu_page(
            __(PAC_TITLE, 'pac'),
            __(PAC_TITLE_SHORT, 'pac'),
            'manage_options',
            $this->plugin_name,
            array($this, 'display_options_page'),
            'dashicons-search',
            30
        );

        $this->plugin_screen_hook_suffix = add_submenu_page(
            $this->plugin_name,
            __('Settings', 'pac'),
            __('Settings', 'pac'),
            'manage_options',
            $this->plugin_name
        );

        $this->plugin_screen_hook_suffix = add_submenu_page(
            $this->plugin_name,
            __('Scan and check', 'pac'),
            __('Scan and check', 'pac'),
            'manage_options',
            $this->plugin_name . '-scan',
            array($this, 'display_scan_page'),
        );
    }

    /**
     * Render the options page for plugin
     *
     * @since 1.0.0
     */
    public function display_options_page()
    {
        $page = $this->plugin_name;
        include_once 'partials/pac-admin-display.php';
    }

    /**
     * Render the scan page for plugin
     *
     * @since 1.0.0
     */
    public function display_scan_page()
    {
        // Do we have valid API settings?
        $api_status = $this->verify_api_credentials();
        // if (!$api_status) {
        //     $notices = [
        //         [
        //             'message' => __('Missing or wrong Product Advertising API Credentials. Please check settings and try again.', 'pac'),
        //             'class' => 'error'
        //         ]
        //     ];
        // }
        $page = $this->plugin_name . '-scan';
        include_once 'partials/pac-scan-display.php';
    }

    /**
     * Register settings section
     *
     * @since 1.0.0
     */
    public function register_setting()
    {
        // Add a General section
        add_settings_section(
            $this->option_name . '_general',
            __('Amazon Product Advertising API Settings', 'pac'),
            array($this, $this->option_name . '_general_cb'),
            $this->plugin_name
        );

        // Setting fields
        $fields = [
            'api_status' => [
                'type' => 'status_info',
                'title' => __('Status', 'pac'),
                'help' => ''
            ],
            'api_key' => [
                'type' => 'text',
                'title' => __('API Key', 'pac'),
                'help' => ''
            ],
            'api_secret' => [
                'type' => 'password',
                'title' => __('API Secret', 'pac'),
                'help' => ''
            ],
            'country' => [
                'type' => 'amazon_country',
                'title' => __('Country', 'pac'),
                'help' => ''
            ],
            'associate_tag' => [
                'type' => 'text',
                'title' => __('Associate tag', 'pac'),
                'help' => "Without the associate tag the conversion can't get assigned to your affiliate account.<br/>Your associate tag should look similar to <strong>xxxxx-21</strong> (may differ depending on the country)."
            ],
        ];

        foreach ($fields as $key => $field) {
            // Register setting fields
            add_settings_field(
                $this->option_name . '_' . $key,
                $field['title'],
                [$this, $this->option_name . '_render_field_cb'],
                $this->plugin_name,
                $this->option_name . '_general',
                [
                    'type' => $field['type'],
                    'label_for' => $this->option_name . '_' . $key,
                    'label_title' => $field['title'],
                    'label_help' => $field['help']
                ]
            );

            // Check with sanitization function to use
            switch ($field['type']) {
                case 'text':
                default:
                    $sanitize_cb = [$this, $this->option_name . '_sanitize_text'];
                    break;
            }

            // Register settings
            register_setting($this->plugin_name, $this->option_name . '_' . $key, $sanitize_cb);
        }
    }

    /**
     * Sanitize user input
     *
     * @param  mixed $field
     * @return void
     */
    public function pac_sanitize_text($field)
    {
        return sanitize_text_field($field);
    }

    /**
     * Render the text for the general section
     *
     * @since 1.0.0
     */
    public function pac_general_cb()
    {
        // Validate API Credentials (if any)
        $api_status = $this->verify_api_credentials();
        update_option('pac_api_status', $api_status);

        echo '<p>' . __('In order to be able to use this plugin you need to be registered as an Amazon affiliate, and have a valid API Key.', 'pac') . '</p>';
        echo '<ol>';
        echo '<li>' . __('Register as an Amazon affiliate <a href="https://affiliate-program.amazon.com/" target="_blank">https://affiliate-program.amazon.com</a>', 'pac') . '</li>';
        echo '<li>' . __('Create Amazon Product Advertising API credentials <a href="https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html" target="_blank">https://affiliate-program.amazon.com/gp/flex/advertising/api/sign-in.html</a>', 'pac') . '</li>';
        echo '</ol>';
    }

    /**
     * Render the radio input field for api_key option
     *
     * @since 1.0.0
     */
    public function pac_render_field_cb($args)
    {
        $value = get_option($args['label_for']);
        switch ($args['type']) {
            case 'status_info':
                $status = [
                    'color' => 'red',
                    'icon' => 'no',
                    'label' => __('Disconnected', 'pac')
                ];
                if (!empty($value)) {
                    $status = [
                        'color' => 'green',
                        'icon' => 'yes',
                        'label' => __('Connected', 'pac')
                    ];
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
                    <select id="<?php echo $args['label_for'] ?>" name="<?php echo $args['label_for'] ?>">
                        <?php foreach ($country_tags as $tag => $label) { ?>
                            <option value="<?php echo $tag; ?>" <?php if ((empty($value) && $tag == 'com') || ($value == $tag)) : ?>selected<?php
                                                                                                                                        endif; ?>>amazon.<?php echo $tag; ?></option>
                        <?php } ?>
                    </select>
                    <p><small><?php echo $args['label_help'] ?></small></p>
                </fieldset>
            <?php
                break;
            case 'password':
            ?>
                <fieldset>
                    <label>
                        <input type="password" name="<?php echo $args['label_for'] ?>" id="<?php echo $args['label_for'] ?>" value="<?php echo $value; ?>">
                        <p><small><?php echo $args['label_help'] ?></small></p>
                    </label>
                </fieldset>
            <?php
                break;
            case 'text':
            default:
            ?>
                <fieldset>
                    <label>
                        <input type="text" name="<?php echo $args['label_for'] ?>" id="<?php echo $args['label_for'] ?>" value="<?php echo $value; ?>">
                        <p><small><?php echo $args['label_help'] ?></small></p>
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
    public function verify_api_credentials()
    {
        $api = $this->paapi->load_amazon_api_config();
        return $this->paapi->validate_amazon_api($api);
    }

    /**
     * Gets a list of posts or pages
     *
     * @return void
     */
    public function ajax_get_post_ids()
    {
        $allowed_content_types = ['post', 'page'];
        $content_type = sanitize_text_field($_POST['content_type']);

        $content = [];
        if (in_array($content_type, $allowed_content_types)) {
            $args = array(
                'post_type'   => $content_type,
                'post_status'    => 'publish',
                'numberposts' => -1,
            );

            $posts = get_posts($args);
        }

        foreach ($posts as $post) {
            $content[] = [
                'id' => $post->ID,
                'permalink' => get_permalink($post->ID),
                'title' => $post->post_title
            ];
        }

        echo json_encode($content);

        wp_die(); // this is required to terminate immediately and return a proper response
    }

    /**
     * Gets all ASIN on a post/page and checks availability.
     *
     * @return void
     */
    public function ajax_get_post_info()
    {
        $return = [];

        $id = intval($_POST['id']);
        $post = get_post($id);

        if (!empty($post)) {
            $post_content = apply_filters('the_content', $post->post_content);
            preg_match_all('/<a.*href=".*amazon\..*?\/([A-Z0-9]{10})/', $post_content, $matches, PREG_SET_ORDER);
            if (!empty($matches)) {
                // ASIN found
                $asin_collection = [];
                foreach ($matches as $match) {
                    if (!in_array($match[1], $asin_collection)) {
                        $asin_collection[] = $match[1];
                    }
                }
                // getItem ASIN
                $this->paapi->set_amazon_api_config_instance();
                $items = $this->paapi->api_get_items($asin_collection);
                foreach ($items as $item) {
                    $asin = '';
                    $title = '';
                    $url = '';
                    $offers = '';
                    if ($item->getASIN()) {
                        $asin = $item->getASIN();
                    }
                    if (
                        $item->getItemInfo() != null
                        && $item->getItemInfo()->getTitle() != null
                        && $item->getItemInfo()->getTitle()->getDisplayValue() != null
                    ) {
                        $title = $item->getItemInfo()->getTitle()->getDisplayValue();
                    }
                    if ($item->getDetailPageURL() != null) {
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
                    if (empty($offers) && $item->getParentASIN() != null) {
                        // Wait 1 second to avoid throttle
                        sleep(1);

                        $parentItem = $this->paapi->api_get_items([$item->getParentASIN()])[0];
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
                    if (empty($offers)) {
                        // Not available!
                        $return[] = [
                            'asin' => $asin,
                            'title' => $title,
                            'url' => $url,
                            'offers' => $offers,
                            'availability' => __('Not available.', 'pac')
                        ];
                    } else {
                        // Still saleable
                        $return[] = [
                            'asin' => $asin,
                            'title' => $title,
                            'url' => $url,
                            'offers' => $offers,
                            'availability' => __('In stock.', 'pac')
                        ];
                    }
                }
            }
        }

        echo json_encode($return);

        wp_die(); // this is required to terminate immediately and return a proper response
    }
}