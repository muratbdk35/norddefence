<?php get_header(); $services = cdn_services(); ?>

<section class="hero">
	<div class="container">
		<div class="hero__meta">
			<p class="hero__tag">IT-Sicherheit<br>aus Hamburg</p>
			<p class="hero__coord" aria-hidden="true">53°33′ N · 9°59′ O</p>
		</div>
		<div class="hero__main">
			<h1>Wir greifen an, bevor es andere tun.</h1>
			<p class="hero__lead">Penetrationstests, Threat Hunting, SIEM/SOC und ISO&#8209;27001&#8209;Beratung für Unternehmen und Behörden in Norddeutschland. Von Menschen, die Sie persönlich kennen.</p>
			<div class="hero__actions">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( cdn_url_contact() ); ?>">Erstgespräch vereinbaren <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
				<a class="link-arrow" href="#leistungen">Leistungen</a>
			</div>
		</div>
	</div>
	<?php get_template_part( 'inc/skyline' ); ?>
</section>

<section class="section index" id="leistungen">
	<div class="container">
		<div class="index__head reveal">
			<p class="label">Leistungen</p>
			<h2>Sechs Bausteine. Jeder für sich einsetzbar.</h2>
		</div>
		<ol class="index__list">
			<?php foreach ( $services as $i => $s ) : ?>
				<li class="reveal">
					<a class="index__row" href="<?php echo esc_url( cdn_url_services() . '#' . $s['id'] ); ?>">
						<span class="index__n"><?php echo esc_html( sprintf( '%02d', $i + 1 ) ); ?></span>
						<span class="index__title"><?php echo esc_html( $s['title'] ); ?></span>
						<span class="index__text"><?php echo esc_html( $s['short'] ); ?></span>
						<span class="index__go" aria-hidden="true"><?php echo cdn_icon( 'arrow', 22 ); // phpcs:ignore ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>

<section class="section stance">
	<div class="container stance__grid">
		<div class="stance__lead reveal">
			<p class="label">Haltung</p>
			<p class="stance__quote">Sicherheit ist kein Produkt, das man kauft, sondern eine Gewohnheit, die man pflegt.</p>
		</div>
		<dl class="stance__list reveal">
			<div><dt>Maßgeschneidert</dt><dd>Konzepte, die zu Ihren Systemen und Risiken passen – keine Lösungen von der Stange.</dd></div>
			<div><dt>Persönlich</dt><dd>Feste Ansprechpersonen, die Ihre Organisation und Ihre Region kennen.</dd></div>
			<div><dt>Verständlich</dt><dd>Priorisierte Maßnahmen statt Datenflut. Sie wissen, was als Nächstes zu tun ist.</dd></div>
			<div><dt>Vertraulich</dt><dd>Sorgfältiger Umgang mit Ihren Daten – von der ersten Anfrage an.</dd></div>
		</dl>
	</div>
</section>

<section class="section process">
	<div class="container">
		<p class="label label--light reveal">Vorgehen</p>
		<ol class="process__list">
			<li class="reveal"><span>1</span><h3>Analyse</h3><p>Wir verschaffen uns ein klares Bild Ihrer Systeme, Prozesse und Risiken.</p></li>
			<li class="reveal"><span>2</span><h3>Konzept</h3><p>Sie erhalten priorisierte Maßnahmen – verständlich und umsetzbar.</p></li>
			<li class="reveal"><span>3</span><h3>Umsetzung</h3><p>Wir setzen gemeinsam mit Ihrem Team um oder begleiten Sie dabei.</p></li>
			<li class="reveal"><span>4</span><h3>Betrieb</h3><p>Monitoring, Audits, Weiterentwicklung – damit der Schutz bleibt.</p></li>
		</ol>
	</div>
</section>

<section class="section" id="kontakt">
	<div class="container split split--form">
		<div class="reveal">
			<p class="label">Kontakt</p>
			<h2>Erzählen Sie uns, was Sie beschäftigt.</h2>
			<p>Ein paar Sätze genügen. Wir melden uns mit einem Vorschlag für das weitere Vorgehen.</p>
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
