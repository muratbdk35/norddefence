<?php
/**
 * Cyber Defence Nord – Theme-Funktionen
 */
defined( 'ABSPATH' ) || exit;

define( 'CDN_VERSION', '1.0.0' );

require_once get_template_directory() . '/inc/icons.php';
require_once get_template_directory() . '/inc/lang.php';
require_once get_template_directory() . '/inc/content.php';

/* ---------------------------------------------------------------- Setup */

add_action( 'after_setup_theme', function () {
	load_theme_textdomain( 'cdn', get_template_directory() . '/languages' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor.css' );
	add_theme_support( 'automatic-feed-links' );
	register_nav_menus( array(
		'primary' => 'Hauptmenü',
		'footer'  => 'Footer (rechtliche Links)',
	) );
	add_image_size( 'cdn-card', 800, 520, true );
} );

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();
	wp_enqueue_style( 'cdn-main', $uri . '/assets/css/main.css', array(), filemtime( $dir . '/assets/css/main.css' ) );
	wp_enqueue_script( 'cdn-main', $uri . '/assets/js/main.js', array(), filemtime( $dir . '/assets/js/main.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
} );

add_action( 'wp_head', function () {
	$uri = get_template_directory_uri();
	if ( ! has_site_icon() ) {
		printf( '<link rel="icon" type="image/png" sizes="32x32" href="%s">' . "\n", esc_url( $uri . '/assets/img/icon-32.png' ) );
		printf( '<link rel="apple-touch-icon" href="%s">' . "\n", esc_url( $uri . '/assets/img/icon-192.png' ) );
	}
	echo '<meta name="theme-color" content="#06324f">' . "\n";
}, 2 );

/** Logo: immer das mitgelieferte, freigestellte PNG (ein evtl. alt gesetztes Custom Logo wird bewusst ignoriert). */
function cdn_logo( $class = 'brand__logo' ) {
	return sprintf(
		'<a href="%s" class="brand__link" rel="home" aria-label="%s"><img class="%s" src="%s" width="420" height="180" alt="%s" fetchpriority="high" decoding="async"></a>',
		esc_url( cdn_url_home() ),
		esc_attr( get_bloginfo( 'name' ) ),
		esc_attr( $class ),
		esc_url( get_template_directory_uri() . '/assets/img/logo.png' ),
		esc_attr( get_bloginfo( 'name' ) )
	);
}

/** Fallback-Menü, solange noch kein Menü zugewiesen ist. */
function cdn_menu_fallback() {
	$items = array(
		cdn_t( 'Start', 'Home' )         => cdn_url_home(),
		cdn_t( 'Leistungen', 'Services' ) => cdn_url_services(),
		cdn_t( 'Über uns', 'About us (DE)' ) => cdn_url_about(),
		cdn_t( 'Kontakt', 'Contact' )    => cdn_url_contact(),
	);
	echo '<ul class="nav__list">';
	foreach ( $items as $label => $url ) {
		printf( '<li class="menu-item"><a href="%s">%s</a></li>', esc_url( $url ), esc_html( $label ) );
	}
	echo '</ul>';
}

/* ----------------------------------------------------------- Customizer */

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'cdn_contact', array( 'title' => 'Kontaktdaten (Cyber Defence Nord)', 'priority' => 30 ) );
	$fields = array(
		'phone'     => array( 'Telefon', 'sanitize_text_field' ),
		'email'     => array( 'E-Mail (Anzeige)', 'sanitize_email' ),
		'recipient' => array( 'Empfänger für Kontaktformular (leer = Admin-E-Mail)', 'sanitize_email' ),
		'address'   => array( 'Anschrift (z. B. Straße, PLZ Hamburg)', 'sanitize_text_field' ),
		'linkedin'  => array( 'LinkedIn-URL', 'esc_url_raw' ),
	);
	foreach ( $fields as $key => $f ) {
		$wp_customize->add_setting( 'cdn_' . $key, array( 'default' => '', 'sanitize_callback' => $f[1] ) );
		$wp_customize->add_control( 'cdn_' . $key, array( 'label' => $f[0], 'section' => 'cdn_contact', 'type' => 'text' ) );
	}
} );

/* ------------------------------------------------------------------ SEO */

add_filter( 'document_title_parts', function ( $parts ) {
	if ( 'en' === cdn_lang() ) {
		$titles = array( 'home' => 'IT Security from Hamburg', 'services' => 'Services', 'contact' => 'Contact' );
		$parts['title']   = $titles[ cdn_view() ] ?? $parts['title'];
		$parts['tagline'] = '';
		$parts['site']    = 'Cyber Defence Nord';
		return $parts;
	}
	if ( is_front_page() ) {
		$parts['title']   = 'IT-Sicherheit aus Hamburg';
		$parts['tagline'] = '';
		$parts['site']    = 'Cyber Defence Nord';
	}
	return $parts;
} );
add_filter( 'document_title_separator', fn() => '–' );

function cdn_meta_description() {
	if ( 'en' === cdn_lang() ) {
		return 'Cyber Defence Nord: IT security from Hamburg. Penetration testing, SIEM & SOC integration, threat intelligence, ISMS according to ISO 27001 and audits for companies, public bodies and critical infrastructure in northern Germany.';
	}
	if ( is_front_page() ) {
		return 'Cyber Defence Nord: IT-Sicherheit aus Hamburg. Penetrationstests, SIEM- & SOC-Integration, Threat Intelligence, ISMS nach ISO 27001 und Audits für Unternehmen, Behörden und kritische Infrastrukturen in Norddeutschland.';
	}
	if ( is_singular() ) {
		$post = get_post();
		$text = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		$text = trim( preg_replace( '/\s+/', ' ', $text ) );
		return $text ? wp_trim_words( $text, 28, '…' ) : '';
	}
	return '';
}

add_action( 'wp_head', function () {
	$desc = cdn_meta_description();
	if ( $desc ) {
		printf( '<meta name="description" content="%s">' . "\n", esc_attr( $desc ) );
		printf( '<meta property="og:description" content="%s">' . "\n", esc_attr( $desc ) );
	}
	printf( '<meta property="og:title" content="%s">' . "\n", esc_attr( wp_get_document_title() ) );
	echo '<meta property="og:type" content="website">' . "\n";
	printf( '<meta property="og:site_name" content="%s">' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
	printf( '<meta property="og:image" content="%s">' . "\n", esc_url( get_template_directory_uri() . '/assets/img/icon-512.png' ) );
	echo '<meta property="og:locale" content="' . ( 'en' === cdn_lang() ? 'en_US' : 'de_DE' ) . '">' . "\n";

	if ( is_front_page() || 'home' === cdn_view() ) {
		$ld = array(
			'@context'    => 'https://schema.org',
			'@type'       => 'ProfessionalService',
			'name'        => 'Cyber Defence Nord',
			'url'         => home_url( '/' ),
			'logo'        => get_template_directory_uri() . '/assets/img/logo.png',
			'email'       => cdn_contact( 'email' ),
			'telephone'   => cdn_contact( 'phone' ),
			'areaServed'  => cdn_t( 'Norddeutschland', 'Northern Germany' ),
			'address'     => array( '@type' => 'PostalAddress', 'addressLocality' => cdn_contact( 'city' ), 'addressCountry' => 'DE' ),
		);
		echo '<script type="application/ld+json">' . wp_json_encode( $ld, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . '</script>' . "\n";
	}
}, 5 );

/* ------------------------------------------------------------ Hardening */

// Versions- und Fingerprint-Angaben entfernen.
remove_action( 'wp_head', 'wp_generator' );
remove_action( 'wp_head', 'rsd_link' );
remove_action( 'wp_head', 'wlwmanifest_link' );
remove_action( 'wp_head', 'wp_shortlink_wp_head' );
remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
add_filter( 'the_generator', '__return_empty_string' );

// XML-RPC aus.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'wp_headers', function ( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
} );

// Benutzerliste nicht öffentlich ausgeben (REST, Autorenseiten, Sitemap).
add_filter( 'rest_endpoints', function ( $endpoints ) {
	if ( ! is_user_logged_in() ) {
		unset( $endpoints['/wp/v2/users'], $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
	}
	return $endpoints;
} );
add_filter( 'wp_sitemaps_add_provider', function ( $provider, $name ) {
	return 'users' === $name ? false : $provider;
}, 10, 2 );
add_action( 'template_redirect', function () {
	if ( is_author() || ( isset( $_GET['author'] ) && ! is_admin() ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
} );
add_filter( 'author_link', fn() => home_url( '/' ) );

// Emojis nicht nachladen.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Sicherheits-Header.
add_action( 'send_headers', function () {
	if ( is_admin() ) {
		return;
	}
	header( 'X-Content-Type-Options: nosniff' );
	header( 'X-Frame-Options: SAMEORIGIN' );
	header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	header( 'Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()' );
	if ( is_ssl() ) {
		header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains' );
	}
} );

/* ------------------------------------------------------ Kontaktformular */

function cdn_contact_token() {
	$t = time();
	return $t . '.' . wp_hash( 'cdn_contact|' . $t );
}

function cdn_contact_redirect( $status ) {
	$back = wp_get_referer() ?: cdn_url_contact();
	$back = remove_query_arg( array( 'cdn' ), $back );
	wp_safe_redirect( add_query_arg( 'cdn', $status, $back ) . '#kontakt-form' );
	exit;
}

function cdn_handle_contact() {
	if ( ! isset( $_POST['cdn_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['cdn_nonce'] ) ), 'cdn_contact' ) ) {
		cdn_contact_redirect( 'invalid' );
	}
	// Honeypot gefüllt -> still verwerfen.
	if ( ! empty( $_POST['website'] ) ) {
		cdn_contact_redirect( 'sent' );
	}
	// Zu schnell abgeschickt (Bot) oder Token manipuliert.
	$token = isset( $_POST['cdn_t'] ) ? sanitize_text_field( wp_unslash( $_POST['cdn_t'] ) ) : '';
	$parts = explode( '.', $token );
	if ( 2 !== count( $parts ) || ! hash_equals( wp_hash( 'cdn_contact|' . $parts[0] ), $parts[1] ) || time() - (int) $parts[0] < 3 || time() - (int) $parts[0] > DAY_IN_SECONDS ) {
		cdn_contact_redirect( 'invalid' );
	}
	// Rate-Limit: 5 Nachrichten pro Stunde und IP.
	$key   = 'cdn_rl_' . md5( $_SERVER['REMOTE_ADDR'] ?? 'x' );
	$count = (int) get_transient( $key );
	if ( $count >= 5 ) {
		cdn_contact_redirect( 'limit' );
	}

	$name    = sanitize_text_field( wp_unslash( $_POST['cdn_name'] ?? '' ) );
	$email   = sanitize_email( wp_unslash( $_POST['cdn_email'] ?? '' ) );
	$company = sanitize_text_field( wp_unslash( $_POST['cdn_company'] ?? '' ) );
	$phone   = sanitize_text_field( wp_unslash( $_POST['cdn_phone'] ?? '' ) );
	$topic   = sanitize_text_field( wp_unslash( $_POST['cdn_topic'] ?? '' ) );
	$message = sanitize_textarea_field( wp_unslash( $_POST['cdn_message'] ?? '' ) );
	$consent = ! empty( $_POST['cdn_consent'] );

	if ( '' === $name || ! is_email( $email ) || strlen( $message ) < 10 || ! $consent ) {
		cdn_contact_redirect( 'missing' );
	}

	$to = cdn_contact( 'recipient' ) ?: get_option( 'admin_email' );
	$body = "Neue Anfrage über cyberdefencenord.de\n\n"
		. "Name: $name\nE-Mail: $email\nFirma: $company\nTelefon: $phone\nThema: $topic\n\n"
		. "Nachricht:\n$message\n";
	$headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );
	$ok = wp_mail( $to, '[Website] Anfrage: ' . ( $topic ?: 'Kontakt' ) . ' – ' . $name, $body, $headers );

	set_transient( $key, $count + 1, HOUR_IN_SECONDS );
	cdn_contact_redirect( $ok ? 'sent' : 'error' );
}
add_action( 'admin_post_nopriv_cdn_contact', 'cdn_handle_contact' );
add_action( 'admin_post_cdn_contact', 'cdn_handle_contact' );

/** Formular ausgeben (wird auf Startseite und Kontakt-Template genutzt). */
function cdn_contact_form() {
	$status   = isset( $_GET['cdn'] ) ? sanitize_key( wp_unslash( $_GET['cdn'] ) ) : ''; // phpcs:ignore WordPress.Security.NonceVerification
	$messages = array(
		'sent'    => array( 'ok', cdn_t( 'Vielen Dank! Ihre Nachricht ist bei uns eingegangen. Wir melden uns in Kürze.', 'Thank you! We have received your message and will get back to you shortly.' ) ),
		'missing' => array( 'err', cdn_t( 'Bitte füllen Sie alle Pflichtfelder aus und stimmen Sie der Datenverarbeitung zu.', 'Please fill in all required fields and agree to the data processing.' ) ),
		'invalid' => array( 'err', cdn_t( 'Die Anfrage konnte nicht verifiziert werden. Bitte laden Sie die Seite neu und versuchen Sie es erneut.', 'The request could not be verified. Please reload the page and try again.' ) ),
		'limit'   => array( 'err', cdn_t( 'Zu viele Anfragen in kurzer Zeit. Bitte versuchen Sie es später erneut.', 'Too many requests in a short time. Please try again later.' ) ),
		'error'   => array( 'err', cdn_t( 'Die Nachricht konnte leider nicht gesendet werden. Bitte schreiben Sie uns direkt per E-Mail.', 'Your message could not be sent. Please email us directly.' ) ),
	);
	$topics = 'en' === cdn_lang()
		? array( 'General enquiry', 'Penetration test', 'SIEM / SOC', 'Threat intelligence', 'ISMS / ISO 27001', 'Audit', 'Cloud & IT support' )
		: array( 'Allgemeine Anfrage', 'Penetrationstest', 'SIEM / SOC', 'Threat Intelligence', 'ISMS / ISO 27001', 'Audit', 'Cloud & IT-Support' );
	?>
	<form class="form" id="kontakt-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php if ( isset( $messages[ $status ] ) ) : ?>
			<p class="form__notice form__notice--<?php echo esc_attr( $messages[ $status ][0] ); ?>" role="status"><?php echo esc_html( $messages[ $status ][1] ); ?></p>
		<?php endif; ?>
		<input type="hidden" name="action" value="cdn_contact">
		<input type="hidden" name="cdn_lang" value="<?php echo esc_attr( cdn_lang() ); ?>">
		<input type="hidden" name="cdn_t" value="<?php echo esc_attr( cdn_contact_token() ); ?>">
		<?php wp_nonce_field( 'cdn_contact', 'cdn_nonce' ); ?>
		<div class="form__hp" aria-hidden="true"><label>Website <input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>
		<div class="form__grid">
			<label class="field"><span>Name *</span><input type="text" name="cdn_name" required autocomplete="name"></label>
			<label class="field"><span><?php cdn_e( 'E-Mail *', 'Email *' ); ?></span><input type="email" name="cdn_email" required autocomplete="email"></label>
			<label class="field"><span><?php cdn_e( 'Unternehmen', 'Company' ); ?></span><input type="text" name="cdn_company" autocomplete="organization"></label>
			<label class="field"><span><?php cdn_e( 'Telefon', 'Phone' ); ?></span><input type="tel" name="cdn_phone" autocomplete="tel"></label>
		</div>
		<label class="field"><span><?php cdn_e( 'Thema', 'Topic' ); ?></span>
			<select name="cdn_topic">
				<?php foreach ( $topics as $t ) : ?>
					<option><?php echo esc_html( $t ); ?></option>
				<?php endforeach; ?>
			</select>
		</label>
		<label class="field"><span><?php cdn_e( 'Ihre Nachricht *', 'Your message *' ); ?></span><textarea name="cdn_message" rows="5" required minlength="10"></textarea></label>
		<label class="check">
			<input type="checkbox" name="cdn_consent" value="1" required>
			<span><?php if ( 'en' === cdn_lang() ) : ?>I have read the <a href="<?php echo esc_url( cdn_url_privacy() ); ?>">privacy policy</a> (German) and agree to my details being processed to handle my enquiry. *<?php else : ?>Ich habe die <a href="<?php echo esc_url( cdn_url_privacy() ); ?>">Datenschutzerklärung</a> gelesen und stimme der Verarbeitung meiner Angaben zur Bearbeitung der Anfrage zu. *<?php endif; ?></span>
		</label>
		<button type="submit" class="btn btn--primary btn--lg"><?php cdn_e( 'Nachricht senden', 'Send message' ); ?> <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></button>
	</form>
	<?php
}

/* ---------------------------------------------------- Seiten-Templates */

// Seiten mit bekanntem Slug nutzen automatisch das passende Template,
// auch wenn im Editor noch keines gewählt wurde.
add_filter( 'template_include', function ( $template ) {
	if ( ! is_page() || get_page_template_slug() ) {
		return $template;
	}
	$map = array(
		'services'   => 'template-leistungen.php',
		'leistungen' => 'template-leistungen.php',
		'kontakt'    => 'template-kontakt.php',
		'contact'    => 'template-kontakt.php',
	);
	$slug = get_post_field( 'post_name', get_queried_object_id() );
	if ( isset( $map[ $slug ] ) ) {
		$file = locate_template( $map[ $slug ] );
		if ( $file ) {
			return $file;
		}
	}
	return $template;
} );

/* ------------------------------------------------------- Performance */

// Neue Uploads automatisch als WebP erzeugen (deutlich kleiner als PNG/JPEG).
add_filter( 'image_editor_output_format', function ( $formats ) {
	$formats['image/png']  = 'image/webp';
	$formats['image/jpeg'] = 'image/webp';
	return $formats;
} );
add_filter( 'wp_editor_set_quality', fn() => 80 );
add_filter( 'big_image_size_threshold', fn() => 2000 );

// Browser-Caching-Hinweis für statische Theme-Dateien (falls der Server keinen setzt) ist Sache der .htaccess – siehe README.
