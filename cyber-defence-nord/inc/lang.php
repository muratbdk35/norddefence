<?php
/**
 * Zweisprachigkeit (DE/EN) ohne Plugin.
 * Deutsch bleibt Standard. Englisch: /en/, /en/services/, /en/contact/ (Theme-Templates).
 * Redaktionelle Seiten (Über uns, Impressum, Datenschutz) bleiben deutsch.
 */

function cdn_view() {
	$v = get_query_var( 'cdn_view' );
	return in_array( $v, array( 'home', 'services', 'contact' ), true ) ? $v : '';
}

function cdn_lang() {
	if ( 'en' === get_query_var( 'cdn_lang' ) ) {
		return 'en';
	}
	// Formular-Verarbeitung (admin-post.php) kennt die Query-Variable nicht.
	if ( isset( $_POST['cdn_lang'] ) && 'en' === $_POST['cdn_lang'] ) { // phpcs:ignore WordPress.Security.NonceVerification
		return 'en';
	}
	return 'de';
}

/** Text je nach Sprache. */
function cdn_t( $de, $en ) {
	return 'en' === cdn_lang() ? $en : $de;
}

add_filter( 'query_vars', function ( $vars ) {
	$vars[] = 'cdn_lang';
	$vars[] = 'cdn_view';
	return $vars;
} );

add_action( 'init', function () {
	add_rewrite_rule( '^en/?$', 'index.php?cdn_lang=en&cdn_view=home', 'top' );
	add_rewrite_rule( '^en/services/?$', 'index.php?cdn_lang=en&cdn_view=services', 'top' );
	add_rewrite_rule( '^en/contact/?$', 'index.php?cdn_lang=en&cdn_view=contact', 'top' );
	if ( get_option( 'cdn_rewrite_ver' ) !== '1' ) {
		flush_rewrite_rules( false );
		update_option( 'cdn_rewrite_ver', '1' );
	}
} );
add_action( 'after_switch_theme', function () {
	delete_option( 'cdn_rewrite_ver' );
} );

add_filter( 'template_include', function ( $template ) {
	$map  = array( 'home' => 'front-page.php', 'services' => 'template-leistungen.php', 'contact' => 'template-kontakt.php' );
	$view = cdn_view();
	if ( $view && ( $file = locate_template( $map[ $view ] ) ) ) {
		status_header( 200 );
		return $file;
	}
	return $template;
}, 20 );

add_filter( 'language_attributes', function ( $out ) {
	return 'en' === cdn_lang() ? preg_replace( '/lang="[^"]*"/', 'lang="en-US"', $out ) : $out;
} );

/** URL der jeweils anderen Sprachversion (nur für Seiten, die es in beiden Sprachen gibt). */
function cdn_alt_urls() {
	$view = cdn_view();
	if ( ! $view && is_front_page() ) {
		$view = 'home';
	} elseif ( ! $view && is_page() ) {
		$slug = get_post_field( 'post_name', get_queried_object_id() );
		$view = in_array( $slug, array( 'leistungen', 'services' ), true ) ? 'services' : ( in_array( $slug, array( 'kontakt', 'contact' ), true ) ? 'contact' : '' );
	}
	$de = array( 'home' => home_url( '/' ), 'services' => cdn_url_services( 'de' ), 'contact' => cdn_url_contact( 'de' ) );
	$en = array( 'home' => home_url( '/en/' ), 'services' => home_url( '/en/services/' ), 'contact' => home_url( '/en/contact/' ) );
	if ( ! $view ) {
		return array( 'de' => home_url( '/' ), 'en' => home_url( '/en/' ) );
	}
	return array( 'de' => $de[ $view ], 'en' => $en[ $view ] );
}

add_action( 'wp_head', function () {
	$alt = cdn_alt_urls();
	if ( cdn_view() || is_front_page() || is_page() ) {
		printf( '<link rel="alternate" hreflang="de" href="%s">' . "\n", esc_url( $alt['de'] ) );
		printf( '<link rel="alternate" hreflang="en" href="%s">' . "\n", esc_url( $alt['en'] ) );
	}
}, 3 );

/** Text je nach Sprache ausgeben (escaped). */
function cdn_e( $de, $en ) {
	echo esc_html( cdn_t( $de, $en ) );
}
