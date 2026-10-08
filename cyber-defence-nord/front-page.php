<?php get_header(); $services = cdn_services(); ?>

<section class="hero">
	<div class="container">
		<div class="hero__meta">
			<p class="hero__tag"><?php echo 'en' === cdn_lang() ? 'IT security<br>from Hamburg' : 'IT-Sicherheit<br>aus Hamburg'; // phpcs:ignore ?></p>
			<p class="hero__coord" aria-hidden="true">53°33′ N · 9°59′ <?php echo 'en' === cdn_lang() ? 'E' : 'O'; ?></p>
		</div>
		<div class="hero__main">
			<h1><?php cdn_e( 'Wir greifen an, bevor es andere tun.', 'We attack before someone else does.' ); ?></h1>
			<p class="hero__lead"><?php cdn_e( 'Penetrationstests, Threat Hunting, SIEM/SOC und ISO‑27001‑Beratung für Unternehmen und Behörden in Norddeutschland. Von Menschen, die Sie persönlich kennen.', 'Penetration testing, threat hunting, SIEM/SOC and ISO 27001 consulting for companies and public bodies in northern Germany. From people you get to know personally.' ); ?></p>
			<div class="hero__actions">
				<a class="btn btn--primary btn--lg" href="<?php echo esc_url( cdn_url_contact() ); ?>"><?php cdn_e( 'Erstgespräch vereinbaren', 'Book an intro call' ); ?> <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
				<a class="link-arrow" href="#leistungen"><?php cdn_e( 'Leistungen', 'Services' ); ?></a>
			</div>
		</div>
	</div>
	<?php get_template_part( 'inc/skyline' ); ?>
</section>

<section class="section index" id="leistungen">
	<div class="container">
		<div class="index__head reveal">
			<p class="label"><?php cdn_e( 'Leistungen', 'Services' ); ?></p>
			<h2><?php cdn_e( 'Sechs Bausteine. Jeder für sich einsetzbar.', 'Six building blocks. Each one stands on its own.' ); ?></h2>
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
			<p class="label"><?php cdn_e( 'Haltung', 'Approach' ); ?></p>
			<p class="stance__quote"><?php cdn_e( 'Sicherheit ist kein Produkt, das man kauft, sondern eine Gewohnheit, die man pflegt.', 'Security is not a product you buy, but a habit you maintain.' ); ?></p>
		</div>
		<dl class="stance__list reveal">
			<div><dt><?php cdn_e( 'Maßgeschneidert', 'Tailored' ); ?></dt><dd><?php cdn_e( 'Konzepte, die zu Ihren Systemen und Risiken passen – keine Lösungen von der Stange.', 'Concepts that fit your systems and risks – no off-the-shelf solutions.' ); ?></dd></div>
			<div><dt><?php cdn_e( 'Persönlich', 'Personal' ); ?></dt><dd><?php cdn_e( 'Feste Ansprechpersonen, die Ihre Organisation und Ihre Region kennen.', 'Dedicated contacts who know your organisation and your region.' ); ?></dd></div>
			<div><dt><?php cdn_e( 'Verständlich', 'Clear' ); ?></dt><dd><?php cdn_e( 'Priorisierte Maßnahmen statt Datenflut. Sie wissen, was als Nächstes zu tun ist.', 'Prioritised actions instead of data floods. You know what to do next.' ); ?></dd></div>
			<div><dt><?php cdn_e( 'Vertraulich', 'Confidential' ); ?></dt><dd><?php cdn_e( 'Sorgfältiger Umgang mit Ihren Daten – von der ersten Anfrage an.', 'Careful handling of your data – from the very first enquiry.' ); ?></dd></div>
		</dl>
	</div>
</section>

<section class="section process">
	<div class="container">
		<p class="label label--light reveal"><?php cdn_e( 'Vorgehen', 'Process' ); ?></p>
		<ol class="process__list">
			<li class="reveal"><span>1</span><h3><?php cdn_e( 'Analyse', 'Analysis' ); ?></h3><p><?php cdn_e( 'Wir verschaffen uns ein klares Bild Ihrer Systeme, Prozesse und Risiken.', 'We build a clear picture of your systems, processes and risks.' ); ?></p></li>
			<li class="reveal"><span>2</span><h3><?php cdn_e( 'Konzept', 'Concept' ); ?></h3><p><?php cdn_e( 'Sie erhalten priorisierte Maßnahmen – verständlich und umsetzbar.', 'You receive prioritised measures – understandable and actionable.' ); ?></p></li>
			<li class="reveal"><span>3</span><h3><?php cdn_e( 'Umsetzung', 'Implementation' ); ?></h3><p><?php cdn_e( 'Wir setzen gemeinsam mit Ihrem Team um oder begleiten Sie dabei.', 'We implement together with your team or support you along the way.' ); ?></p></li>
			<li class="reveal"><span>4</span><h3><?php cdn_e( 'Betrieb', 'Operations' ); ?></h3><p><?php cdn_e( 'Monitoring, Audits, Weiterentwicklung – damit der Schutz bleibt.', 'Monitoring, audits, continuous improvement – so the protection lasts.' ); ?></p></li>
		</ol>
	</div>
</section>

<section class="section" id="kontakt">
	<div class="container split split--form">
		<div class="reveal">
			<p class="label"><?php cdn_e( 'Kontakt', 'Contact' ); ?></p>
			<h2><?php cdn_e( 'Erzählen Sie uns, was Sie beschäftigt.', 'Tell us what is on your mind.' ); ?></h2>
			<p><?php cdn_e( 'Ein paar Sätze genügen. Wir melden uns mit einem Vorschlag für das weitere Vorgehen.', 'A few sentences are enough. We will get back to you with a proposal for next steps.' ); ?></p>
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
