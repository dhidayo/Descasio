<?php
/**
 * Template Name: Full width (no title)
 * Template Post Type: page, post
 *
 * Content spans the full width with no page title. Use it for pages laid out with Descasio elements.
 *
 * @package Descasio
 */

get_header();
while ( have_posts() ) :
	the_post();
	the_content();
endwhile;
get_footer();
