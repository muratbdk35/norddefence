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
	$de = cdn_services_de();
	if ( 'en' !== cdn_lang() ) {
		return $de;
	}
	$en = cdn_services_en();
	foreach ( $de as $i => $s ) {
		$de[ $i ] = array_merge( $s, $en[ $s['id'] ] ?? array() );
	}
	return $de;
}

function cdn_services_de() {
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

function cdn_url_contact( $lang = null ) {
	$lang = $lang ?? cdn_lang();
	return 'en' === $lang ? home_url( '/en/contact/' ) : cdn_page_url( array( 'kontakt', 'contact' ), '/#kontakt' );
}
function cdn_url_services( $lang = null ) {
	$lang = $lang ?? cdn_lang();
	return 'en' === $lang ? home_url( '/en/services/' ) : cdn_page_url( array( 'leistungen', 'services' ), '/#leistungen' );
}
function cdn_url_home() {
	return 'en' === cdn_lang() ? home_url( '/en/' ) : home_url( '/' );
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

/** Englische Texte der Leistungen (Schlüssel = id). */
function cdn_services_en() {
	return array(
		'cloud'       => array(
			'title'  => 'Cloud & IT Support',
			'short'  => 'We secure your cloud infrastructure and keep your systems running through reliable IT support.',
			'long'   => 'Whether Microsoft 365, private cloud or a hybrid setup: we harden your cloud services, set up secure access and make sure your systems keep running – and stay protected – with dependable IT support.',
			'points' => array( 'Hardening and configuration review of cloud environments', 'Identity and access management (MFA, role concepts)', 'Backup and recovery concepts', 'Ongoing IT support with dedicated contacts' ),
		),
		'penetration' => array(
			'title'  => 'Penetration Testing & TLPT',
			'short'  => 'Through thorough penetration tests and Threat-Led Penetration Testing (TLPT) we identify vulnerabilities and give concrete recommendations.',
			'long'   => 'We attack your systems in a controlled way before someone else does. You receive a clear report with prioritised vulnerabilities and concrete remediation advice.',
			'points' => array( 'Web, network and infrastructure penetration tests', 'Threat-Led Penetration Testing (TLPT) based on realistic attack scenarios', 'Prioritised report with clear actions', 'Retest to verify remediation' ),
		),
		'siem'        => array(
			'title'  => 'SIEM & SOC Integration',
			'short'  => 'We provide modern SIEM solutions and integrate Security Operations Centers (SOC) for round-the-clock monitoring and fast incident response.',
			'long'   => 'We make your security posture visible: from selecting and introducing a SIEM solution to connecting a Security Operations Center for continuous monitoring.',
			'points' => array( 'Selection, rollout and tuning of SIEM solutions', 'Log source onboarding and use-case development', 'SOC integration with 24/7 monitoring', 'Incident response processes and escalation paths' ),
		),
		'threat'      => array(
			'title'  => 'Threat Intelligence & Threat Hunting',
			'short'  => 'Advanced threat analysis and proactive threat hunting protect your systems from unseen dangers.',
			'long'   => 'Reactive security is no longer enough. We analyse the current threats relevant to your industry and actively search your environment for signs of an attack.',
			'points' => array( 'Threat landscape reports for your industry', 'Proactive search for indicators of compromise', 'Enriching your detection with threat intelligence data', 'Recommendations instead of data floods' ),
		),
		'isms'        => array(
			'title'  => 'ISMS & ISO Consulting',
			'short'  => 'We support you in building information security management systems (ISMS) and advise on ISO 27001 and ISO 31000 standards.',
			'long'   => 'We guide you from gap analysis to certification readiness: pragmatic, tailored to your organisation and without unnecessary paperwork.',
			'points' => array( 'Gap analysis and ISMS implementation according to ISO 27001', 'Risk management according to ISO 31000', 'Policies, processes and training', 'Preparation for certification audits' ),
		),
		'audit'       => array(
			'title'  => 'Internal & External Audits',
			'short'  => 'With independent internal and external audits we review your security processes objectively and thoroughly.',
			'long'   => 'Independent audits give you and your customers confidence. We review processes, technology and organisation and show you where you stand and what to do next.',
			'points' => array( 'Internal audits as preparation for external reviews', 'Independent external security audits', 'Supplier and service provider assessments', 'Clear final report with an action plan' ),
		),
	);
}
