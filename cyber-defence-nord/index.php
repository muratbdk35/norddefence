<?php get_header(); ?>
<header class="page-hero"><div class="container">
	<h1><?php
	if ( is_search() ) { printf( 'Suchergebnisse für „%s“', esc_html( get_search_query() ) ); }
	elseif ( is_archive() ) { echo wp_kses_post( get_the_archive_title() ); }
	else { echo 'Aktuelles'; }
	?></h1>
</div></header>
<section class="section"><div class="container">
	<?php if ( have_posts() ) : ?>
		<div class="cards">
			<?php while ( have_posts() ) : the_post(); ?>
				<a class="card" href="<?php the_permalink(); ?>">
					<span class="card__meta"><?php echo esc_html( get_the_date() ); ?></span>
					<h3><?php the_title(); ?></h3>
					<p><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28, '…' ) ); ?></p>
					<span class="card__more">Weiterlesen <?php echo cdn_icon( 'arrow', 16 ); // phpcs:ignore ?></span>
				</a>
			<?php endwhile; ?>
		</div>
		<div class="pagination"><?php the_posts_pagination( array( 'mid_size' => 1, 'prev_text' => '←', 'next_text' => '→' ) ); ?></div>
	<?php else : ?>
		<p>Keine Beiträge gefunden.</p>
		<?php get_search_form(); ?>
	<?php endif; ?>
</div></section>
<?php get_footer();
