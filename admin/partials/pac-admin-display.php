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

			<form action="options.php" method="post">
				<?php
				settings_fields( $this->plugin_name );
				do_settings_sections( $this->plugin_name );
				submit_button();
				?>
			</form>
		</div>
	</div>
</div>
