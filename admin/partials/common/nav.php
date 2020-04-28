<?php

/**
 * Provide tabs for admin area.
 *
 * @link  https://jordiplana.com
 * @since 1.0.0
 *
 * @package    Pac
 * @subpackage Pac/admin/partials
 */

$tabs = [
    'pac' => __('Settings', 'pac'),
    'pac-scan' => __('Scan and check', 'pac'),
];
?>
<nav class="nav-tab-wrapper wp-clearfix">
    <?php foreach ($tabs as $url => $title) : ?>
        <a href="admin.php?page=<?php echo $url; ?>" class="nav-tab <?php if ($url == $page) :
            ?>nav-tab-active<?php
                                endif; ?>"><?php echo $title; ?></a>
    <?php endforeach; ?>
</nav>