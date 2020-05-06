<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://jordiplana.com
 * @since 1.0.0
 *
 * @package    Pac
 * @subpackage Pac/admin/partials
 */

?>

<div class="wrap">
	<h1 class="wp-heading-inline"><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<?php require_once PAC_PLUGIN_DIR . 'admin/partials/common/nav.php'; ?>
	<div class="postbox">
		<div class="inside">

			<?php if ( ! empty( $notices ) ) : ?>
				<?php foreach ( $notices as $notice ) : ?>
					<div id="settings_notice" class="notice notice-<?php echo $notice['class']; ?> is-dismissible">
						<p><strong><?php echo $notice['message']; ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>

			<?php if ( $api_status ) : ?>
				<p>
					<?php _e( 'Scan all your posts and pages for links containing Amazon links, then check for product availability.', 'pac' ); ?>
				</p>
				<p>
					<span style="color:red">[x]</span><?php _e( '', 'pac' ); ?> This mark indicates products that are no longer available and need fixing.
				</p>
				<p>
					<small><?php _e( "Please note that this scanner doesn't support cloaked links.", 'pac' ); ?></small>
				</p>
				<div>
					<p>[<?php _e( 'Last scan: ', 'pac' ); ?> <?php echo $last_scan; ?>]</p>
					<input type="button" name="scan-start-stop" id="scan-start-stop" class="button button-primary start" value="<?php _e( 'Start scanning', 'pac' ); ?>">
					<div id="scan-result">
						<h3><span id="progress-loader" class="loader loader16"></span> <span id="scan-progress">Scanning</span></h3>
					</div>
				</div>
			<?php else : ?>
				<p><span style="color: red;"><span class="dashicons dashicons-no"></span> <?php _e( 'Check your Amazon Product Advertising API Settings and try again.', 'pac' ); ?></span></span> <a href="admin.php?page=pac">Fix</a>.</p>
			<?php endif; ?>
		</div>
	</div>
</div>
