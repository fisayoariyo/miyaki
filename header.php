<?php
/**
 * Header template.
 *
 * @package Miyaki
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
	<script>
		(function(){try{var t=localStorage.getItem('miyaki-theme');if(t){document.documentElement.setAttribute('data-theme',t);}}catch(e){}})();
	</script>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'miyaki' ); ?></a>

	<header id="masthead" class="site-header">
		<div class="container header-inner">
			<div class="site-branding">
				<?php miyaki_site_branding(); ?>
			</div>

			<nav class="main-navigation" aria-label="<?php esc_attr_e( 'Primary', 'miyaki' ); ?>">
				<?php miyaki_primary_nav(); ?>
			</nav>

			<div class="header-actions">
				<?php miyaki_dark_mode_toggle(); ?>
				<?php miyaki_account_link(); ?>
				<?php miyaki_cart_link(); ?>
				<button type="button" class="menu-toggle header-action" aria-expanded="false" aria-controls="mobile-menu" data-menu-toggle>
					<span class="screen-reader-text"><?php esc_html_e( 'Menu', 'miyaki' ); ?></span>
					<span aria-hidden="true">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
					</span>
				</button>
			</div>
		</div>

		<div id="mobile-menu" class="mobile-menu" hidden>
			<div class="container">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'mobile',
						'menu_class'     => 'mobile-menu-list',
						'container'      => false,
						'fallback_cb'    => 'miyaki_fallback_menu',
					)
				);
				?>
			</div>
		</div>
	</header>
