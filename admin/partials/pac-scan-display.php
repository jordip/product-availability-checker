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
	<?php require_once PAC_PLUGIN_DIR . 'admin/partials/common/nav.php'; ?>


	<?php if ( ! empty( $notices ) ) : ?>
		<?php foreach ( $notices as $notice ) : ?>
			<div id="settings_notice" class="notice notice-<?php echo $notice['class']; ?> is-dismissible">
				<p><strong><?php echo $notice['message']; ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

	<?php if ( $api_status ) : ?>
		<div class="box">
			<h2><?php _e( 'Scan', 'pac' ); ?></h2>
			<p>
				<?php _e( 'Scans all your posts and pages body content, matches Amazon links and checks the product availability.', 'pac' ); ?>
			</p>
			<p>
				<small><?php _e( "Please note that this scanner doesn't support cloaked links.", 'pac' ); ?></small>
			</p>



			<nav class="level">
				<div class="level-left">
					<div class="level-item">
						<input type="hidden" name="scan_hash" id="scan_hash" />
						<input type="button" name="scan-start-stop" id="scan-start-stop" class="button button-primary start" value="<?php _e( 'Start scanning', 'pac' ); ?>">
					</div>
					<?php if ( ! empty( $last_scan ) ) : ?>
					<div class="level-item">
						<button class="button" id="go-reports"><?php _e( 'View last scan', 'pac' ); ?></button>
					</div>
					<?php endif; ?>
				</div>
			</nav>
		</div>
		<div id="scan-result" class="box">
			<h3><span id="progress-loader" class="loader loader16"></span> <span id="scan-progress"><?php _e( 'Scanning', 'pac' ); ?></span></h3>
		</div>
	<?php else : ?>
		<article class="message is-warning">
			<div class="message-header">
				<p class="is-marginless"><?php _e( 'Warning', 'pac' ); ?></p>
			</div>
			<div class="message-body">
				<p class="is-marginless">
					<?php _e( "We couldn't fetch Amazon Product Advertising API results. Check your Settings and try again.", 'pac' ); ?>
				</p>
				<p>
					<input type="submit" name="submit" id="go-settings" class="button button-primary" value="<?php _e( 'Fix', 'pac' ); ?>">
				</p>
			</div>
		</article>
	<?php endif; ?>
</div>
