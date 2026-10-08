<?php get_header(); ?>
<?php while ( have_posts() ) : the_post(); ?>
	<header class="page-hero"><div class="container"><p class="eyebrow eyebrow--light">Cyber Defence Nord</p><h1><?php the_title(); ?></h1></div></header>
	<section class="section section--page">
		<div class="container page-layout">
			<aside class="toc" aria-label="Inhalt dieser Seite" hidden>
				<p class="toc__title">Auf dieser Seite</p>
				<ol class="toc__list"></ol>
			</aside>
			<div class="prose" id="page-content"><?php the_content(); ?></div>
		</div>
	</section>
<?php endwhile; ?>
<?php get_footer();
