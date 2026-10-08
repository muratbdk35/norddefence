<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main">Zum Inhalt springen</a>

<header class="site-header" id="top">
	<div class="container site-header__inner">
		<div class="brand"><?php echo cdn_logo(); // phpcs:ignore ?></div>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
			<span class="screen-reader-text">Menü</span>
			<span class="nav-toggle__bar"></span>
		</button>

		<nav class="nav" id="primary-nav" aria-label="Hauptmenü">
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav__list',
				'depth'          => 2,
				'fallback_cb'    => 'cdn_menu_fallback',
			) );
			?>
			<a class="btn btn--primary btn--sm nav__cta" href="<?php echo esc_url( cdn_url_contact() ); ?>">Beratung anfragen</a>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
