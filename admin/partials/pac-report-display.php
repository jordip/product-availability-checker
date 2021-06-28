<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link  https://jordiplana.com
 * @since 1.3.0
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

		<div class="box">
			<h2><?php _e( 'Report', 'pac' ); ?></h2>
			<?php if ( $output && ! empty( $output['posts'] ) ) : ?>

				<span class="tag is-info is-light is-medium">[<?php _e( 'Last scan: ', 'pac' ); ?> <?php echo $output['scan_time']; ?>]</span>
				<?php foreach ( $output['posts'] as $post_id => $post_info ) : ?>
					<div id="result-post<?php echo $post_id; ?>" class="card full-width">
						<h4 id="title-post<?php echo $post_id; ?>"><?php echo $post_info['title']; ?> (<span class="actions-post" id="actions-post<?php echo $post_id; ?>"><a href="<?php echo $post_info['url']; ?>" target="_blank"><?php _e( 'View', 'pac' ); ?></a> | <a href="post.php?post=<?php echo $post_id; ?>&action=edit"><?php _e( 'Edit', 'pac' ); ?></a>) <span class="tag is-info is-light">[<?php _e( 'Last scan: ', 'pac' ); ?> <?php echo $post_info['scan_time']; ?>]</span></h4>

						<ul id="products-post<?php echo $post_id; ?>">
							<?php foreach ( $post_info['products'] as $product ) : ?>
								<?php if ( $product['status'] == PAC_STATUS_NOT_AVAILABLE ) : ?>
									<li>
										<span class="icon has-text-danger"><i class="fas fa-times"></i></span> <?php echo $product['asin']; ?> - <?php echo substr( $product['title'], 0, 50 ); ?>... (<a href="<?php echo $product['url']; ?>" target="_blank"><?php _e( 'View', 'pac' ); ?></a>)
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						</ul>
						<p id="total-post<?php echo $post_id; ?>"><span class="tag is-success is-light"><?php _e( 'Checked', 'pac' ); ?> <?php echo count( $post_info['products'] ); ?> <?php _e( 'products', 'pac' ); ?>.</span></p>
					</div>
				<?php endforeach; ?>
			<?php else : ?>
				<article class="message is-info">
					<div class="message-header">
						<p class="is-marginless"><?php _e( 'No reports found', 'pac' ); ?></p>
					</div>
					<div class="message-body">
						<p class="is-marginless">
							<?php _e( "We couldn't find any previous scan report. Run the scanner first and come back here to see an archived version of the result.", 'pac' ); ?>
						</p>
						<p>
							<input type="submit" name="submit" id="go-scan" class="button button-primary" value="<?php _e( 'Scan', 'pac' ); ?>">
						</p>
					</div>
				</article>
			<?php endif; ?>

		</div>

</div>
