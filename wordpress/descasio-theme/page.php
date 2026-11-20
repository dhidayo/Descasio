<?php
/**
 * Pages. Pages built with Elementor or WPBakery render full width, exactly as designed in the builder.
 * Ordinary pages use the article layout (page hero plus readable text).
 *
 * @package Descasio
 */

get_header();

while ( have_posts() ) :
	the_post();
	if ( descasio_is_builder_page() ) {
		the_content();
	} else {
		get_template_part( 'template-parts/article' );
	}
endwhile;

get_footer();
