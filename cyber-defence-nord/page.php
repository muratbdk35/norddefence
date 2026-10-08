<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<header class="page-hero"><div class="container"><h1><?php the_title(); ?></h1></div></header>
	<section class="section"><div class="container container--narrow"><div class="prose"><?php the_content(); ?></div></div></section>
<?php endwhile; ?>
<?php get_footer();
