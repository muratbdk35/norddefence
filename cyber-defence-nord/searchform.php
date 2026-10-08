<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="s">Suche</label>
	<input type="search" id="s" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="Suchbegriff eingeben …">
	<button type="submit" class="btn btn--primary btn--sm">Suchen</button>
</form>
