<?php
/**
 * Latest blog posts as glass cards.
 *
 * @package DescasioElements
 */

defined( 'ABSPATH' ) || exit;

return array(
	'title'  => __( 'Latest Posts', 'descasio-elements' ),
	'icon'   => 'eicon-posts-grid',
	'fields' => array(
		de_f( 'title', __( 'Headline (optional)', 'descasio-elements' ), 'text', 'Latest thinking.' ),
		de_f( 'count', __( 'Number of posts', 'descasio-elements' ), 'number', 3 ),
		de_f( 'category', __( 'Category slug (optional)', 'descasio-elements' ), 'text', '' ),
	),
	'render' => function ( array $d ): string {
		$q = new WP_Query(
			array(
				'posts_per_page'      => max( 1, min( 24, (int) $d['count'] ) ),
				'category_name'       => sanitize_title( $d['category'] ),
				'ignore_sticky_posts' => true,
				'no_found_rows'       => true,
			)
		);
		ob_start();
		echo '<section class="mx-auto max-w-6xl px-4 py-16">';
		if ( $d['title'] ) {
			echo '<div ' . descasio_reveal() . '>' . descasio_section_heading( $d['title'] ) . '</div>'; // phpcs:ignore
		}
		echo '<div class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">';
		$i = 0;
		while ( $q->have_posts() ) {
			$q->the_post();
			get_template_part( 'template-parts/card', null, array( 'delay' => ( $i++ % 3 ) * 0.06 ) );
		}
		wp_reset_postdata();
		echo '</div></section>';
		return ob_get_clean();
	},
);
