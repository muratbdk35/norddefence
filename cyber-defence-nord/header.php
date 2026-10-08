<!doctype html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#main"><?php cdn_e( 'Zum Inhalt springen', 'Skip to content' ); ?></a>

<header class="site-header" id="top">
	<div class="container site-header__inner">
		<div class="brand"><?php echo cdn_logo(); // phpcs:ignore ?></div>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="primary-nav">
			<span class="screen-reader-text"><?php cdn_e( 'Menü', 'Menu' ); ?></span>
			<span class="nav-toggle__bar"></span>
		</button>

		<nav class="nav" id="primary-nav" aria-label="<?php cdn_e( 'Hauptmenü', 'Main menu' ); ?>">
			<?php
			if ( 'en' === cdn_lang() ) {
				cdn_menu_fallback();
			} else {
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'nav__list',
				'depth'          => 2,
				'fallback_cb'    => 'cdn_menu_fallback',
			) );
			}
			$alt = cdn_alt_urls();
			?>
			<div class="lang" role="group" aria-label="Language / Sprache">
				<a href="<?php echo esc_url( $alt['de'] ); ?>" hreflang="de" lang="de"<?php echo 'de' === cdn_lang() ? ' aria-current="true"' : ''; ?>>DE</a>
				<a href="<?php echo esc_url( $alt['en'] ); ?>" hreflang="en" lang="en"<?php echo 'en' === cdn_lang() ? ' aria-current="true"' : ''; ?>>EN</a>
			</div>
			<a class="btn btn--primary btn--sm nav__cta" href="<?php echo esc_url( cdn_url_contact() ); ?>"><?php cdn_e( 'Beratung anfragen', 'Request a consultation' ); ?></a>
		</nav>
	</div>
</header>

<main id="main" class="site-main">
