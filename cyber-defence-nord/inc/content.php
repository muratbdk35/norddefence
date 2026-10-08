<?php
/** Zentrale Inhalte & Kontaktdaten (über Customizer änderbar). */

function cdn_contact( $key ) {
	$defaults = array(
		'phone'         => '+49 44405254',
		'email'         => 'info@cyberdefencenord.de',
		'city'          => 'Hamburg',
		'address'       => '',
		'linkedin'      => '',
		'recipient'     => '',
	);
	$val = get_theme_mod( 'cdn_' . $key, '' );
	return '' !== $val ? $val : ( $defaults[ $key ] ?? '' );
}

function cdn_services() {
	return array(
		array(
			'id'     => 'cloud',
			'icon'   => 'cloud',
			'title'  => 'Cloud & IT-Support',
			'short'  => 'Wir sichern Ihre Cloud-Infrastruktur und gewährleisten durch unseren IT-Support die Kontinuität Ihrer Systeme.',
			'long'   => 'Ob Microsoft 365, Private Cloud oder hybride Umgebung: Wir härten Ihre Cloud-Dienste, richten sichere Zugriffe ein und sorgen mit verlässlichem IT-Support dafür, dass Ihre Systeme laufen – und geschützt bleiben.',
			'points' => array( 'Härtung und Konfigurationsprüfung von Cloud-Umgebungen', 'Identitäts- und Zugriffsmanagement (MFA, Rollenkonzepte)', 'Backup- und Wiederherstellungskonzepte', 'Laufender IT-Support mit festen Ansprechpersonen' ),
		),
		array(
			'id'     => 'penetration',
			'icon'   => 'target',
			'title'  => 'Penetrationstests & TLPT',
			'short'  => 'Durch umfassende Penetrationstests und Threat-Led Penetration Testing (TLPT) identifizieren wir Sicherheitslücken und geben konkrete Handlungsempfehlungen.',
			'long'   => 'Wir greifen Ihre Systeme kontrolliert an, bevor es andere tun. Sie erhalten einen nachvollziehbaren Bericht mit priorisierten Schwachstellen und konkreten Empfehlungen zur Behebung.',
			'points' => array( 'Web-, Netzwerk- und Infrastruktur-Penetrationstests', 'Threat-Led Penetration Testing (TLPT) nach realistischen Angriffsszenarien', 'Priorisierter Bericht mit klaren Maßnahmen', 'Nachtest zur Verifikation der Behebung' ),
		),
		array(
			'id'     => 'siem',
			'icon'   => 'radar',
			'title'  => 'SIEM- & SOC-Integration',
			'short'  => 'Wir bieten moderne SIEM-Lösungen sowie die Integration von Security Operations Centers (SOC) für eine 24/7-Überwachung und schnelle Reaktion auf Sicherheitsvorfälle.',
			'long'   => 'Wir machen Ihre Sicherheitslage sichtbar: von der Auswahl und Einführung einer SIEM-Lösung bis zur Anbindung an ein Security Operations Center für Überwachung rund um die Uhr.',
			'points' => array( 'Auswahl, Einführung und Tuning von SIEM-Lösungen', 'Anbindung von Log-Quellen und Use-Case-Entwicklung', 'SOC-Integration mit 24/7-Überwachung', 'Incident-Response-Prozesse und Eskalationswege' ),
		),
		array(
			'id'     => 'threat',
			'icon'   => 'eye',
			'title'  => 'Threat Intelligence & Threat Hunting',
			'short'  => 'Wir schützen Ihre Systeme mit fortschrittlicher Bedrohungsanalyse und proaktiver Bedrohungssuche vor unsichtbaren Gefahren.',
			'long'   => 'Reaktive Sicherheit reicht nicht mehr aus. Wir analysieren aktuelle Bedrohungen, die für Ihre Branche relevant sind, und suchen aktiv in Ihrer Umgebung nach Anzeichen für Angriffe.',
			'points' => array( 'Lagebilder zu Bedrohungen für Ihre Branche', 'Proaktive Suche nach Kompromittierungsindikatoren', 'Anreicherung Ihrer Erkennung mit Threat-Intelligence-Daten', 'Handlungsempfehlungen statt Datenflut' ),
		),
		array(
			'id'     => 'isms',
			'icon'   => 'layers',
			'title'  => 'ISMS & ISO-Beratung',
			'short'  => 'Wir unterstützen Sie beim Aufbau von Informationssicherheits-Managementsystemen (ISMS) und beraten Sie nach ISO 27001 und ISO 31000 Standards.',
			'long'   => 'Wir begleiten Sie von der Lückenanalyse bis zur Zertifizierungsreife: pragmatisch, auf Ihre Organisation zugeschnitten und ohne unnötigen Papieraufwand.',
			'points' => array( 'Gap-Analyse und Aufbau eines ISMS nach ISO 27001', 'Risikomanagement nach ISO 31000', 'Richtlinien, Prozesse und Schulungen', 'Vorbereitung auf Zertifizierungsaudits' ),
		),
		array(
			'id'     => 'audit',
			'icon'   => 'clipboard',
			'title'  => 'Interne & Externe Audits',
			'short'  => 'Mit unabhängigen internen und externen Audits prüfen wir Ihre Sicherheitsprozesse objektiv und fundiert.',
			'long'   => 'Unabhängige Audits geben Ihnen und Ihren Kunden Gewissheit. Wir prüfen Prozesse, Technik und Organisation und zeigen Ihnen, wo Sie stehen und was als Nächstes zu tun ist.',
			'points' => array( 'Interne Audits als Vorbereitung auf externe Prüfungen', 'Externe, unabhängige Sicherheitsaudits', 'Lieferanten- und Dienstleister-Prüfungen', 'Verständlicher Abschlussbericht mit Maßnahmenplan' ),
		),
	);
}

function cdn_page_url( array $slugs, $fallback = '' ) {
	foreach ( $slugs as $slug ) {
		$page = get_page_by_path( $slug );
		if ( $page && 'publish' === $page->post_status ) {
			return get_permalink( $page );
		}
	}
	return $fallback ? home_url( $fallback ) : home_url( '/' );
}

function cdn_url_contact() {
	return cdn_page_url( array( 'kontakt', 'contact' ), '/#kontakt' );
}
function cdn_url_services() {
	return cdn_page_url( array( 'leistungen', 'services' ), '/#leistungen' );
}
function cdn_url_about() {
	return cdn_page_url( array( 'ueber-uns', 'a', 'about' ), '/' );
}
function cdn_url_privacy() {
	return cdn_page_url( array( 'datenschutz', 'datenschutzerklaerung', 'pra' ), '/' );
}
function cdn_url_imprint() {
	return cdn_page_url( array( 'impressum' ), '/impressum/' );
}
