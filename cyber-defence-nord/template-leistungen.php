<?php
/**
 * Template Name: Leistungen
 */
get_header(); ?>
<header class="page-hero"><div class="container"><p class="eyebrow eyebrow--light">Leistungen</p><h1><?php the_title(); ?></h1><p>Alle Bausteine für Ihre Cyber-Resilienz – aus einer Hand.</p></div></header>
<section class="section">
	<div class="container">
		<nav class="jump" aria-label="Leistungen">
			<?php foreach ( cdn_services() as $s ) : ?><a href="#<?php echo esc_attr( $s['id'] ); ?>"><?php echo esc_html( $s['title'] ); ?></a><?php endforeach; ?>
		</nav>
		<?php foreach ( cdn_services() as $i => $s ) : ?>
			<article class="service<?php echo $i % 2 ? ' service--alt' : ''; ?>" id="<?php echo esc_attr( $s['id'] ); ?>">
				<div class="service__head">
					<span class="card__icon card__icon--lg"><?php echo cdn_icon( $s['icon'], 34 ); // phpcs:ignore ?></span>
					<h2><?php echo esc_html( $s['title'] ); ?></h2>
					<p><?php echo esc_html( $s['long'] ); ?></p>
					<a class="btn btn--primary" href="<?php echo esc_url( cdn_url_contact() ); ?>">Beratung anfragen <?php echo cdn_icon( 'arrow', 18 ); // phpcs:ignore ?></a>
				</div>
				<ul class="ticks">
					<?php foreach ( $s['points'] as $pt ) : ?><li><?php echo cdn_icon( 'check', 20 ); // phpcs:ignore ?><span><?php echo esc_html( $pt ); ?></span></li><?php endforeach; ?>
				</ul>
			</article>
		<?php endforeach; ?>
	</div>
</section>
<?php get_footer();
