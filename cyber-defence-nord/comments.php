<?php if ( post_password_required() ) { return; } ?>
<section class="comments" id="comments">
	<?php if ( have_comments() ) : ?>
		<h2>Kommentare</h2>
		<ol class="comments__list"><?php wp_list_comments( array( 'style' => 'ol', 'short_ping' => true ) ); ?></ol>
	<?php endif; ?>
	<?php comment_form(); ?>
</section>
