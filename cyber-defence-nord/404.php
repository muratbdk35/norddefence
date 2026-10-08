<?php get_header(); ?>
<section class="section notfound"><div class="container container--narrow" style="text-align:center">
	<p class="eyebrow">Fehler 404</p>
	<h1>Diese Seite wurde nicht gefunden.</h1>
	<p>Die Adresse existiert nicht (mehr). Nutzen Sie die Suche oder gehen Sie zurück zur Startseite.</p>
	<?php get_search_form(); ?>
	<p><a class="btn btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>">Zur Startseite</a></p>
</div></section>
<?php get_footer();
