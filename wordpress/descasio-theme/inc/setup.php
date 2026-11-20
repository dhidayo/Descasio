<?php
/**
 * Theme supports, menus and editor settings.
 *
 * @package Descasio
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'descasio', DESCASIO_DIR . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script', 'navigation-widgets' ) );
		add_theme_support( 'responsive-embeds' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
		add_editor_style( 'assets/css/descasio.css' );

		register_nav_menus(
			array(
				'primary'           => __( 'Main navigation', 'descasio' ),
				'footer-solutions'  => __( 'Footer: Solutions', 'descasio' ),
				'footer-company'    => __( 'Footer: Company', 'descasio' ),
				'footer-resources'  => __( 'Footer: Resources', 'descasio' ),
			)
		);
	}
);

/** Builder pages should span the full width; Elementor reads this. */
add_action(
	'after_setup_theme',
	function () {
		$GLOBALS['content_width'] = 1152;
	},
	0
);

/** British spelling and en-GB language attribute are set in Settings > General; this marks pages edited in a builder. */
add_filter(
	'body_class',
	function ( $classes ) {
		if ( is_singular() && descasio_is_builder_page() ) {
			$classes[] = 'de-builder-page';
		}
		return $classes;
	}
);

/** Excerpt length and "more" text that match the blog cards. */
add_filter( 'excerpt_length', fn() => 28 );
add_filter( 'excerpt_more', fn() => '…' );

/**
 * Builder pages are already fully structured. Automatic paragraphs would wrap rows in stray <p> and <br>
 * tags and add gaps between sections, so they are switched off for these pages only.
 */
add_filter(
	'the_content',
	function ( $content ) {
		if ( in_the_loop() && descasio_is_builder_page() && has_filter( 'the_content', 'wpautop' ) ) {
			remove_filter( 'the_content', 'wpautop' );
			add_filter( 'the_content', 'shortcode_unautop', 9 );
		}
		return $content;
	},
	1
);
