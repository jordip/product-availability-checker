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
    <h1 class="wp-heading-inline"><?php echo esc_html(get_admin_page_title()); ?></h1>
    <?php require_once PAC_PLUGIN_DIR . 'admin/partials/common/nav.php'; ?>
    <div class="postbox">
        <div class="inside">

            <?php if (!empty($notices)) : ?>
                <?php foreach ($notices as $notice) : ?>
                    <div id="settings_notice" class="notice notice-<?php echo $notice['class']; ?> is-dismissible">
                        <p><strong><?php echo $notice['message']; ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text">Dismiss this notice.</span></button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($api_status) : ?>
                <p>
                    <?php _e('Scanning all your posts and pages for links containing Amazon links.', 'pac'); ?><br />
                    <small><?php _e("Please note that this scanner doesn't pick up shortlinks, or cloaked links. Only links with the following format will be checked: http(s)://www.amazon.(tld)/*", 'pac'); ?></small>
                </p>
                <div id="scan-result">
                    <h3>Scanning <span id="dot-progress"></span></h3>
                </div>
            <?php else : ?>
                <p><span style="color: red;"><span class="dashicons dashicons-no"></span> <?php _e('Check your Amazon Product Advertising API Settings and try again.', 'pac'); ?></span></span> <a href="admin.php?page=pac">Fix</a>.</p>
            <?php endif; ?>
        </div>
    </div>
</div>