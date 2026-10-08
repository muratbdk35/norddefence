</main>

<footer class="site-footer">
	<div class="container footer__grid">
		<div class="footer__brand">
			<a class="footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="Cyber Defence Nord – Startseite">
				<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/img/logo.png' ); ?>" width="150" height="64" alt="Cyber Defence Nord" loading="lazy">
			</a>
			<p>IT-Sicherheit aus Hamburg – für Unternehmen, Behörden und kritische Infrastrukturen in Norddeutschland.</p>
		</div>

		<div>
			<h2 class="footer__title">Leistungen</h2>
			<ul class="footer__list">
				<?php foreach ( cdn_services() as $s ) : ?>
					<li><a href="<?php echo esc_url( cdn_url_services() . '#' . $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></a></li>
				<?php endforeach; ?>
			</ul>
		</div>

		<div>
			<h2 class="footer__title">Kontakt</h2>
			<ul class="footer__list footer__list--contact">
				<?php if ( cdn_contact( 'email' ) ) : ?>
					<li><?php echo cdn_icon( 'mail', 18 ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( antispambot( cdn_contact( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( cdn_contact( 'email' ) ) ); ?></a></li>
				<?php endif; ?>
				<?php if ( cdn_contact( 'phone' ) ) : ?>
					<li><?php echo cdn_icon( 'phone', 18 ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', cdn_contact( 'phone' ) ) ); ?>"><?php echo esc_html( cdn_contact( 'phone' ) ); ?></a></li>
				<?php endif; ?>
				<li><?php echo cdn_icon( 'pin', 18 ); // phpcs:ignore ?><span><?php echo esc_html( trim( cdn_contact( 'address' ) . ' ' . cdn_contact( 'city' ) ) ); ?></span></li>
				<?php if ( cdn_contact( 'linkedin' ) ) : ?>
					<li><?php echo cdn_icon( 'users', 18 ); // phpcs:ignore ?><a href="<?php echo esc_url( cdn_contact( 'linkedin' ) ); ?>" rel="noopener" target="_blank">LinkedIn</a></li>
				<?php endif; ?>
			</ul>
		</div>

		<div>
			<h2 class="footer__title">Unternehmen</h2>
			<ul class="footer__list">
				<li><a href="<?php echo esc_url( cdn_url_about() ); ?>">Über uns</a></li>
				<li><a href="<?php echo esc_url( cdn_url_contact() ); ?>">Kontakt</a></li>
				<li><a href="<?php echo esc_url( cdn_url_imprint() ); ?>">Impressum</a></li>
				<li><a href="<?php echo esc_url( cdn_url_privacy() ); ?>">Datenschutz</a></li>
			</ul>
		</div>
	</div>

	<div class="footer__bar">
		<div class="container footer__bar-inner">
			<span>© <?php echo esc_html( wp_date( 'Y' ) ); ?> Cyber Defence Nord. Alle Rechte vorbehalten.</span>
			<a href="#top" class="footer__top">Nach oben <?php echo cdn_icon( 'arrow', 16 ); // phpcs:ignore ?></a>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
