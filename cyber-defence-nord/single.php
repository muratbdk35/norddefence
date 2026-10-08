<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<header class="page-hero"><div class="container">
		<p class="eyebrow eyebrow--light"><?php echo esc_html( get_the_date() ); ?></p>
		<h1><?php the_title(); ?></h1>
	</div></header>
	<section class="section"><div class="container container--narrow">
		<article class="prose"><?php the_content(); ?></article>
		<?php if ( comments_open() || get_comments_number() ) { comments_template(); } ?>
	</div></section>
<?php endwhile; ?>
<?php get_footer();
