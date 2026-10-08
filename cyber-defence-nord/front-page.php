<?php get_header(); $services = cdn_services(); ?>

<section class="hero">
	<div class="container hero__inner">
		<div class="hero__copy">
			<p class="eyebrow eyebrow--light">IT-Sicherheit aus Hamburg</p>
			<h1>Wir verteidigen, was Ihr Unternehmen&nbsp;ausmacht.</h1>
			<p class="hero__lead">Cyber Defence Nord schützt Unternehmen, Behörden und kritische Infrastrukturen in Norddeutschland – mit Threat Intelligence, Penetrationstests, SIEM/SOC und ISO&#8209;27001&#8209;Beratung. Proaktiv, professionell und persönlich.</p>
			<div class="hero__actions">
				<a class="btn btn--light btn--lg" href="<?php echo esc_url( cdn_url_contact() ); ?>">Kostenloses Erstgespräch <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
				<a class="btn btn--ghost btn--lg" href="#leistungen">Leistungen ansehen</a>
			</div>
			<ul class="hero__chips">
				<li><?php echo cdn_icon( 'pin', 18 ); // phpcs:ignore ?> Sitz in Hamburg</li>
				<li><?php echo cdn_icon( 'clock', 18 ); // phpcs:ignore ?> 24/7-Überwachung</li>
				<li><?php echo cdn_icon( 'lock', 18 ); // phpcs:ignore ?> Vertraulich &amp; DSGVO-konform</li>
			</ul>
		</div>
		<div class="hero__visual" aria-hidden="true">
			<div class="radar"><span></span><span></span><span></span></div>
			<div class="hero__mark"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo-mark.png' ); ?>" width="140" height="170" alt=""></div>
		</div>
	</div>
</section>

<section class="section section--services" id="leistungen">
	<div class="container">
		<div class="section__head reveal">
			<p class="eyebrow">Leistungen</p>
			<h2>Sicherheit, die zu Ihrer Organisation passt</h2>
			<p>Von der Analyse bis zum laufenden Betrieb: Wir decken die Bausteine ab, die Ihre Cyber-Resilienz wirklich stärken.</p>
		</div>
		<div class="cards">
			<?php foreach ( $services as $s ) : ?>
				<a class="card reveal" href="<?php echo esc_url( cdn_url_services() . '#' . $s['id'] ); ?>">
					<span class="card__icon"><?php echo cdn_icon( $s['icon'], 28 ); // phpcs:ignore ?></span>
					<h3><?php echo esc_html( $s['title'] ); ?></h3>
					<p><?php echo esc_html( $s['short'] ); ?></p>
					<span class="card__more">Mehr erfahren <?php echo cdn_icon( 'arrow', 16 ); // phpcs:ignore ?></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<section class="section section--tint">
	<div class="container split">
		<div class="reveal">
			<p class="eyebrow">Warum Cyber Defence Nord</p>
			<h2>Regionale Nähe, internationale Standards</h2>
			<p>Ob Unternehmen, Behörde oder Organisation – wir sichern Ihre digitale Infrastruktur mit maßgeschneiderten Lösungen. Unsere Expertinnen und Experten analysieren Risiken frühzeitig, entwickeln präventive Sicherheitsstrategien und begleiten Sie bei der nachhaltigen Umsetzung.</p>
			<a class="btn btn--primary" href="<?php echo esc_url( cdn_url_about() ); ?>">Mehr über uns <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
		</div>
		<ul class="features reveal">
			<li><span><?php echo cdn_icon( 'layers', 24 ); // phpcs:ignore ?></span><div><h3>Individuelle Sicherheitskonzepte</h3><p>Maßgeschneidert auf Ihre IT-Systeme und Risiken – keine Lösungen von der Stange.</p></div></li>
			<li><span><?php echo cdn_icon( 'radar', 24 ); // phpcs:ignore ?></span><div><h3>24/7-Monitoring &amp; Incident Response</h3><p>Schnelle Erkennung und Reaktion, wenn es darauf ankommt.</p></div></li>
			<li><span><?php echo cdn_icon( 'users', 24 ); // phpcs:ignore ?></span><div><h3>Kompetente Beratung</h3><p>Feste Ansprechpersonen, die Ihre Organisation und Ihre Region kennen.</p></div></li>
			<li><span><?php echo cdn_icon( 'lock', 24 ); // phpcs:ignore ?></span><div><h3>Vertraulichkeit &amp; Datensicherheit</h3><p>Sorgfältiger Umgang mit Ihren Daten – von der ersten Anfrage an.</p></div></li>
		</ul>
	</div>
</section>

<section class="section section--dark">
	<div class="container">
		<div class="section__head reveal">
			<p class="eyebrow">So arbeiten wir</p>
			<h2>In vier Schritten zu mehr Sicherheit</h2>
		</div>
		<ol class="steps">
			<li class="reveal"><span class="steps__n">01</span><h3>Analyse</h3><p>Wir verschaffen uns ein klares Bild Ihrer Systeme, Prozesse und Risiken.</p></li>
			<li class="reveal"><span class="steps__n">02</span><h3>Konzept</h3><p>Sie erhalten priorisierte Maßnahmen – verständlich und umsetzbar.</p></li>
			<li class="reveal"><span class="steps__n">03</span><h3>Umsetzung</h3><p>Wir setzen Maßnahmen gemeinsam mit Ihrem Team um oder begleiten sie.</p></li>
			<li class="reveal"><span class="steps__n">04</span><h3>Betrieb</h3><p>Monitoring, Audits und Weiterentwicklung – damit der Schutz bleibt.</p></li>
		</ol>
	</div>
</section>

<section class="cta-band">
	<div class="container cta-band__inner">
		<div>
			<h2>Sind Sie bereit für höchste Cyber-Sicherheit?</h2>
			<p>Sprechen Sie mit uns – unverbindlich und vertraulich.</p>
		</div>
		<a class="btn btn--light btn--lg" href="#kontakt">Jetzt Kontakt aufnehmen <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
	</div>
</section>

<section class="section" id="kontakt">
	<div class="container split split--form">
		<div class="reveal">
			<p class="eyebrow">Kontakt</p>
			<h2>Schreiben Sie uns</h2>
			<p>Schildern Sie kurz Ihr Anliegen. Wir melden uns zeitnah mit einem Vorschlag für das weitere Vorgehen.</p>
			<ul class="contact-list">
				<?php if ( cdn_contact( 'email' ) ) : ?>
					<li><?php echo cdn_icon( 'mail', 22 ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( antispambot( cdn_contact( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( cdn_contact( 'email' ) ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( cdn_contact( 'phone' ) ) : ?>
					<li><?php echo cdn_icon( 'phone', 22 ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', cdn_contact( 'phone' ) ) ); ?>"><?php echo esc_html( cdn_contact( 'phone' ) ); ?></a></li>
				<?php endif; ?>
				<li><?php echo cdn_icon( 'pin', 22 ); // phpcs:ignore ?><span><?php echo esc_html( trim( cdn_contact( 'address' ) . ' ' . cdn_contact( 'city' ) ) ); ?></span></li>
			</ul>
		</div>
		<div class="panel reveal"><?php cdn_contact_form(); ?></div>
	</div>
</section>

<?php get_footer();
