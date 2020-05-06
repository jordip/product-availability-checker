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

$tabs = array(
	'pac'      => __('Settings', 'pac'),
	'pac-scan' => __('Scan and check', 'pac'),
);
?>

<nav class="navbar" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item" href="#">
			<img src="<?php echo plugins_url('../../assets/icon-128x128.png', dirname(__FILE__)); ?>" width="28" height="28">
		</a>
	</div>

	<div id="pac-navBar" class="navbar-menu">
		<div class="navbar-start">

			<?php foreach ($tabs as $url => $title) : ?>
				<a href="admin.php?page=<?php echo $url; ?>" class="navbar-item <?php if ($url == $page) : ?>is-active<?php endif; ?>"><?php echo $title; ?></a>
			<?php endforeach; ?>
		</div>
		<div class="navbar-end">
			<div class="navbar-item has-dropdown is-hoverable">
				<a class="navbar-link">
					More
				</a>

				<div class="navbar-dropdown is-right">
					<a class="navbar-item" target="_blank" href="https://wordpress.org/plugins/product-availability-checker/">
						About
					</a>
					<hr class="navbar-divider">
					<a class="navbar-item" target="_blank" href="https://wordpress.org/support/plugin/product-availability-checker/">
						Report an issue
					</a>
				</div>
			</div>
		</div>

	</div>
</nav>