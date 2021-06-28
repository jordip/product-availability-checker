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
	'pac'        => __('Settings', 'pac'),
	'pac-scan'   => __('Scan', 'pac'),
	'pac-report' => __('Reports', 'pac'),
);
?>

<nav id="pac-navbar" class="navbar is-white" role="navigation" aria-label="main navigation">
	<div class="navbar-brand">
		<a class="navbar-item" href="#">
			<img src="<?php echo plugins_url('../../assets/icon-128x128.png', dirname(__FILE__)); ?>" width="28" height="28">
		</a>
		<a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="pac-navbar-menu">
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
			<span aria-hidden="true"></span>
		</a>
	</div>

	<div id="pac-navbar-menu" class="navbar-menu">
		<div class="navbar-start">
			<?php foreach ($tabs as $url => $title) : ?>
				<a href="admin.php?page=<?php echo $url; ?>" class="navbar-item 
												   <?php
													if ($url == $page) :
													?>
					is-active is-tab<?php endif; ?>"><?php echo $title; ?></a>
			<?php endforeach; ?>
		</div>
		<div class="navbar-end">
			<div class="navbar-item has-dropdown is-hoverable">
				<a class="navbar-link">
					More
				</a>

				<div class="navbar-dropdown is-right">
					<a class="navbar-item" target="_blank" href="https://wordpress.org/support/plugin/product-availability-checker/">
						Report an issue
					</a>
				</div>
			</div>
		</div>

	</div>
</nav>