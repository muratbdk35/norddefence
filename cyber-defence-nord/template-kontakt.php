<?php
/**
 * Template Name: Kontakt
 */
get_header(); ?>
<header class="page-hero"><div class="container"><p class="eyebrow eyebrow--light"><?php cdn_e( 'Kontakt', 'Contact' ); ?></p><h1><?php echo esc_html( cdn_view() ? cdn_t( "Kontakt", "Contact" ) : get_the_title() ); ?></h1><p><?php cdn_e( 'Wir freuen uns auf Ihre Nachricht – vertraulich und unverbindlich.', 'We look forward to your message – confidential and without obligation.' ); ?></p></div></header>
<section class="section">
	<div class="container split split--form">
		<div class="prose">
			<?php if ( ! cdn_view() ) { while ( have_posts() ) : the_post(); the_content(); endwhile; } ?>
			<ul class="contact-list">
				<?php if ( cdn_contact( 'email' ) ) : ?><li><?php echo cdn_icon( 'mail', 22 ); // phpcs:ignore ?><a href="mailto:<?php echo esc_attr( antispambot( cdn_contact( 'email' ) ) ); ?>"><?php echo esc_html( antispambot( cdn_contact( 'email' ) ) ); ?></a></li><?php endif; ?>
				<?php if ( cdn_contact( 'phone' ) ) : ?><li><?php echo cdn_icon( 'phone', 22 ); // phpcs:ignore ?><a href="tel:<?php echo esc_attr( preg_replace( '/[^\d+]/', '', cdn_contact( 'phone' ) ) ); ?>"><?php echo esc_html( cdn_contact( 'phone' ) ); ?></a></li><?php endif; ?>
				<li><?php echo cdn_icon( 'pin', 22 ); // phpcs:ignore ?><span><?php echo esc_html( trim( cdn_contact( 'address' ) . ' ' . cdn_contact( 'city' ) ) ); ?></span></li>
			</ul>
		</div>
		<div class="panel"><?php cdn_contact_form(); ?></div>
	</div>
</section>
<?php get_footer();
